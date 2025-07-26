<?php
class Award extends BaseModel {

    // Award Types
    public function getAllTypes() {
        return self::$conn->query("SELECT * FROM award_types ORDER BY name ASC")->fetch_all(MYSQLI_ASSOC);
    }

    public function createType($name) {
        $stmt = self::$conn->prepare("INSERT INTO award_types (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        return $stmt->execute();
    }

    public function deleteType($id) {
        $stmt = self::$conn->prepare("DELETE FROM award_types WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Given Awards
    public function give($data) {
        $stmt = self::$conn->prepare("INSERT INTO awards (employee_id, award_type_id, awarded_by_id, reason, date_awarded) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiss", $data['employee_id'], $data['award_type_id'], $data['awarded_by_id'], $data['reason'], $data['date_awarded']);
        return $stmt->execute();
    }

    public function getForEmployee($employee_id) {
        $stmt = self::$conn->prepare("
            SELECT a.*, at.name as award_name, e.first_name as giver_first_name, e.last_name as giver_last_name
            FROM awards a
            JOIN award_types at ON a.award_type_id = at.id
            JOIN employees e ON a.awarded_by_id = e.id
            WHERE a.employee_id = ?
            ORDER BY a.date_awarded DESC
        ");
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getRecent($limit = 3) {
        $stmt = self::$conn->prepare("
            SELECT a.*, at.name as award_name, e.first_name, e.last_name
            FROM awards a
            JOIN award_types at ON a.award_type_id = at.id
            JOIN employees e ON a.employee_id = e.id
            ORDER BY a.date_awarded DESC
            LIMIT ?
        ");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>
