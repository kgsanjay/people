<?php
class TimesheetController extends BaseController {
    private $timesheetModel;
    private $projectModel;
    private $submissionModel;
    private $workflowModel;
    private $approvalModel;
    private $employeeModel;
    private $notificationModel;
    private $auditLogModel;

    public function __construct() {
        $this->checkAuth();
        $this->timesheetModel = new Timesheet();
        $this->projectModel = new Project();
        $this->submissionModel = new TimesheetSubmission();
        $this->workflowModel = new Workflow();
        $this->approvalModel = new ApprovalRequest();
        $this->employeeModel = new Employee();
        $this->notificationModel = new Notification();
        $this->auditLogModel = new AuditLog();
    }

    public function index() {
        $timesheets = $this->timesheetModel->getForEmployee($_SESSION['user_id']);
        $unsubmitted = $this->timesheetModel->getUnsubmittedForEmployee($_SESSION['user_id']);
        $this->view('timesheets/index', ['timesheets' => $timesheets, 'unsubmitted' => $unsubmitted]);
    }

    public function create() {
        $projects = $this->projectModel->getAll();
        $this->view('timesheets/form', ['projects' => $projects]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $data['employee_id'] = $_SESSION['user_id'];
            if ($this->timesheetModel->create($data)) {
                $this->auditLogModel->logAction($_SESSION['user_id'], 'CREATE_TIMESHEET_ENTRY', "Logged " . $data['hours'] . " hours for project ID " . $data['project_id']);
            }
        }
        $this->redirect('/timesheet');
    }

    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $unsubmitted = $this->timesheetModel->getUnsubmittedForEmployee($_SESSION['user_id']);
            if (!empty($unsubmitted)) {
                $total_hours = array_sum(array_column($unsubmitted, 'hours'));
                $start_date = min(array_column($unsubmitted, 'work_date'));
                $end_date = max(array_column($unsubmitted, 'work_date'));

                $submission_id = $this->submissionModel->create($_SESSION['user_id'], $start_date, $end_date, $total_hours);
                $this->timesheetModel->submitEntries($_SESSION['user_id'], $submission_id);
                $this->auditLogModel->logAction($_SESSION['user_id'], 'SUBMIT_TIMESHEET', "Submitted timesheet for period " . $start_date . " to " . $end_date);

                // Start workflow
                $workflow = $this->workflowModel->getByType('timesheet');
                if ($workflow) {
                    $steps = $this->workflowModel->getSteps($workflow['id']);
                    if (!empty($steps)) {
                        $first_step = $steps[0];
                        $approver_id = $this->findApprover($_SESSION['user_id'], $first_step['approver_role']);
                        if ($approver_id) {
                            $this->approvalModel->create('timesheet', $submission_id, $first_step['id'], $approver_id);
                            $this->submissionModel->updateOverallStatus($submission_id, 'pending (' . $first_step['step_name'] . ')');
                            $message = "New timesheet from " . $_SESSION['user_name'] . " is waiting for your approval.";
                            $this->notificationModel->create($approver_id, $message, "/approvals");
                        }
                    }
                }
            }
        }
        $this->redirect('/timesheet');
    }

    private function findApprover($employee_id, $role) {
        $employee = $this->employeeModel->findById($employee_id);
        if ($role === 'manager' && $employee['reports_to']) {
            return $employee['reports_to'];
        }
        $admins = $this->employeeModel->getAdminsAndManagers();
        return $admins[0]['id'] ?? null;
    }

    public function processApproval($approval_id, $decision) {
        if ($_SESSION['user_role'] === 'employee') { exit('Access Denied'); }

        $this->approvalModel->updateStatus($approval_id, $decision, $_SESSION['user_id']);
        $approval_request = $this->approvalModel->findById($approval_id);
        $submission = $this->submissionModel->findById($approval_request['request_id']);

        if ($decision === 'rejected') {
            $this->submissionModel->updateOverallStatus($submission['id'], 'rejected');
            $message = "Your timesheet for " . $submission['start_date'] . " - " . $submission['end_date'] . " has been rejected.";
            $this->notificationModel->create($submission['employee_id'], $message, "/timesheet");
            $this->auditLogModel->logAction($_SESSION['user_id'], 'REJECT_TIMESHEET', "Rejected timesheet ID: " . $submission['id']);
        } else { // Approved
            $workflow = $this->workflowModel->getByType('timesheet');
            $steps = $this->workflowModel->getSteps($workflow['id']);
            $current_step_order = -1;
            foreach ($steps as $index => $step) {
                if ($step['id'] == $approval_request['workflow_step_id']) {
                    $current_step_order = $index;
                    break;
                }
            }

            if (isset($steps[$current_step_order + 1])) {
                $next_step = $steps[$current_step_order + 1];
                $next_approver_id = $this->findApprover($submission['employee_id'], $next_step['approver_role']);
                if ($next_approver_id) {
                    $this->approvalModel->create('timesheet', $submission['id'], $next_step['id'], $next_approver_id);
                    $this->submissionModel->updateOverallStatus($submission['id'], 'pending (' . $next_step['step_name'] . ')');
                    $message = "A timesheet is now waiting for your approval.";
                    $this->notificationModel->create($next_approver_id, $message, "/approvals");
                }
            } else {
                $this->submissionModel->updateOverallStatus($submission['id'], 'approved');
                $message = "Your timesheet for " . $submission['start_date'] . " - " . $submission['end_date'] . " has been fully approved.";
                $this->notificationModel->create($submission['employee_id'], $message, "/timesheet");
                $this->auditLogModel->logAction($_SESSION['user_id'], 'APPROVE_TIMESHEET', "Approved timesheet ID: " . $submission['id']);
            }
        }
        $this->redirect('/approvals');
    }
}
?>
