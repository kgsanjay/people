<?php
class AssetController extends BaseController {
    private $assetModel;
    private $employeeModel;
    private $notificationModel;
    private $auditLogModel;

    public function __construct() {
        $this->checkAuth();
        $this->assetModel = new Asset();
        $this->employeeModel = new Employee();
        $this->notificationModel = new Notification();
        $this->auditLogModel = new AuditLog();
    }

    // Admin view to see all assets
    public function index() {
        if ($_SESSION['user_role'] !== 'admin') {
            echo "Access Denied";
            exit();
        }
        $assets = $this->assetModel->getAll();
        $this->view('assets/index', ['assets' => $assets]);
    }

    // Employee view to see their own assets
    public function myAssets() {
        $assets = $this->assetModel->getForEmployee($_SESSION['user_id']);
        $this->view('assets/my_assets', ['assets' => $assets]);
    }

    public function create() {
        if ($_SESSION['user_role'] !== 'admin') {
            echo "Access Denied";
            exit();
        }
        $employees = $this->employeeModel->getAll();
        $this->view('assets/form', ['action' => 'create', 'employees' => $employees]);
    }

    public function store() {
        if ($_SESSION['user_role'] !== 'admin') {
            echo "Access Denied";
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->assetModel->create($_POST)) {
                 if (!empty($_POST['assigned_to_id'])) {
                    $message = "A new asset '" . htmlspecialchars($_POST['name']) . "' has been assigned to you.";
                    $link = "/asset/myAssets";
                    $this->notificationModel->create($_POST['assigned_to_id'], $message, $link);
                }
                $this->auditLogModel->logAction($_SESSION['user_id'], 'CREATE_ASSET', "Created asset: " . $_POST['name']);
            }
            $this->redirect('/asset/index');
        }
    }

    public function edit($id) {
        if ($_SESSION['user_role'] !== 'admin') {
            echo "Access Denied";
            exit();
        }
        $asset = $this->assetModel->findById($id);
        $employees = $this->employeeModel->getAll();
        $this->view('assets/form', ['action' => 'edit', 'asset' => $asset, 'employees' => $employees]);
    }

    public function update($id) {
        if ($_SESSION['user_role'] !== 'admin') {
            echo "Access Denied";
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $old_asset = $this->assetModel->findById($id);
            if ($this->assetModel->update($id, $_POST)) {
                // If assignment changed, notify the new employee
                if (!empty($_POST['assigned_to_id']) && $_POST['assigned_to_id'] != $old_asset['assigned_to_id']) {
                    $message = "Asset '" . htmlspecialchars($_POST['name']) . "' has been assigned to you.";
                    $link = "/asset/myAssets";
                    $this->notificationModel->create($_POST['assigned_to_id'], $message, $link);
                }
                $this->auditLogModel->logAction($_SESSION['user_id'], 'UPDATE_ASSET', "Updated asset ID: " . $id);
            }
            $this->redirect('/asset/index');
        }
    }

    public function delete($id) {
        if ($_SESSION['user_role'] !== 'admin') {
            echo "Access Denied";
            exit();
        }
        $asset = $this->assetModel->findById($id);
        if ($this->assetModel->delete($id)) {
            $this->auditLogModel->logAction($_SESSION['user_id'], 'DELETE_ASSET', "Deleted asset: " . $asset['name'] . " (ID: " . $id . ")");
        }
        $this->redirect('/asset/index');
    }
}
?>