<?php
class LeaveType extends BaseModel {

    public function getAll() {
        return self::$conn->query("SELECT * FROM leave_types ORDER BY name ASC")->fetch_all(MYSQLI_ASSOC);
    }

    public function create($name) {
        $stmt = self::$conn->prepare("INSERT INTO leave_types (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = self::$conn->prepare("DELETE FROM leave_types WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
