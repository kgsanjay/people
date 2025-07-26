<?php
class Workflow extends BaseModel {

    public function create($name, $type) {
        $stmt = self::$conn->prepare("INSERT INTO workflows (name, type) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $type);
        $stmt->execute();
        return self::$conn->insert_id;
    }

    public function addStep($workflow_id, $step_name, $approver_role, $step_order) {
        $stmt = self::$conn->prepare("INSERT INTO workflow_steps (workflow_id, step_name, approver_role, step_order) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issi", $workflow_id, $step_name, $approver_role, $step_order);
        return $stmt->execute();
    }
    
    public function getByType($type) {
        $stmt = self::$conn->prepare("SELECT * FROM workflows WHERE type = ? LIMIT 1");
        $stmt->bind_param("s", $type);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public function getSteps($workflow_id) {
        $stmt = self::$conn->prepare("SELECT * FROM workflow_steps WHERE workflow_id = ? ORDER BY step_order ASC");
        $stmt->bind_param("i", $workflow_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>
