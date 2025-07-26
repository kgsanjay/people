<?php
class Lesson extends BaseModel {
    public function create($course_id, $title, $content) {
        $stmt = self::$conn->prepare("INSERT INTO lessons (course_id, title, content) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $course_id, $title, $content);
        return $stmt->execute();
    }

    public function getForCourse($course_id) {
        $stmt = self::$conn->prepare("SELECT * FROM lessons WHERE course_id = ? ORDER BY id ASC");
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function delete($id) {
        $stmt = self::$conn->prepare("DELETE FROM lessons WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
