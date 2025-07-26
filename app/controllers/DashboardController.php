<?php
class DashboardController extends BaseController {
    public function index() {
        $this->checkAuth();
        $employeeModel = new Employee();
        $announcementModel = new Announcement();
        $policyAckModel = new PolicyAcknowledgment();
        $awardModel = new Award();
        $performanceReviewModel = new PerformanceReview();
        $expenseModel = new Expense();

        $data = [
            'total_employees' => count($employeeModel->getAll()),
            'announcements' => $announcementModel->getLatest(3),
            'unacknowledged_policies' => $policyAckModel->getUnacknowledgedCountForUser($_SESSION['user_id']),
            'recent_awards' => $awardModel->getRecent(3),
            'pending_reviews' => $performanceReviewModel->getPendingReviewsCount($_SESSION['user_id'], $_SESSION['user_role']),
            'pending_expenses' => $expenseModel->getPendingCount()
        ];
        $this->view('dashboard/index', $data);
    }
}
?>