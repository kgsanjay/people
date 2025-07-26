<?php
class CareersController extends BaseController {
    private $jobOpeningModel;
    private $candidateModel;
    private $jobApplicationModel;
    private $notificationModel;
    private $employeeModel;
    private $uploadDir = __DIR__ . '/../../public/uploads/';

    public function __construct() {
        // This controller does not require authentication for viewing jobs
        $this->jobOpeningModel = new JobOpening();
        $this->candidateModel = new Candidate();
        $this->jobApplicationModel = new JobApplication();
        $this->notificationModel = new Notification();
        $this->employeeModel = new Employee();
    }

    public function index() {
        $jobs = $this->jobOpeningModel->getAllOpen();
        $this->view('careers/index', ['jobs' => $jobs]);
    }

    public function apply($job_id) {
        $job = $this->jobOpeningModel->findById($job_id);
        $this->view('careers/apply', ['job' => $job]);
    }

    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resume_filename = null;
            if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
                $filename = time() . '_resume_' . basename($_FILES['resume']['name']);
                if (move_uploaded_file($_FILES['resume']['tmp_name'], $this->uploadDir . $filename)) {
                    $resume_filename = $filename;
                }
            }

            $candidate_id = $this->candidateModel->create($_POST['name'], $_POST['email'], $_POST['phone'], $resume_filename);
            
            if ($candidate_id) {
                $this->jobApplicationModel->create($_POST['job_id'], $candidate_id);
                
                // Notify admins
                $admins = $this->employeeModel->getAdminsAndManagers();
                $job = $this->jobOpeningModel->findById($_POST['job_id']);
                $message = "New application from " . $_POST['name'] . " for the role '" . $job['title'] . "'.";
                $link = "/recruitment/pipeline/" . $_POST['job_id'];
                foreach ($admins as $admin) {
                    $this->notificationModel->create($admin['id'], $message, $link);
                }
            }
            // Redirect to a thank you page or back to careers
            $this->redirect('/careers');
        }
    }
}
?>