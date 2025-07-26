<?php
class Loan extends BaseModel {

    public function create($data) {
        $stmt = self::$conn->prepare("INSERT INTO loans (employee_id, amount, reason, status) VALUES (?, ?, ?, 'pending')");
        $stmt->bind_param("ids", $data['employee_id'], $data['amount'], $data['reason']);
        return $stmt->execute();
    }

    public function getForEmployee($employee_id) {
        $stmt = self::$conn->prepare("SELECT * FROM loans WHERE employee_id = ? ORDER BY created_at DESC");
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAll() {
        $query = "
            SELECT l.*, e.first_name, e.last_name
            FROM loans l
            JOIN employees e ON l.employee_id = e.id
            ORDER BY l.status ASC, l.created_at DESC
        ";
        return self::$conn->query($query)->fetch_all(MYSQLI_ASSOC);
    }
    
    public function findById($id) {
        $stmt = self::$conn->prepare("SELECT * FROM loans WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateStatus($loan_id, $status) {
        $stmt = self::$conn->prepare("UPDATE loans SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $loan_id);
        return $stmt->execute();
    }
}
?>
