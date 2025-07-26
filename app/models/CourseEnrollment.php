<?php
class CourseEnrollment extends BaseModel {

    public function enroll($employee_id, $course_id) {
        // Check if already enrolled
        $stmt_check = self::$conn->prepare("SELECT id FROM course_enrollments WHERE employee_id = ? AND course_id = ?");
        $stmt_check->bind_param("ii", $employee_id, $course_id);
        $stmt_check->execute();
        if ($stmt_check->get_result()->num_rows > 0) {
            return false; // Already enrolled
        }
        
        $stmt = self::$conn->prepare("INSERT INTO course_enrollments (employee_id, course_id, status) VALUES (?, ?, 'approved')"); // Auto-approve for simplicity
        $stmt->bind_param("ii", $employee_id, $course_id);
        return $stmt->execute();
    }
    
    public function isEnrolled($employee_id, $course_id) {
        $stmt = self::$conn->prepare("SELECT id FROM course_enrollments WHERE employee_id = ? AND course_id = ? AND status = 'approved'");
        $stmt->bind_param("ii", $employee_id, $course_id);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }
}
?>
