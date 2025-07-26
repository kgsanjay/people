<?php
class Feedback extends BaseModel {

    public function request($requester_id, $provider_id, $context) {
        $stmt = self::$conn->prepare("INSERT INTO feedback (requester_id, provider_id, context, status) VALUES (?, ?, ?, 'requested')");
        $stmt->bind_param("iis", $requester_id, $provider_id, $context);
        return $stmt->execute();
    }

    public function give($giver_id, $receiver_id, $content, $is_public, $request_id = null) {
        if ($request_id) {
            // Fulfilling a request
            $stmt = self::$conn->prepare("UPDATE feedback SET giver_id = ?, receiver_id = ?, content = ?, is_public = ?, status = 'given' WHERE id = ? AND provider_id = ?");
            $stmt->bind_param("iisiii", $giver_id, $receiver_id, $content, $is_public, $request_id, $giver_id);
        } else {
            // Unsolicited feedback
            $stmt = self::$conn->prepare("INSERT INTO feedback (giver_id, receiver_id, content, is_public, status) VALUES (?, ?, ?, ?, 'given')");
            $stmt->bind_param("iisi", $giver_id, $receiver_id, $content, $is_public);
        }
        return $stmt->execute();
    }

    public function getReceived($user_id) {
        $stmt = self::$conn->prepare("
            SELECT f.*, g.first_name as giver_first_name, g.last_name as giver_last_name
            FROM feedback f
            JOIN employees g ON f.giver_id = g.id
            WHERE f.receiver_id = ? AND f.status = 'given'
            ORDER BY f.created_at DESC
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getGiven($user_id) {
        $stmt = self::$conn->prepare("
            SELECT f.*, r.first_name as receiver_first_name, r.last_name as receiver_last_name
            FROM feedback f
            JOIN employees r ON f.receiver_id = r.id
            WHERE f.giver_id = ? AND f.status = 'given'
            ORDER BY f.created_at DESC
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getRequestsForUser($user_id) {
        $stmt = self::$conn->prepare("
            SELECT f.*, r.first_name as requester_first_name, r.last_name as requester_last_name
            FROM feedback f
            JOIN employees r ON f.requester_id = r.id
            WHERE f.provider_id = ? AND f.status = 'requested'
            ORDER BY f.created_at DESC
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getForTeam($manager_id) {
        $stmt = self::$conn->prepare("
            SELECT f.*, g.first_name as giver_first_name, g.last_name as giver_last_name, r.first_name as receiver_first_name, r.last_name as receiver_last_name
            FROM feedback f
            JOIN employees r ON f.receiver_id = r.id
            JOIN employees g ON f.giver_id = g.id
            WHERE r.reports_to = ? AND f.is_public = 1 AND f.status = 'given'
            ORDER BY f.created_at DESC
        ");
        $stmt->bind_param("i", $manager_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>
