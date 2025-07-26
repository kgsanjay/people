<?php
class AuditLog extends BaseModel {

    public function logAction($user_id, $action, $details) {
        $stmt = self::$conn->prepare("INSERT INTO audit_logs (user_id, action, details) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $action, $details);
        return $stmt->execute();
    }

    public function getAll() {
        $query = "
            SELECT al.*, e.first_name, e.last_name
            FROM audit_logs al
            JOIN employees e ON al.user_id = e.id
            ORDER BY al.created_at DESC
        ";
        $result = self::$conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
