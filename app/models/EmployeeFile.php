<?php
class EmployeeFile extends BaseModel {

    public function create($employee_id, $title, $filename) {
        $stmt = self::$conn->prepare("INSERT INTO employee_files (employee_id, title, filename) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $employee_id, $title, $filename);
        return $stmt->execute();
    }

    public function getForEmployee($employee_id) {
        $stmt = self::$conn->prepare("SELECT * FROM employee_files WHERE employee_id = ? ORDER BY created_at DESC");
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function findById($id) {
        $stmt = self::$conn->prepare("SELECT * FROM employee_files WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function delete($id) {
        $stmt = self::$conn->prepare("DELETE FROM employee_files WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
