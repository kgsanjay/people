<?php
class RecruitmentController extends BaseController {
    private $jobOpeningModel;
    private $jobApplicationModel;
    private $auditLogModel;

    public function __construct() {
        $this->checkAuth();
        if ($_SESSION['user_role'] !== 'admin') { exit('Access Denied'); }
        $this->jobOpeningModel = new JobOpening();
        $this->jobApplicationModel = new JobApplication();
        $this->auditLogModel = new AuditLog();
    }

    public function index() {
        $jobs = $this->jobOpeningModel->getAll();
        $this->view('recruitment/index', ['jobs' => $jobs]);
    }

    public function create() {
        $this->view('recruitment/form', ['action' => 'create']);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->jobOpeningModel->create($_POST)) {
                $this->auditLogModel->logAction($_SESSION['user_id'], 'CREATE_JOB', "Created job opening: " . $_POST['title']);
            }
        }
        $this->redirect('/recruitment');
    }

    public function pipeline($job_id) {
        $job = $this->jobOpeningModel->findById($job_id);
        $applications = $this->jobApplicationModel->getForJob($job_id);
        $this->view('recruitment/pipeline', ['job' => $job, 'applications' => $applications]);
    }

    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->jobApplicationModel->updateStatus($_POST['application_id'], $_POST['status'])) {
                $this->auditLogModel->logAction($_SESSION['user_id'], 'UPDATE_APPLICATION_STATUS', "Updated status for application ID " . $_POST['application_id'] . " to " . $_POST['status']);
            }
        }
        $this->redirect('/recruitment/pipeline/' . $_POST['job_id']);
    }
}
?>
