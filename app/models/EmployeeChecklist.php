<?php
class EmployeeChecklist extends BaseModel {

    public function assign($employee_id, $checklist_id) {
        $stmt = self::$conn->prepare("INSERT INTO employee_checklists (employee_id, checklist_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $employee_id, $checklist_id);
        $stmt->execute();
        return self::$conn->insert_id;
    }

    public function createTask($employee_checklist_id, $checklist_item_id, $assigned_to_id) {
        $stmt = self::$conn->prepare("INSERT INTO employee_checklist_tasks (employee_checklist_id, checklist_item_id, assigned_to_id) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $employee_checklist_id, $checklist_item_id, $assigned_to_id);
        return $stmt->execute();
    }

    public function getAssignedChecklists() {
        $stmt = self::$conn->prepare("
            SELECT ec.*, e.first_name, e.last_name, c.name as checklist_name, c.type
            FROM employee_checklists ec
            JOIN employees e ON ec.employee_id = e.id
            JOIN checklists c ON ec.checklist_id = c.id
            ORDER BY ec.created_at DESC
        ");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getChecklistProgress($assignment_id) {
        $stmt = self::$conn->prepare("
            SELECT ect.*, ci.task_name, assignee.first_name as assignee_first_name, assignee.last_name as assignee_last_name
            FROM employee_checklist_tasks ect
            JOIN checklist_items ci ON ect.checklist_item_id = ci.id
            LEFT JOIN employees assignee ON ect.assigned_to_id = assignee.id
            WHERE ect.employee_checklist_id = ?
        ");
        $stmt->bind_param("i", $assignment_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getAssignmentDetails($assignment_id) {
        $stmt = self::$conn->prepare("
            SELECT ec.*, e.first_name, e.last_name, c.name as checklist_name
            FROM employee_checklists ec
            JOIN employees e ON ec.employee_id = e.id
            JOIN checklists c ON ec.checklist_id = c.id
            WHERE ec.id = ?
        ");
        $stmt->bind_param("i", $assignment_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateTaskStatus($task_id, $status, $user_id) {
        $completed_at = ($status === 'completed') ? date('Y-m-d H:i:s') : null;
        $stmt = self::$conn->prepare("UPDATE employee_checklist_tasks SET status = ?, completed_at = ? WHERE id = ? AND assigned_to_id = ?");
        $stmt->bind_param("ssii", $status, $completed_at, $task_id, $user_id);
        return $stmt->execute();
    }

    public function getTasksForUser($user_id) {
        $stmt = self::$conn->prepare("
            SELECT ect.*, ci.task_name, e.first_name, e.last_name, c.name as checklist_name
            FROM employee_checklist_tasks ect
            JOIN checklist_items ci ON ect.checklist_item_id = ci.id
            JOIN employee_checklists ec ON ect.employee_checklist_id = ec.id
            JOIN employees e ON ec.employee_id = e.id
            JOIN checklists c ON ec.checklist_id = c.id
            WHERE ect.assigned_to_id = ? AND ect.status = 'pending'
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getActiveProcessCount() {
        $stmt = self::$conn->query("SELECT COUNT(id) as active_count FROM employee_checklists WHERE is_completed = 0");
        return $stmt->fetch_assoc()['active_count'] ?? 0;
    }
}
?>
