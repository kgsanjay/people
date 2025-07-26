<?php
class CourseProgress extends BaseModel {
    public function markComplete($employee_id, $lesson_id) {
        $stmt = self::$conn->prepare("INSERT IGNORE INTO course_progress (employee_id, lesson_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $employee_id, $lesson_id);
        return $stmt->execute();
    }

    public function getCompletedLessonIds($employee_id, $course_id) {
        $stmt = self::$conn->prepare("
            SELECT l.id FROM lessons l
            JOIN course_progress cp ON l.id = cp.lesson_id
            WHERE cp.employee_id = ? AND l.course_id = ?
        ");
        $stmt->bind_param("ii", $employee_id, $course_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $ids = [];
        while ($row = $result->fetch_assoc()) {
            $ids[] = $row['id'];
        }
        return $ids;
    }
}
?>
