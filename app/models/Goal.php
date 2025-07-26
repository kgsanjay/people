<?php
class Goal extends BaseModel {

    public function create($data) {
        $stmt = self::$conn->prepare("INSERT INTO goals (employee_id, title, review_period, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $data['employee_id'], $data['title'], $data['review_period'], $data['status']);
        $stmt->execute();
        return self::$conn->insert_id;
    }

    public function getForEmployee($employee_id) {
        $stmt = self::$conn->prepare("SELECT * FROM goals WHERE employee_id = ? ORDER BY review_period DESC");
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getForTeam($manager_id) {
        $stmt = self::$conn->prepare("
            SELECT g.*, e.first_name, e.last_name
            FROM goals g
            JOIN employees e ON g.employee_id = e.id
            WHERE e.reports_to = ?
            ORDER BY e.first_name, g.review_period DESC
        ");
        $stmt->bind_param("i", $manager_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getActiveCount() {
        $query = "SELECT COUNT(id) as active_count FROM goals WHERE status = 'in_progress'";
        return self::$conn->query($query)->fetch_assoc()['active_count'] ?? 0;
    }
}
?>
