<?php
class Claim extends BaseModel {

    public function create($data) {
        $stmt = self::$conn->prepare("INSERT INTO claims (employee_id, claim_date, category, amount, description, receipt_filename) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issdss", $data['employee_id'], $data['claim_date'], $data['category'], $data['amount'], $data['description'], $data['receipt_filename']);
        $stmt->execute();
        return self::$conn->insert_id;
    }

    public function getForEmployee($employee_id) {
        $stmt = self::$conn->prepare("SELECT * FROM claims WHERE employee_id = ? ORDER BY claim_date DESC");
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAll() {
        $query = "
            SELECT c.*, e.first_name, e.last_name
            FROM claims c
            JOIN employees e ON c.employee_id = e.id
            ORDER BY c.status ASC, c.created_at DESC
        ";
        return self::$conn->query($query)->fetch_all(MYSQLI_ASSOC);
    }

    public function findById($id) {
        $stmt = self::$conn->prepare("SELECT * FROM claims WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateOverallStatus($id, $status) {
        $stmt = self::$conn->prepare("UPDATE claims SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }
}
?>
