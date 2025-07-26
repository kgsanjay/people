<?php
class Policy extends BaseModel {

    public function create($title, $filename) {
        $stmt = self::$conn->prepare("INSERT INTO policies (title, filename) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $filename);
        return $stmt->execute();
    }

    public function getAll() {
        return self::$conn->query("SELECT * FROM policies ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
    }

    public function findById($id) {
        $stmt = self::$conn->prepare("SELECT * FROM policies WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function delete($id) {
        $stmt = self::$conn->prepare("DELETE FROM policies WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
