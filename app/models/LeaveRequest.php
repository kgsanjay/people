<?php
class LeaveRequest extends BaseModel {

    public function create($data) {
        $stmt = self::$conn->prepare("INSERT INTO leave_requests (employee_id, leave_type_id, start_date, end_date, reason) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisss", $data['employee_id'], $data['leave_type_id'], $data['start_date'], $data['end_date'], $data['reason']);
        $stmt->execute();
        return self::$conn->insert_id;
    }

    public function getForEmployee($employee_id) {
        $stmt = self::$conn->prepare("
            SELECT lr.*, lt.name as leave_type_name
            FROM leave_requests lr
            JOIN leave_types lt ON lr.leave_type_id = lt.id
            WHERE lr.employee_id = ? ORDER BY lr.start_date DESC
        ");
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function findById($id) {
        $stmt = self::$conn->prepare("SELECT * FROM leave_requests WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateOverallStatus($id, $status) {
        $stmt = self::$conn->prepare("UPDATE leave_requests SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }
    
    public function getAllApprovedForCalendar() {
        $stmt = self::$conn->prepare("
            SELECT lr.start_date, lr.end_date, e.first_name, e.last_name 
            FROM leave_requests lr JOIN employees e ON lr.employee_id = e.id
            WHERE lr.status = 'approved'
        ");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getReportByDateRange($start_date, $end_date, $status) {
        $sql = "
            SELECT lr.*, e.first_name, e.last_name, lt.name as leave_type_name 
            FROM leave_requests lr 
            JOIN employees e ON lr.employee_id = e.id
            JOIN leave_types lt ON lr.leave_type_id = lt.id
            WHERE lr.start_date >= ? AND lr.end_date <= ?
        ";
        $params = ['ss', $start_date, $end_date];
        
        if ($status !== 'all') {
            $sql .= " AND lr.status = ?";
            $params[0] .= 's';
            $params[] = $status;
        }
        
        $stmt = self::$conn->prepare($sql);
        $stmt->bind_param(...$params);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>
