<?php
class ExitController extends BaseController {
    private $exitModel;
    private $employeeModel;
    private $notificationModel;

    public function __construct() {
        $this->checkAuth();
        if ($_SESSION['user_role'] !== 'admin') { exit('Access Denied'); }
        $this->exitModel = new EmployeeExit();
        $this->employeeModel = new Employee();
        $this->notificationModel = new Notification();
    }

    public function index() {
        $exits = $this->exitModel->getAll();
        $this->view('exit/index', ['exits' => $exits]);
    }

    public function initiate($employee_id) {
        $employee = $this->employeeModel->findById($employee_id);
        $this->view('exit/initiate', ['employee' => $employee]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->exitModel->create($_POST)) {
                $employee = $this->employeeModel->findById($_POST['employee_id']);
                // Notify employee
                $message = "Your exit process has been formally initiated. Your last working day is set to " . $_POST['last_working_day'] . ".";
                $this->notificationModel->create($employee['id'], $message, "/employees/myProfile");
                
                // Notify manager
                if ($employee['reports_to']) {
                    $message = "The exit process for " . $employee['first_name'] . " " . $employee['last_name'] . " has been initiated.";
                    $this->notificationModel->create($employee['reports_to'], $message, "/exit");
                }
            }
        }
        $this->redirect('/exit');
    }

    public function complete($exit_id) {
        $exit = $this->exitModel->findById($exit_id);
        if ($exit) {
            $this->exitModel->updateStatus($exit_id, 'completed');
            $this->employeeModel->deactivate($exit['employee_id']);
            // Here you could also trigger the 'Offboarding' checklist
        }
        $this->redirect('/exit');
    }
}
?>