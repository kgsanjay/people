<?php
class Ticket extends BaseModel {

    public function create($data) {
        $stmt = self::$conn->prepare("INSERT INTO tickets (employee_id, department_id, subject, description, priority) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisss", $data['employee_id'], $data['department_id'], $data['subject'], $data['description'], $data['priority']);
        return $stmt->execute();
    }

    public function getForEmployee($employee_id) {
        $stmt = self::$conn->prepare("
            SELECT t.*, d.name as department_name, a.first_name as assigned_first_name, a.last_name as assigned_last_name
            FROM tickets t
            JOIN departments d ON t.department_id = d.id
            LEFT JOIN employees a ON t.assigned_to = a.id
            WHERE t.employee_id = ? 
            ORDER BY t.created_at DESC
        ");
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAll() {
        $stmt = self::$conn->prepare("
            SELECT t.*, e.first_name, e.last_name, d.name as department_name, a.first_name as assigned_first_name, a.last_name as assigned_last_name
            FROM tickets t
            JOIN employees e ON t.employee_id = e.id
            JOIN departments d ON t.department_id = d.id
            LEFT JOIN employees a ON t.assigned_to = a.id
            ORDER BY t.status ASC, t.priority DESC, t.created_at ASC
        ");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function findById($id) {
        $stmt = self::$conn->prepare("SELECT * FROM tickets WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateStatusAndAssignment($ticket_id, $status, $assigned_to) {
        $assigned_to = empty($assigned_to) ? null : $assigned_to;
        $stmt = self::$conn->prepare("UPDATE tickets SET status = ?, assigned_to = ? WHERE id = ?");
        $stmt->bind_param("sii", $status, $assigned_to, $ticket_id);
        return $stmt->execute();
    }
}
?>
