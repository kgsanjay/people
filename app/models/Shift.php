<?php
class Shift extends BaseModel {

    public function getAll() {
        $stmt = self::$conn->prepare("SELECT * FROM shifts ORDER BY name ASC");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function findById($id) {
        $stmt = self::$conn->prepare("SELECT * FROM shifts WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function create($data) {
        $stmt = self::$conn->prepare("INSERT INTO shifts (name, start_time, end_time) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $data['name'], $data['start_time'], $data['end_time']);
        return $stmt->execute();
    }

    public function update($id, $data) {
        $stmt = self::$conn->prepare("UPDATE shifts SET name = ?, start_time = ?, end_time = ? WHERE id = ?");
        $stmt->bind_param("sssi", $data['name'], $data['start_time'], $data['end_time'], $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = self::$conn->prepare("DELETE FROM shifts WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
