<?php
class EmployeeExit extends BaseModel {

    public function create($data) {
        $stmt = self::$conn->prepare("INSERT INTO employee_exits (employee_id, resignation_date, last_working_day, reason) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $data['employee_id'], $data['resignation_date'], $data['last_working_day'], $data['reason']);
        return $stmt->execute();
    }

    public function getAll() {
        $query = "
            SELECT ex.*, e.first_name, e.last_name
            FROM employee_exits ex
            JOIN employees e ON ex.employee_id = e.id
            ORDER BY ex.last_working_day DESC
        ";
        return self::$conn->query($query)->fetch_all(MYSQLI_ASSOC);
    }

    public function findById($id) {
        $stmt = self::$conn->prepare("SELECT * FROM employee_exits WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateStatus($id, $status) {
        $stmt = self::$conn->prepare("UPDATE employee_exits SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }
}
?>
