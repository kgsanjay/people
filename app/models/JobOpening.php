<?php
class JobOpening extends BaseModel {
    public function create($data) {
        $stmt = self::$conn->prepare("INSERT INTO job_openings (title, description, department, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $data['title'], $data['description'], $data['department'], $data['status']);
        return $stmt->execute();
    }

    public function getAll() {
        return self::$conn->query("SELECT * FROM job_openings ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getAllOpen() {
        return self::$conn->query("SELECT * FROM job_openings WHERE status = 'open' ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
    }

    public function findById($id) {
        $stmt = self::$conn->prepare("SELECT * FROM job_openings WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>
