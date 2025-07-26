<?php
class WorkflowController extends BaseController {
    private $workflowModel;
    private $auditLogModel;

    public function __construct() {
        $this->checkAuth();
        if ($_SESSION['user_role'] !== 'admin') { exit('Access Denied'); }
        $this->workflowModel = new Workflow();
        $this->auditLogModel = new AuditLog();
    }

    public function index() {
        $this->view('workflow/index');
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $workflow_id = $this->workflowModel->create($_POST['name'], $_POST['type']);
            if ($workflow_id && isset($_POST['steps'])) {
                foreach ($_POST['steps'] as $index => $step) {
                    if (!empty($step['name'])) {
                        $this->workflowModel->addStep($workflow_id, $step['name'], $step['role'], $index + 1);
                    }
                }
                $this->auditLogModel->logAction($_SESSION['user_id'], 'CREATE_WORKFLOW', "Created workflow: " . $_POST['name']);
            }
        }
        $this->redirect('/settings'); // Redirect to settings as workflows are managed there now conceptually
    }
}
?>
