<?php
class AuditController extends BaseController {
    private $auditLogModel;

    public function __construct() {
        $this->checkAuth();
        if ($_SESSION['user_role'] !== 'admin') {
            echo "Access Denied";
            exit();
        }
        $this->auditLogModel = new AuditLog();
    }

    public function index() {
        $logs = $this->auditLogModel->getAll();
        $this->view('audit/index', ['logs' => $logs]);
    }
}
?>