<?php
class Notification extends BaseModel {

    public function create($user_id, $message, $link) {
        $stmt = self::$conn->prepare("INSERT INTO notifications (user_id, message, link) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $message, $link);
        return $stmt->execute();
    }

    public function getUnreadForUser($user_id) {
        $stmt = self::$conn->prepare("SELECT * FROM notifications WHERE user_id = ? AND is_read = 0 ORDER BY created_at DESC LIMIT 10");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function markAsRead($notification_id, $user_id) {
        // Ensure user can only mark their own notifications as read
        $stmt = self::$conn->prepare("UPDATE notifications SET is_read = 1 WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $notification_id, $user_id);
        return $stmt->execute();
    }
}
?>
