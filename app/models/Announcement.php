<?php
class Announcement extends BaseModel {
    public function getAll() {
        $query = "SELECT a.*, e.first_name, e.last_name FROM announcements a JOIN employees e ON a.user_id = e.id ORDER BY a.created_at DESC";
        return self::$conn->query($query)->fetch_all(MYSQLI_ASSOC);
    }

    public function getLatest($limit = 3) {
        $stmt = self::$conn->prepare("SELECT a.*, e.first_name, e.last_name FROM announcements a JOIN employees e ON a.user_id = e.id ORDER BY a.created_at DESC LIMIT ?");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function findById($id) {
        $stmt = self::$conn->prepare("SELECT * FROM announcements WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($data) {
        $stmt = self::$conn->prepare("INSERT INTO announcements (user_id, title, content) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $data['user_id'], $data['title'], $data['content']);
        return $stmt->execute();
    }

    public function update($id, $data) {
        $stmt = self::$conn->prepare("UPDATE announcements SET title = ?, content = ? WHERE id = ?");
        $stmt->bind_param("ssi", $data['title'], $data['content'], $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = self::$conn->prepare("DELETE FROM announcements WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
