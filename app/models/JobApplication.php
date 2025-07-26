<?php
class JobApplication extends BaseModel {
    public function create($job_id, $candidate_id) {
        $stmt = self::$conn->prepare("INSERT INTO job_applications (job_opening_id, candidate_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $job_id, $candidate_id);
        return $stmt->execute();
    }
    
    public function getForJob($job_id) {
        $stmt = self::$conn->prepare("
            SELECT ja.*, c.name, c.email, c.phone, c.resume_filename
            FROM job_applications ja
            JOIN candidates c ON ja.candidate_id = c.id
            WHERE ja.job_opening_id = ?
            ORDER BY ja.created_at DESC
        ");
        $stmt->bind_param("i", $job_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function updateStatus($application_id, $status) {
        $stmt = self::$conn->prepare("UPDATE job_applications SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $application_id);
        return $stmt->execute();
    }
}
?>
