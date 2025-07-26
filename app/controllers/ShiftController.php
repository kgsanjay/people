<?php
class ShiftController extends BaseController {
    private $shiftModel;
    private $employeeShiftModel;
    private $employeeModel;
    private $notificationModel;
    private $auditLogModel;

    public function __construct() {
        $this->checkAuth();
        $this->shiftModel = new Shift();
        $this->employeeShiftModel = new EmployeeShift();
        $this->employeeModel = new Employee();
        $this->notificationModel = new Notification();
        $this->auditLogModel = new AuditLog();
    }

    // Admin view to manage shift types
    public function index() {
        if ($_SESSION['user_role'] !== 'admin') {
            $this->redirect('/shift/mySchedule');
        }
        $shifts = $this->shiftModel->getAll();
        $assignments = $this->employeeShiftModel->getAllAssignments();
        $this->view('shifts/index', ['shifts' => $shifts, 'assignments' => $assignments]);
    }

    // Employee view to see their schedule
    public function mySchedule() {
        $schedule = $this->employeeShiftModel->getForEmployee($_SESSION['user_id']);
        $this->view('shifts/my_schedule', ['schedule' => $schedule]);
    }
    
    public function create() {
        if ($_SESSION['user_role'] !== 'admin') {
            echo "Access Denied"; exit();
        }
        $this->view('shifts/form', ['action' => 'create']);
    }

    public function store() {
        if ($_SESSION['user_role'] !== 'admin') {
            echo "Access Denied"; exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->shiftModel->create($_POST)) {
                $this->auditLogModel->logAction($_SESSION['user_id'], 'CREATE_SHIFT', "Created shift type: " . $_POST['name']);
            }
        }
        $this->redirect('/shift');
    }

    public function edit($id) {
        if ($_SESSION['user_role'] !== 'admin') {
            echo "Access Denied"; exit();
        }
        $shift = $this->shiftModel->findById($id);
        $this->view('shifts/form', ['action' => 'edit', 'shift' => $shift]);
    }

    public function update($id) {
        if ($_SESSION['user_role'] !== 'admin') {
            echo "Access Denied"; exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->shiftModel->update($id, $_POST)) {
                $this->auditLogModel->logAction($_SESSION['user_id'], 'UPDATE_SHIFT', "Updated shift type ID: " . $id);
            }
        }
        $this->redirect('/shift');
    }

    public function delete($id) {
        if ($_SESSION['user_role'] !== 'admin') {
            echo "Access Denied"; exit();
        }
        $shift = $this->shiftModel->findById($id);
        if ($this->shiftModel->delete($id)) {
            $this->auditLogModel->logAction($_SESSION['user_id'], 'DELETE_SHIFT', "Deleted shift type: " . $shift['name']);
        }
        $this->redirect('/shift');
    }
    
    // View for assigning shifts
    public function assign() {
        if ($_SESSION['user_role'] !== 'admin') {
            echo "Access Denied"; exit();
        }
        $employees = $this->employeeModel->getAll();
        $shifts = $this->shiftModel->getAll();
        $this->view('shifts/assign', ['employees' => $employees, 'shifts' => $shifts]);
    }
    
    // Logic to store shift assignment
    public function storeAssignment() {
        if ($_SESSION['user_role'] !== 'admin') {
            echo "Access Denied"; exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->employeeShiftModel->assign($_POST)) {
                // Notify employee
                $shift = $this->shiftModel->findById($_POST['shift_id']);
                $message = "You have been assigned to the '" . $shift['name'] . "' shift from " . $_POST['start_date'] . " to " . $_POST['end_date'] . ".";
                $link = "/shift/mySchedule";
                $this->notificationModel->create($_POST['employee_id'], $message, $link);
                $this->auditLogModel->logAction($_SESSION['user_id'], 'ASSIGN_SHIFT', "Assigned employee ID " . $_POST['employee_id'] . " to shift ID " . $_POST['shift_id']);
            }
        }
        $this->redirect('/shift');
    }
}
?>
