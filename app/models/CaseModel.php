<?php
class CaseModel extends BaseModel {

    public function create($data) {
        $stmt = self::$conn->prepare("INSERT INTO cases (employee_id, category, subject, description, status) VALUES (?, ?, ?, ?, 'open')");
        $stmt->bind_param("isss", $data['employee_id'], $data['category'], $data['subject'], $data['description']);
        return $stmt->execute();
    }

    public function getForEmployee($employee_id) {
        $stmt = self::$conn->prepare("
            SELECT c.*, a.first_name as assigned_first_name, a.last_name as assigned_last_name
            FROM cases c
            LEFT JOIN employees a ON c.assigned_to = a.id
            WHERE c.employee_id = ? 
            ORDER BY c.created_at DESC
        ");
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAll() {
        $stmt = self::$conn->prepare("
            SELECT c.*, e.first_name, e.last_name, a.first_name as assigned_first_name, a.last_name as assigned_last_name
            FROM cases c
            JOIN employees e ON c.employee_id = e.id
            LEFT JOIN employees a ON c.assigned_to = a.id
            ORDER BY c.status ASC, c.created_at DESC
        ");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function findById($id) {
        $stmt = self::$conn->prepare("SELECT * FROM cases WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateStatusAndAssignment($case_id, $status, $assigned_to) {
        $assigned_to = empty($assigned_to) ? null : $assigned_to;
        $stmt = self::$conn->prepare("UPDATE cases SET status = ?, assigned_to = ? WHERE id = ?");
        $stmt->bind_param("sii", $status, $assigned_to, $case_id);
        return $stmt->execute();
    }
}
?>
