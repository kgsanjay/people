<?php
class LeaveController extends BaseController {
    private $leaveModel;
    private $leaveTypeModel;
    private $workflowModel;
    private $approvalModel;
    private $employeeModel;
    private $notificationModel;

    public function __construct() {
        $this->leaveModel = new LeaveRequest();
        $this->leaveTypeModel = new LeaveType();
        $this->workflowModel = new Workflow();
        $this->approvalModel = new ApprovalRequest();
        $this->employeeModel = new Employee();
        $this->notificationModel = new Notification();
    }

    public function index() {
        $this->authorize();
        $leaves = $this->leaveModel->getForEmployee($_SESSION['user_id']);
        $this->view('leaves/index', ['leaves' => $leaves]);
    }

    public function create() {
        $this->authorize();
        $leave_types = $this->leaveTypeModel->getAll();
        $this->view('leaves/create', ['leave_types' => $leave_types]);
    }

    public function store() {
        $this->authorize();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $data['employee_id'] = $_SESSION['user_id'];
            $leave_id = $this->leaveModel->create($data);

            if ($leave_id) {
                // Start the workflow
                $workflow = $this->workflowModel->getByType('leave');
                if ($workflow) {
                    $steps = $this->workflowModel->getSteps($workflow['id']);
                    if (!empty($steps)) {
                        $first_step = $steps[0];
                        $approver_id = $this->findApprover($data['employee_id'], $first_step['approver_role']);
                        
                        if ($approver_id) {
                            $this->approvalModel->create('leave', $leave_id, $first_step['id'], $approver_id);
                            $this->leaveModel->updateOverallStatus($leave_id, 'pending (' . $first_step['step_name'] . ')');
                            
                            // Notify approver
                            $message = "New leave request from " . $_SESSION['user_name'] . " is waiting for your approval.";
                            $link = "/approvals";
                            $this->notificationModel->create($approver_id, $message, $link);
                        }
                    }
                }
            }
            $this->redirect('/leave');
        }
    }

    private function findApprover($employee_id, $role) {
        $employee = $this->employeeModel->findById($employee_id);
        if ($role === 'manager' && $employee['reports_to']) {
            return $employee['reports_to'];
        }
        // Fallback to any admin/manager if direct manager not found or for other roles
        $admins = $this->employeeModel->getAdminsAndManagers();
        return $admins[0]['id'] ?? null;
    }

    public function processApproval($approval_id, $decision) {
        $this->authorize(['admin', 'manager']);

        // 1. Update the current approval request status
        $this->approvalModel->updateStatus($approval_id, $decision, $_SESSION['user_id']);
        $approval_request = $this->approvalModel->findById($approval_id);
        $leave_request = $this->leaveModel->findById($approval_request['request_id']);

        if ($decision === 'rejected') {
            // 2. If rejected, update the main request and notify employee
            $this->leaveModel->updateOverallStatus($leave_request['id'], 'rejected');
            $message = "Your leave request from " . $leave_request['start_date'] . " has been rejected.";
            $this->notificationModel->create($leave_request['employee_id'], $message, "/leave");
        } else { // Approved
            // 3. Find the next step in the workflow
            $workflow = $this->workflowModel->getByType('leave');
            $steps = $this->workflowModel->getSteps($workflow['id']);
            $current_step_order = -1;
            foreach ($steps as $index => $step) {
                if ($step['id'] == $approval_request['workflow_step_id']) {
                    $current_step_order = $index;
                    break;
                }
            }

            if (isset($steps[$current_step_order + 1])) {
                // 4. If there is a next step, create a new approval request
                $next_step = $steps[$current_step_order + 1];
                $next_approver_id = $this->findApprover($leave_request['employee_id'], $next_step['approver_role']);
                if ($next_approver_id) {
                    $this->approvalModel->create('leave', $leave_request['id'], $next_step['id'], $next_approver_id);
                    $this->leaveModel->updateOverallStatus($leave_request['id'], 'pending (' . $next_step['step_name'] . ')');
                    $message = "A leave request from " . $_SESSION['user_name'] . " has been approved and is now waiting for your approval.";
                    $this->notificationModel->create($next_approver_id, $message, "/approvals");
                }
            } else {
                // 5. If this was the final step, update the main request to 'approved'
                $this->leaveModel->updateOverallStatus($leave_request['id'], 'approved');
                $message = "Your leave request from " . $leave_request['start_date'] . " has been fully approved.";
                $this->notificationModel->create($leave_request['employee_id'], $message, "/leave");
            }
        }
        $this->redirect('/approvals');
    }
}
?>
