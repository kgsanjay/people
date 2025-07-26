<?php
class TravelRequest extends BaseModel {

    public function create($data) {
        $stmt = self::$conn->prepare("INSERT INTO travel_requests (employee_id, start_date, end_date, destination, purpose, estimated_cost) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssd", $data['employee_id'], $data['start_date'], $data['end_date'], $data['destination'], $data['purpose'], $data['estimated_cost']);
        $stmt->execute();
        return self::$conn->insert_id;
    }

    public function getForEmployee($employee_id) {
        $stmt = self::$conn->prepare("SELECT * FROM travel_requests WHERE employee_id = ? ORDER BY start_date DESC");
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAll() {
        $query = "
            SELECT tr.*, e.first_name, e.last_name
            FROM travel_requests tr
            JOIN employees e ON tr.employee_id = e.id
            ORDER BY tr.status ASC, tr.created_at DESC
        ";
        return self::$conn->query($query)->fetch_all(MYSQLI_ASSOC);
    }

    public function findById($id) {
        $stmt = self::$conn->prepare("SELECT * FROM travel_requests WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateOverallStatus($id, $status) {
        $stmt = self::$conn->prepare("UPDATE travel_requests SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }
}
?>
