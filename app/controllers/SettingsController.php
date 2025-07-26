<?php
class SettingsController extends BaseController {
    private $departmentModel;
    private $leaveTypeModel;
    private $awardModel;

    public function __construct() {
        $this->checkAuth();
        if ($_SESSION['user_role'] !== 'admin') {
            exit('Access Denied');
        }
        $this->departmentModel = new Department();
        $this->leaveTypeModel = new LeaveType();
        $this->awardModel = new Award();
    }

    public function index() {
        $departments = $this->departmentModel->getAll();
        $leave_types = $this->leaveTypeModel->getAll();
        $award_types = $this->awardModel->getAllTypes();
        $this->view('settings/index', [
            'departments' => $departments, 
            'leave_types' => $leave_types,
            'award_types' => $award_types
        ]);
    }

    // Department Actions
    public function addDepartment() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->departmentModel->create($_POST['name']);
        }
        $this->redirect('/settings');
    }

    public function deleteDepartment($id) {
        $this->departmentModel->delete($id);
        $this->redirect('/settings');
    }

    // Leave Type Actions
    public function addLeaveType() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->leaveTypeModel->create($_POST['name']);
        }
        $this->redirect('/settings');
    }

    public function deleteLeaveType($id) {
        $this->leaveTypeModel->delete($id);
        $this->redirect('/settings');
    }
    
    // Award Type Actions
    public function addAwardType() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->awardModel->createType($_POST['name']);
        }
        $this->redirect('/settings');
    }

    public function deleteAwardType($id) {
        $this->awardModel->deleteType($id);
        $this->redirect('/settings');
    }
}
?>
