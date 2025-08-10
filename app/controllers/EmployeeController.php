<?php
class EmployeeController extends BaseController {
    private $employeeModel;
    private $employeeFileModel;
    private $awardModel;
    private $auditLogModel;
    private $uploadDir = __DIR__ . '/../../public/uploads/';

    public function __construct() {
        $this->employeeModel = new Employee();
        $this->employeeFileModel = new EmployeeFile();
        $this->awardModel = new Award();
        $this->auditLogModel = new AuditLog();
    }

    // Admin view of all employees
    public function index() {
        $this->authorize(['admin']);
        $employees = $this->employeeModel->getAll();
        $this->view('employees/index', ['employees' => $employees]);
    }

    // Admin view of a single employee's full profile
    public function profile($id) {
        $this->authorize(['admin']);
        $employee = $this->employeeModel->findById($id);
        $details = $this->employeeModel->getDetails($id);
        $dependents = $this->employeeModel->getDependents($id);
        $files = $this->employeeFileModel->getForEmployee($id);
        $awards = $this->awardModel->getForEmployee($id);
        $award_types = $this->awardModel->getAllTypes();
        $this->view('employees/profile', [
            'employee' => $employee,
            'details' => $details,
            'dependents' => $dependents,
            'files' => $files,
            'awards' => $awards,
            'award_types' => $award_types
        ]);
    }

    // Employee self-service profile view
    public function myProfile() {
        $this->authorize();
        $id = $_SESSION['user_id'];
        $employee = $this->employeeModel->findById($id);
        $details = $this->employeeModel->getDetails($id);
        $dependents = $this->employeeModel->getDependents($id);
        $files = $this->employeeFileModel->getForEmployee($id);
        $awards = $this->awardModel->getForEmployee($id);
        $this->view('employees/my_profile', [
            'employee' => $employee,
            'details' => $details,
            'dependents' => $dependents,
            'files' => $files,
            'awards' => $awards
        ]);
    }

    public function create() {
        $this->authorize(['admin']);
        $employees = $this->employeeModel->getAll();
        $this->view('employees/form', ['action' => 'create', 'employees' => $employees]);
    }

    public function store() {
        $this->authorize(['admin']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->employeeModel->create($_POST)) {
                $details = "Created new employee: " . $_POST['first_name'] . " " . $_POST['last_name'] . " (" . $_POST['email'] . ").";
                $this->auditLogModel->logAction($_SESSION['user_id'], 'CREATE_EMPLOYEE', $details);
            }
            $this->redirect('/employees');
        }
    }

    public function edit($id) {
        $this->authorize(['admin']);
        $employee = $this->employeeModel->findById($id);
        $employees = $this->employeeModel->getAll();
        $this->view('employees/form', ['action' => 'edit', 'employee' => $employee, 'employees' => $employees]);
    }

    public function update($id) {
        $this->authorize(['admin']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->employeeModel->update($id, $_POST)) {
                $details = "Updated employee details for ID: " . $id . ".";
                $this->auditLogModel->logAction($_SESSION['user_id'], 'UPDATE_EMPLOYEE', $details);
            }
            $this->redirect('/employees');
        }
    }

    public function delete($id) {
        $this->authorize(['admin']);
        $employee = $this->employeeModel->findById($id);
        if ($this->employeeModel->delete($id)) {
            $details = "Deleted employee: " . $employee['first_name'] . " " . $employee['last_name'] . " (ID: " . $id . ").";
            $this->auditLogModel->logAction($_SESSION['user_id'], 'DELETE_EMPLOYEE', $details);
        }
        $this->redirect('/employees');
    }

    public function updateDetails() {
        $this->authorize(['admin']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->employeeModel->createOrUpdateDetails($_POST);
            $this->auditLogModel->logAction($_SESSION['user_id'], 'UPDATE_PROFILE', 'Updated personal details for employee ID: ' . $_POST['employee_id']);
            $this->redirect('/employees/profile/' . $_POST['employee_id']);
        }
    }

    public function addDependent() {
        $this->authorize(['admin']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->employeeModel->addDependent($_POST);
            $this->auditLogModel->logAction($_SESSION['user_id'], 'ADD_DEPENDENT', 'Added dependent for employee ID: ' . $_POST['employee_id']);
            $this->redirect('/employees/profile/' . $_POST['employee_id']);
        }
    }

    public function deleteDependent($employee_id, $dependent_id) {
        $this->authorize(['admin']);
        $this->employeeModel->deleteDependent($dependent_id);
        $this->auditLogModel->logAction($_SESSION['user_id'], 'DELETE_DEPENDENT', 'Deleted dependent ID: ' . $dependent_id . ' for employee ID: ' . $employee_id);
        $this->redirect('/employees/profile/' . $employee_id);
    }

    public function uploadFile() {
        $this->authorize(['admin']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['employee_file'])) {
            $employee_id = $_POST['employee_id'];
            $title = $_POST['title'];
            $file = $_FILES['employee_file'];

            if ($file['error'] === UPLOAD_ERR_OK && !empty($title)) {
                $filename = time() . '_emp_' . $employee_id . '_' . basename($file['name']);
                $targetPath = $this->uploadDir . $filename;

                if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                    $this->employeeFileModel->create($employee_id, $title, $filename);
                    $this->auditLogModel->logAction($_SESSION['user_id'], 'UPLOAD_EMP_FILE', "Uploaded file '" . $title . "' for employee ID: " . $employee_id);
                }
            }
        }
        $this->redirect('/employees/profile/' . $employee_id);
    }

    public function deleteFile($employee_id, $file_id) {
        $this->authorize(['admin']);
        
        $file = $this->employeeFileModel->findById($file_id);
        if ($file) {
            $filePath = $this->uploadDir . $file['filename'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $this->employeeFileModel->delete($file_id);
            $this->auditLogModel->logAction($_SESSION['user_id'], 'DELETE_EMP_FILE', "Deleted file '" . $file['title'] . "' for employee ID: " . $employee_id);
        }
        $this->redirect('/employees/profile/' . $employee_id);
    }
}
?>