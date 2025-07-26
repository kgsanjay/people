<?php
class Project extends BaseModel {

    public function getAll() {
        $stmt = self::$conn->prepare("SELECT id, name, client, status FROM projects ORDER BY name ASC");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function findById($id) {
        $stmt = self::$conn->prepare("SELECT id, name, client, status FROM projects WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function create($data) {
        $stmt = self::$conn->prepare("INSERT INTO projects (name, client, status) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $data['name'], $data['client'], $data['status']);
        return $stmt->execute();
    }

    public function update($id, $data) {
        $stmt = self::$conn->prepare("UPDATE projects SET name = ?, client = ?, status = ? WHERE id = ?");
        $stmt->bind_param("sssi", $data['name'], $data['client'], $data['status'], $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = self::$conn->prepare("DELETE FROM projects WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
