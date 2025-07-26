<?php
class PerformanceReview extends BaseModel {

    public function create($cycle_id, $employee_id, $manager_id) {
        $stmt = self::$conn->prepare("INSERT INTO performance_reviews (review_cycle_id, employee_id, manager_id) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $cycle_id, $employee_id, $manager_id);
        return $stmt->execute();
    }

    public function getForEmployee($employee_id) {
        $stmt = self::$conn->prepare("
            SELECT pr.*, rc.name as cycle_name
            FROM performance_reviews pr
            JOIN review_cycles rc ON pr.review_cycle_id = rc.id
            WHERE pr.employee_id = ?
            ORDER BY rc.start_date DESC
        ");
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getForManager($manager_id) {
        $stmt = self::$conn->prepare("
            SELECT pr.*, rc.name as cycle_name, e.first_name, e.last_name
            FROM performance_reviews pr
            JOIN review_cycles rc ON pr.review_cycle_id = rc.id
            JOIN employees e ON pr.employee_id = e.id
            WHERE pr.manager_id = ?
            ORDER BY rc.start_date DESC
        ");
        $stmt->bind_param("i", $manager_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function findById($id) {
        $stmt = self::$conn->prepare("
            SELECT pr.*, rc.name as cycle_name, e.first_name, e.last_name, m.first_name as manager_first_name, m.last_name as manager_last_name
            FROM performance_reviews pr
            JOIN review_cycles rc ON pr.review_cycle_id = rc.id
            JOIN employees e ON pr.employee_id = e.id
            JOIN employees m ON pr.manager_id = m.id
            WHERE pr.id = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function submitSelfAssessment($id, $assessment) {
        $stmt = self::$conn->prepare("UPDATE performance_reviews SET self_assessment = ?, status = 'pending_manager_review' WHERE id = ?");
        $stmt->bind_param("si", $assessment, $id);
        return $stmt->execute();
    }

    public function submitManagerReview($id, $assessment, $rating) {
        $stmt = self::$conn->prepare("UPDATE performance_reviews SET manager_assessment = ?, rating = ?, status = 'completed' WHERE id = ?");
        $stmt->bind_param("sii", $assessment, $rating, $id);
        return $stmt->execute();
    }
    
    public function getPendingReviewsCount($user_id, $role) {
        if ($role === 'employee') {
            $stmt = self::$conn->prepare("SELECT COUNT(id) as count FROM performance_reviews WHERE employee_id = ? AND status = 'pending_self_assessment'");
        } else {
            $stmt = self::$conn->prepare("SELECT COUNT(id) as count FROM performance_reviews WHERE manager_id = ? AND status = 'pending_manager_review'");
        }
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['count'] ?? 0;
    }
    
    public function getAllForCalendar() {
        $stmt = self::$conn->prepare("
            SELECT pr.review_date, e.first_name, e.last_name 
            FROM performance_reviews pr
            JOIN employees e ON pr.employee_id = e.id
        ");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>
