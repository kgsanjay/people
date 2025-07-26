<?php
class CasesController extends BaseController {
    private $caseModel;
    private $employeeModel;
    private $notificationModel;

    public function __construct() {
        $this->checkAuth();
        $this->caseModel = new CaseModel();
        $this->employeeModel = new Employee();
        $this->notificationModel = new Notification();
    }

    // Admin view to manage all cases
    public function index() {
        if ($_SESSION['user_role'] === 'employee') {
            $this->redirect('/cases/myCases');
        }
        $cases = $this->caseModel->getAll();
        $admins = $this->employeeModel->getAdminsAndManagers();
        $this->view('cases/index', ['cases' => $cases, 'admins' => $admins]);
    }

    // Employee view to see their own cases
    public function myCases() {
        $cases = $this->caseModel->getForEmployee($_SESSION['user_id']);
        $this->view('cases/my_cases', ['cases' => $cases]);
    }

    public function create() {
        $this->view('cases/create');
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $data['employee_id'] = $_SESSION['user_id'];
            if ($this->caseModel->create($data)) {
                // Notify all admins/managers
                $admins = $this->employeeModel->getAdminsAndManagers();
                $message = "A new case '" . htmlspecialchars($data['subject']) . "' has been submitted by " . $_SESSION['user_name'] . ".";
                $link = "/cases";
                foreach ($admins as $admin) {
                    $this->notificationModel->create($admin['id'], $message, $link);
                }
            }
            $this->redirect('/cases/myCases');
        }
    }

    public function update() {
        if ($_SESSION['user_role'] === 'employee') { exit('Access Denied'); }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $case_id = $_POST['case_id'];
            $status = $_POST['status'];
            $assigned_to = $_POST['assigned_to'];
            
            $case = $this->caseModel->findById($case_id);
            if ($this->caseModel->updateStatusAndAssignment($case_id, $status, $assigned_to)) {
                // Notify employee of status change
                $message = "The status of your case '" . htmlspecialchars($case['subject']) . "' has been updated to " . ucfirst($status) . ".";
                $link = "/cases/myCases";
                $this->notificationModel->create($case['employee_id'], $message, $link);

                // Notify newly assigned user
                if ($assigned_to && $assigned_to != $case['assigned_to']) {
                    $message = "You have been assigned a new case: '" . htmlspecialchars($case['subject']) . "'.";
                    $this->notificationModel->create($assigned_to, $message, "/cases");
                }
            }
        }
        $this->redirect('/cases');
    }
}
?>