<?php
class Employee extends BaseModel {

    public function getAll() {
        $stmt = self::$conn->prepare("SELECT id, first_name, last_name, email, job_title, department, hire_date, role, reports_to, is_active FROM employees ORDER BY first_name ASC");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getAllIds() {
        $query = "SELECT id FROM employees";
        $result = self::$conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getAdminsAndManagers() {
        $stmt = self::$conn->prepare("SELECT id, first_name, last_name FROM employees WHERE role IN ('admin', 'manager') AND is_active = 1");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function findById($id) {
        $stmt = self::$conn->prepare("SELECT id, first_name, last_name, email, job_title, department, hire_date, role, reports_to, is_active FROM employees WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function create($data) {
        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
        $reports_to = empty($data['reports_to']) ? null : $data['reports_to'];
        $stmt = self::$conn->prepare("INSERT INTO employees (first_name, last_name, email, job_title, department, hire_date, role, password, reports_to) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssi", $data['first_name'], $data['last_name'], $data['email'], $data['job_title'], $data['department'], $data['hire_date'], $data['role'], $hashed_password, $reports_to);
        return $stmt->execute();
    }

    public function update($id, $data) {
        $reports_to = empty($data['reports_to']) ? null : $data['reports_to'];
        $stmt = self::$conn->prepare("UPDATE employees SET first_name = ?, last_name = ?, email = ?, job_title = ?, department = ?, hire_date = ?, role = ?, reports_to = ? WHERE id = ?");
        $stmt->bind_param("sssssssii", $data['first_name'], $data['last_name'], $data['email'], $data['job_title'], $data['department'], $data['hire_date'], $data['role'], $reports_to, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = self::$conn->prepare("DELETE FROM employees WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    
    public function findByEmail($email) {
        $stmt = self::$conn->prepare("SELECT * FROM employees WHERE email = ? AND is_active = 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public function getHeadcountByDepartment() {
        $query = "SELECT department, COUNT(id) as count FROM employees WHERE is_active = 1 GROUP BY department";
        $result = self::$conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getHierarchy() {
        $query = "SELECT id, first_name, last_name, job_title, reports_to FROM employees WHERE is_active = 1";
        $result = self::$conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getDetails($employee_id) {
        $stmt = self::$conn->prepare("SELECT * FROM employee_details WHERE employee_id = ?");
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getDependents($employee_id) {
        $stmt = self::$conn->prepare("SELECT * FROM employee_dependents WHERE employee_id = ?");
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function createOrUpdateDetails($data) {
        $existing = $this->getDetails($data['employee_id']);
        if ($existing) {
            $stmt = self::$conn->prepare("UPDATE employee_details SET dob = ?, marital_status = ?, emergency_contact_name = ?, emergency_contact_phone = ?, address = ? WHERE employee_id = ?");
            $stmt->bind_param("sssssi", $data['dob'], $data['marital_status'], $data['emergency_contact_name'], $data['emergency_contact_phone'], $data['address'], $data['employee_id']);
        } else {
            $stmt = self::$conn->prepare("INSERT INTO employee_details (employee_id, dob, marital_status, emergency_contact_name, emergency_contact_phone, address) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssss", $data['employee_id'], $data['dob'], $data['marital_status'], $data['emergency_contact_name'], $data['emergency_contact_phone'], $data['address']);
        }
        return $stmt->execute();
    }

    public function addDependent($data) {
        $stmt = self::$conn->prepare("INSERT INTO employee_dependents (employee_id, name, relationship, dob) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $data['employee_id'], $data['name'], $data['relationship'], $data['dob']);
        return $stmt->execute();
    }

    public function deleteDependent($dependent_id) {
        $stmt = self::$conn->prepare("DELETE FROM employee_dependents WHERE id = ?");
        $stmt->bind_param("i", $dependent_id);
        return $stmt->execute();
    }
    
    public function deactivate($employee_id) {
        $stmt = self::$conn->prepare("UPDATE employees SET is_active = 0 WHERE id = ?");
        $stmt->bind_param("i", $employee_id);
        return $stmt->execute();
    }

    public function getDirectReports($manager_id) {
        $stmt = self::$conn->prepare("SELECT id, first_name, last_name FROM employees WHERE reports_to = ? AND is_active = 1");
        $stmt->bind_param("i", $manager_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>
