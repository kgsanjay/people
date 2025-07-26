<?php
class TimesheetSubmission extends BaseModel {

    public function create($employee_id, $start_date, $end_date, $total_hours) {
        $stmt = self::$conn->prepare("INSERT INTO timesheet_submissions (employee_id, start_date, end_date, total_hours) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issd", $employee_id, $start_date, $end_date, $total_hours);
        $stmt->execute();
        return self::$conn->insert_id;
    }

    public function findById($id) {
        $stmt = self::$conn->prepare("SELECT * FROM timesheet_submissions WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateOverallStatus($id, $status) {
        $stmt = self::$conn->prepare("UPDATE timesheet_submissions SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }
}
?>
