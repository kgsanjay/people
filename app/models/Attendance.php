<?php
class Attendance extends BaseModel {

    public function clockIn($employee_id) {
        $work_date = date('Y-m-d');
        $clock_in_time = date('H:i:s');
        $stmt = self::$conn->prepare("INSERT INTO attendances (employee_id, work_date, clock_in) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $employee_id, $work_date, $clock_in_time);
        return $stmt->execute();
    }

    public function clockOut($attendance_id) {
        $clock_out_time = date('H:i:s');
        $stmt = self::$conn->prepare("UPDATE attendances SET clock_out = ? WHERE id = ?");
        $stmt->bind_param("si", $clock_out_time, $attendance_id);
        return $stmt->execute();
    }

    public function getTodayAttendance($employee_id) {
        $today = date('Y-m-d');
        $stmt = self::$conn->prepare("SELECT * FROM attendances WHERE employee_id = ? AND work_date = ?");
        $stmt->bind_param("is", $employee_id, $today);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getForEmployee($employee_id) {
        $stmt = self::$conn->prepare("SELECT * FROM attendances WHERE employee_id = ? ORDER BY work_date DESC");
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getPresentTodayCount() {
        $today = date('Y-m-d');
        $stmt = self::$conn->prepare("SELECT COUNT(id) as present_count FROM attendances WHERE work_date = ? AND clock_out IS NULL");
        $stmt->bind_param("s", $today);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['present_count'] ?? 0;
    }
    
    public function getReportByEmployeeAndDate($employee_id, $start_date, $end_date) {
        $stmt = self::$conn->prepare("SELECT * FROM attendances WHERE employee_id = ? AND work_date >= ? AND work_date <= ? ORDER BY work_date DESC");
        $stmt->bind_param("iss", $employee_id, $start_date, $end_date);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>
