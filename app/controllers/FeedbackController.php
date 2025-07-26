<?php
class FeedbackController extends BaseController {
    private $feedbackModel;
    private $employeeModel;
    private $notificationModel;

    public function __construct() {
        $this->checkAuth();
        $this->feedbackModel = new Feedback();
        $this->employeeModel = new Employee();
        $this->notificationModel = new Notification();
    }

    public function index() {
        $received = $this->feedbackModel->getReceived($_SESSION['user_id']);
        $given = $this->feedbackModel->getGiven($_SESSION['user_id']);
        $requests = $this->feedbackModel->getRequestsForUser($_SESSION['user_id']);
        $this->view('feedback/index', ['received' => $received, 'given' => $given, 'requests' => $requests]);
    }

    public function team() {
        if ($_SESSION['user_role'] === 'employee') { exit('Access Denied'); }
        $team_feedback = $this->feedbackModel->getForTeam($_SESSION['user_id']);
        $this->view('feedback/team_feedback', ['feedback' => $team_feedback]);
    }

    public function request() {
        $employees = $this->employeeModel->getAll();
        $this->view('feedback/request', ['employees' => $employees]);
    }

    public function storeRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->feedbackModel->request($_SESSION['user_id'], $_POST['provider_id'], $_POST['context'])) {
                $message = $_SESSION['user_name'] . " has requested feedback from you.";
                $this->notificationModel->create($_POST['provider_id'], $message, "/feedback");
            }
        }
        $this->redirect('/feedback');
    }

    public function give($receiver_id = null, $request_id = null) {
        $employees = $this->employeeModel->getAll();
        $this->view('feedback/give', ['employees' => $employees, 'receiver_id' => $receiver_id, 'request_id' => $request_id]);
    }

    public function storeFeedback() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $is_public = isset($_POST['is_public']) ? 1 : 0;
            $request_id = empty($_POST['request_id']) ? null : $_POST['request_id'];

            if ($this->feedbackModel->give($_SESSION['user_id'], $_POST['receiver_id'], $_POST['content'], $is_public, $request_id)) {
                $message = $_SESSION['user_name'] . " has given you feedback.";
                $this->notificationModel->create($_POST['receiver_id'], $message, "/feedback");
            }
        }
        $this->redirect('/feedback');
    }
}
?>
