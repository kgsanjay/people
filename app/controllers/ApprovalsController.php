<?php
class ApprovalsController extends BaseController {
    private $approvalRequestModel;
    public function __construct() {
        $this->checkAuth();
        if ($_SESSION['user_role'] === 'employee') { exit('Access Denied'); }
        $this->approvalRequestModel = new ApprovalRequest();
    }
    public function index() {
        $pending_requests = $this->approvalRequestModel->getPendingForUser($_SESSION['user_id']);
        $this->view('approvals/index', ['requests' => $pending_requests]);
    }
}
?>