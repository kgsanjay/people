<?php
class Document extends BaseModel {

    public function getAll() {
        $stmt = self::$conn->prepare("SELECT * FROM documents ORDER BY title ASC");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function findById($id) {
        $stmt = self::$conn->prepare("SELECT * FROM documents WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function create($title, $filename) {
        $stmt = self::$conn->prepare("INSERT INTO documents (title, filename) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $filename);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = self::$conn->prepare("DELETE FROM documents WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
