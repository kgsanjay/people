<?php
class NotificationController extends BaseController {
    private $notificationModel;

    public function __construct() {
        $this->checkAuth();
        $this->notificationModel = new Notification();
    }

    public function read($notification_id) {
        $this->notificationModel->markAsRead($notification_id, $_SESSION['user_id']);
        
        // Redirect to the original link after marking as read
        $redirect_url = '/dashboard'; // Default fallback
        if (isset($_GET['redirect'])) {
            // Basic validation to prevent open redirect
            if (strpos($_GET['redirect'], '/') === 0) {
                $redirect_url = $_GET['redirect'];
            }
        }
        $this->redirect($redirect_url);
    }
}
?>
