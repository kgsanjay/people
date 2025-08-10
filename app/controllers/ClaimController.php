<?php
class ClaimController extends BaseController {
    private $claimModel;
    private $workflowModel;
    private $approvalModel;
    private $employeeModel;
    private $notificationModel;
    private $uploadDir = __DIR__ . '/../../public/uploads/';

    public function __construct() {
        $this->claimModel = new Claim();
        $this->workflowModel = new Workflow();
        $this->approvalModel = new ApprovalRequest();
        $this->employeeModel = new Employee();
        $this->notificationModel = new Notification();
    }

    public function index() {
        $this->authorize(['admin', 'manager']);
        $claims = $this->claimModel->getAll();
        $this->view('claims/index', ['claims' => $claims]);
    }

    public function myClaims() {
        $this->authorize();
        $claims = $this->claimModel->getForEmployee($_SESSION['user_id']);
        $this->view('claims/my_claims', ['claims' => $claims]);
    }

    public function create() {
        $this->authorize();
        $this->view('claims/create');
    }

    public function store() {
        $this->authorize();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $data['employee_id'] = $_SESSION['user_id'];
            $data['receipt_filename'] = null;

            if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] === UPLOAD_ERR_OK) {
                $filename = time() . '_claim_' . basename($_FILES['receipt']['name']);
                if (move_uploaded_file($_FILES['receipt']['tmp_name'], $this->uploadDir . $filename)) {
                    $data['receipt_filename'] = $filename;
                }
            }

            $claim_id = $this->claimModel->create($data);
            if ($claim_id) {
                // Start workflow
                $workflow = $this->workflowModel->getByType('claim');
                if ($workflow) {
                    $steps = $this->workflowModel->getSteps($workflow['id']);
                    if (!empty($steps)) {
                        $first_step = $steps[0];
                        $approver_id = $this->findApprover($data['employee_id'], $first_step['approver_role']);
                        if ($approver_id) {
                            $this->approvalModel->create('claim', $claim_id, $first_step['id'], $approver_id);
                            $this->claimModel->updateOverallStatus($claim_id, 'pending (' . $first_step['step_name'] . ')');
                            $message = "New claim from " . $_SESSION['user_name'] . " is waiting for your approval.";
                            $this->notificationModel->create($approver_id, $message, "/approvals");
                        }
                    }
                }
            }
            $this->redirect('/claims/myClaims');
        }
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
        $this->authorize(['admin', 'manager']);

        $this->approvalModel->updateStatus($approval_id, $decision, $_SESSION['user_id']);
        $approval_request = $this->approvalModel->findById($approval_id);
        $claim_request = $this->claimModel->findById($approval_request['request_id']);

        if ($decision === 'rejected') {
            $this->claimModel->updateOverallStatus($claim_request['id'], 'rejected');
            $message = "Your claim for '" . $claim_request['category'] . "' has been rejected.";
            $this->notificationModel->create($claim_request['employee_id'], $message, "/claims/myClaims");
        } else { // Approved
            $workflow = $this->workflowModel->getByType('claim');
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
                $next_approver_id = $this->findApprover($claim_request['employee_id'], $next_step['approver_role']);
                if ($next_approver_id) {
                    $this->approvalModel->create('claim', $claim_request['id'], $next_step['id'], $next_approver_id);
                    $this->claimModel->updateOverallStatus($claim_request['id'], 'pending (' . $next_step['step_name'] . ')');
                    $message = "A claim is now waiting for your approval.";
                    $this->notificationModel->create($next_approver_id, $message, "/approvals");
                }
            } else {
                $this->claimModel->updateOverallStatus($claim_request['id'], 'approved');
                $message = "Your claim for '" . $claim_request['category'] . "' has been fully approved.";
                $this->notificationModel->create($claim_request['employee_id'], $message, "/claims/myClaims");
            }
        }
        $this->redirect('/approvals');
    }
}
?>