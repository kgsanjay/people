<?php
class Checklist extends BaseModel {

    public function getAll() {
        $stmt = self::$conn->prepare("SELECT * FROM checklists ORDER BY name ASC");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function findById($id) {
        $stmt = self::$conn->prepare("SELECT * FROM checklists WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function create($name, $type) {
        $stmt = self::$conn->prepare("INSERT INTO checklists (name, type) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $type);
        $stmt->execute();
        return self::$conn->insert_id;
    }

    public function addItem($checklist_id, $task_name, $assigned_to_role) {
        $stmt = self::$conn->prepare("INSERT INTO checklist_items (checklist_id, task_name, assigned_to_role) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $checklist_id, $task_name, $assigned_to_role);
        return $stmt->execute();
    }

    public function getItems($checklist_id) {
        $stmt = self::$conn->prepare("SELECT * FROM checklist_items WHERE checklist_id = ? ORDER BY id ASC");
        $stmt->bind_param("i", $checklist_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
