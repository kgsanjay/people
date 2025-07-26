<?php
class Expense extends BaseModel {

    public function create($data) {
        $stmt = self::$conn->prepare("INSERT INTO expenses (employee_id, expense_date, category, amount, description, receipt_filename) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issdss", $data['employee_id'], $data['expense_date'], $data['category'], $data['amount'], $data['description'], $data['receipt_filename']);
        $stmt->execute();
        return self::$conn->insert_id;
    }

    public function getForEmployee($employee_id) {
        $stmt = self::$conn->prepare("SELECT * FROM expenses WHERE employee_id = ? ORDER BY expense_date DESC");
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAll() {
        $query = "
            SELECT ex.*, e.first_name, e.last_name
            FROM expenses ex
            JOIN employees e ON ex.employee_id = e.id
            ORDER BY ex.status ASC, ex.created_at DESC
        ";
        return self::$conn->query($query)->fetch_all(MYSQLI_ASSOC);
    }

    public function findById($id) {
        $stmt = self::$conn->prepare("SELECT * FROM expenses WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateOverallStatus($id, $status) {
        $stmt = self::$conn->prepare("UPDATE expenses SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }
    
    public function getPendingCount() {
        $query = "SELECT COUNT(id) as pending_count FROM expenses WHERE status LIKE 'pending%'";
        return self::$conn->query($query)->fetch_assoc()['pending_count'] ?? 0;
    }
}
?>
