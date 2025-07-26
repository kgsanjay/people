<?php
class GoalController extends BaseController {
    private $goalModel;
    private $keyResultModel;
    private $employeeModel;
    private $notificationModel;

    public function __construct() {
        $this->checkAuth();
        $this->goalModel = new Goal();
        $this->keyResultModel = new KeyResult();
        $this->employeeModel = new Employee();
        $this->notificationModel = new Notification();
    }

    // Employee view of their own goals
    public function index() {
        $goals = $this->goalModel->getForEmployee($_SESSION['user_id']);
        foreach ($goals as &$goal) {
            $goal['key_results'] = $this->keyResultModel->getForGoal($goal['id']);
        }
        $this->view('goals/index', ['goals' => $goals]);
    }

    // Manager view of their team's goals
    public function team() {
        if ($_SESSION['user_role'] === 'employee') { exit('Access Denied'); }
        $team_members = $this->employeeModel->getDirectReports($_SESSION['user_id']);
        $goals = $this->goalModel->getForTeam($_SESSION['user_id']);
        foreach ($goals as &$goal) {
            $goal['key_results'] = $this->keyResultModel->getForGoal($goal['id']);
        }
        $this->view('goals/team_goals', ['goals' => $goals, 'team_members' => $team_members]);
    }

    public function store() {
        if ($_SESSION['user_role'] === 'employee') { exit('Access Denied'); }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $goal_id = $this->goalModel->create($_POST);
            if ($goal_id && isset($_POST['key_results'])) {
                foreach ($_POST['key_results'] as $kr_desc) {
                    if (!empty($kr_desc)) {
                        $this->keyResultModel->create($goal_id, $kr_desc);
                    }
                }
            }
            // Notify employee
            $message = "Your manager has set a new goal for you: '" . htmlspecialchars($_POST['title']) . "'.";
            $this->notificationModel->create($_POST['employee_id'], $message, "/goal");
        }
        $this->redirect('/goal/team');
    }

    public function updateProgress() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $kr_id = $_POST['kr_id'];
            $progress = $_POST['progress'];
            $this->keyResultModel->updateProgress($kr_id, $progress);
            
            // Notify manager
            $kr = $this->keyResultModel->findById($kr_id);
            $employee = $this->employeeModel->findById($_SESSION['user_id']);
            if ($employee['reports_to']) {
                $message = $_SESSION['user_name'] . " has updated progress on a key result.";
                $this->notificationModel->create($employee['reports_to'], $message, "/goal/team");
            }
        }
        $this->redirect('/goal');
    }
}
?>
