<?php
class OnboardingController extends BaseController {
    private $checklistModel;
    private $employeeChecklistModel;
    private $employeeModel;
    private $notificationModel;

    public function __construct() {
        $this->checkAuth();
        $this->checklistModel = new Checklist();
        $this->employeeChecklistModel = new EmployeeChecklist();
        $this->employeeModel = new Employee();
        $this->notificationModel = new Notification();
    }

    // Admin view to manage checklist templates
    public function index() {
        if ($_SESSION['user_role'] !== 'admin') {
            $this->redirect('/onboarding/myTasks');
        }
        $checklists = $this->checklistModel->getAll();
        $assignments = $this->employeeChecklistModel->getAssignedChecklists();
        $this->view('onboarding/index', ['checklists' => $checklists, 'assignments' => $assignments]);
    }

    // Page for any user to see tasks assigned to them
    public function myTasks() {
        $tasks = $this->employeeChecklistModel->getTasksForUser($_SESSION['user_id']);
        $this->view('onboarding/my_tasks', ['tasks' => $tasks]);
    }

    public function storeTemplate() {
        if ($_SESSION['user_role'] !== 'admin') { exit('Access Denied'); }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $checklist_id = $this->checklistModel->create($_POST['name'], $_POST['type']);
            foreach ($_POST['tasks'] as $task) {
                if (!empty($task['name'])) {
                    $this->checklistModel->addItem($checklist_id, $task['name'], $task['role']);
                }
            }
        }
        $this->redirect('/onboarding');
    }

    public function assign() {
        if ($_SESSION['user_role'] !== 'admin') { exit('Access Denied'); }
        $employees = $this->employeeModel->getAll();
        $checklists = $this->checklistModel->getAll();
        $this->view('onboarding/assign', ['employees' => $employees, 'checklists' => $checklists]);
    }

    public function storeAssignment() {
        if ($_SESSION['user_role'] !== 'admin') { exit('Access Denied'); }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $employee_id = $_POST['employee_id'];
            $checklist_id = $_POST['checklist_id'];
            
            $assignment_id = $this->employeeChecklistModel->assign($employee_id, $checklist_id);
            $items = $this->checklistModel->getItems($checklist_id);
            $admins = $this->employeeModel->getAdminsAndManagers(); // Simplified: using admins/managers for roles

            foreach ($items as $item) {
                // Simplified role-based assignment. A real app would be more complex.
                $assigned_to_id = null;
                if ($item['assigned_to_role'] === 'employee') {
                    $assigned_to_id = $employee_id;
                } elseif ($item['assigned_to_role'] === 'manager' || $item['assigned_to_role'] === 'admin') {
                    // Assign to the first admin/manager for simplicity
                    $assigned_to_id = $admins[0]['id'];
                }

                if ($assigned_to_id) {
                    $this->employeeChecklistModel->createTask($assignment_id, $item['id'], $assigned_to_id);
                    
                    // Notify the assigned user
                    $employee = $this->employeeModel->findById($employee_id);
                    $message = "New task '" . $item['task_name'] . "' for " . $employee['first_name'] . "'s onboarding.";
                    $link = "/onboarding/myTasks";
                    $this->notificationModel->create($assigned_to_id, $message, $link);
                }
            }
        }
        $this->redirect('/onboarding');
    }
    
    public function progress($assignment_id) {
        if ($_SESSION['user_role'] !== 'admin') { exit('Access Denied'); }
        $assignment = $this->employeeChecklistModel->getAssignmentDetails($assignment_id);
        $tasks = $this->employeeChecklistModel->getChecklistProgress($assignment_id);
        $this->view('onboarding/progress', ['assignment' => $assignment, 'tasks' => $tasks]);
    }
    
    public function updateTask() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->employeeChecklistModel->updateTaskStatus($_POST['task_id'], 'completed', $_SESSION['user_id']);
        }
        $this->redirect('/onboarding/myTasks');
    }
}
?>
