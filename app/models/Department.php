<?php
class Department extends BaseModel {

    public function getAll() {
        $query = "SELECT * FROM departments ORDER BY name ASC";
        return self::$conn->query($query)->fetch_all(MYSQLI_ASSOC);
    }

    public function create($name) {
        $stmt = self::$conn->prepare("INSERT INTO departments (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = self::$conn->prepare("DELETE FROM departments WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
