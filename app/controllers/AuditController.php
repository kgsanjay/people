<?php
class AuditController extends BaseController {
    private $auditLogModel;

    public function __construct() {
        $this->authorize(['admin']);
        $this->auditLogModel = new AuditLog();
    }

    public function index() {
        $logs = $this->auditLogModel->getAll();
        $this->view('audit/index', ['logs' => $logs]);
    }
}
?>