<?php
class Timesheet extends BaseModel {

    public function getForEmployee($employee_id) {
        $stmt = self::$conn->prepare("
            SELECT t.*, p.name as project_name, ts.status as submission_status
            FROM timesheets t
            JOIN projects p ON t.project_id = p.id
            LEFT JOIN timesheet_submissions ts ON t.submission_id = ts.id
            WHERE t.employee_id = ? 
            ORDER BY t.work_date DESC
        ");
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getUnsubmittedForEmployee($employee_id) {
        $stmt = self::$conn->prepare("SELECT * FROM timesheets WHERE employee_id = ? AND submission_id IS NULL");
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function submitEntries($employee_id, $submission_id) {
        $stmt = self::$conn->prepare("UPDATE timesheets SET submission_id = ? WHERE employee_id = ? AND submission_id IS NULL");
        $stmt->bind_param("ii", $submission_id, $employee_id);
        return $stmt->execute();
    }

    public function create($data) {
        $stmt = self::$conn->prepare("INSERT INTO timesheets (employee_id, project_id, work_date, hours, description) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisds", $data['employee_id'], $data['project_id'], $data['work_date'], $data['hours'], $data['description']);
        return $stmt->execute();
    }

    public function getTotalHours() {
        $result = self::$conn->query("SELECT SUM(hours) as total_hours FROM timesheets");
        $row = $result->fetch_assoc();
        return $row['total_hours'] ?? 0;
    }
}
?>
