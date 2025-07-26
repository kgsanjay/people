<?php
class Asset extends BaseModel {

    public function getAll() {
        $stmt = self::$conn->prepare("
            SELECT a.*, e.first_name, e.last_name 
            FROM assets a
            LEFT JOIN employees e ON a.assigned_to_id = e.id
            ORDER BY a.name ASC
        ");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getTotalCount() {
        $result = self::$conn->query("SELECT COUNT(id) as total_assets FROM assets");
        $row = $result->fetch_assoc();
        return $row['total_assets'] ?? 0;
    }

    public function findById($id) {
        $stmt = self::$conn->prepare("SELECT * FROM assets WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getForEmployee($employee_id) {
        $stmt = self::$conn->prepare("SELECT * FROM assets WHERE assigned_to_id = ? ORDER BY name ASC");
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function create($data) {
        $assigned_to_id = empty($data['assigned_to_id']) ? null : $data['assigned_to_id'];
        $stmt = self::$conn->prepare("INSERT INTO assets (name, category, serial_number, purchase_date, status, assigned_to_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $data['name'], $data['category'], $data['serial_number'], $data['purchase_date'], $data['status'], $assigned_to_id);
        return $stmt->execute();
    }

    public function update($id, $data) {
        $assigned_to_id = empty($data['assigned_to_id']) ? null : $data['assigned_to_id'];
        $stmt = self::$conn->prepare("UPDATE assets SET name = ?, category = ?, serial_number = ?, purchase_date = ?, status = ?, assigned_to_id = ? WHERE id = ?");
        $stmt->bind_param("sssssii", $data['name'], $data['category'], $data['serial_number'], $data['purchase_date'], $data['status'], $assigned_to_id, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = self::$conn->prepare("DELETE FROM assets WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
