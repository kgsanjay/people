<?php
class KeyResult extends BaseModel {

    public function create($goal_id, $description) {
        $stmt = self::$conn->prepare("INSERT INTO key_results (goal_id, description) VALUES (?, ?)");
        $stmt->bind_param("is", $goal_id, $description);
        return $stmt->execute();
    }

    public function getForGoal($goal_id) {
        $stmt = self::$conn->prepare("SELECT * FROM key_results WHERE goal_id = ?");
        $stmt->bind_param("i", $goal_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function updateProgress($id, $progress) {
        $stmt = self::$conn->prepare("UPDATE key_results SET progress = ? WHERE id = ?");
        $stmt->bind_param("ii", $progress, $id);
        return $stmt->execute();
    }
    
    public function findById($id) {
        $stmt = self::$conn->prepare("SELECT * FROM key_results WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>
