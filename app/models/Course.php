<?php
class Course extends BaseModel {

    public function getAll() {
        $stmt = self::$conn->prepare("SELECT * FROM courses ORDER BY title ASC");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function findById($id) {
        $stmt = self::$conn->prepare("SELECT * FROM courses WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($data) {
        $stmt = self::$conn->prepare("INSERT INTO courses (title, description, duration_hours) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $data['title'], $data['description'], $data['duration_hours']);
        return $stmt->execute();
    }

    public function update($id, $data) {
        $stmt = self::$conn->prepare("UPDATE courses SET title = ?, description = ?, duration_hours = ? WHERE id = ?");
        $stmt->bind_param("ssii", $data['title'], $data['description'], $data['duration_hours'], $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = self::$conn->prepare("DELETE FROM courses WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
