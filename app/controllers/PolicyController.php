<?php
class PolicyController extends BaseController {
    private $policyModel;
    private $acknowledgmentModel;
    private $employeeModel;
    private $notificationModel;
    private $uploadDir = __DIR__ . '/../../public/uploads/';

    public function __construct() {
        $this->policyModel = new Policy();
        $this->acknowledgmentModel = new PolicyAcknowledgment();
        $this->employeeModel = new Employee();
        $this->notificationModel = new Notification();
    }

    // Admin view
    public function index() {
        $this->authorize(['admin']);
        $policies = $this->policyModel->getAll();
        foreach ($policies as &$policy) {
            $policy['acknowledgments'] = $this->acknowledgmentModel->getAcknowledgmentsForPolicy($policy['id']);
        }
        $this->view('policies/index', ['policies' => $policies]);
    }

    // Employee view
    public function myPolicies() {
        $this->authorize();
        $policies = $this->policyModel->getAll();
        $acknowledged_ids = $this->acknowledgmentModel->getAcknowledgedPolicyIdsForUser($_SESSION['user_id']);
        $this->view('policies/my_policies', ['policies' => $policies, 'acknowledged_ids' => $acknowledged_ids]);
    }

    public function upload() {
        $this->authorize(['admin']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['policy_file'])) {
            $title = $_POST['title'];
            $file = $_FILES['policy_file'];

            if ($file['error'] === UPLOAD_ERR_OK && !empty($title)) {
                $filename = time() . '_policy_' . basename($file['name']);
                if (move_uploaded_file($file['tmp_name'], $this->uploadDir . $filename)) {
                    if ($this->policyModel->create($title, $filename)) {
                        // Notify all employees
                        $employees = $this->employeeModel->getAllIds();
                        $message = "A new company policy has been published: '" . htmlspecialchars($title) . "'.";
                        $link = "/policy/myPolicies";
                        foreach ($employees as $employee) {
                            $this->notificationModel->create($employee['id'], $message, $link);
                        }
                    }
                }
            }
        }
        $this->redirect('/policy');
    }

    public function acknowledge($policy_id) {
        $this->authorize();
        $this->acknowledgmentModel->acknowledge($policy_id, $_SESSION['user_id']);
        $this->redirect('/policy/myPolicies');
    }

    public function delete($id) {
        $this->authorize(['admin']);
        $policy = $this->policyModel->findById($id);
        if ($policy) {
            $filePath = $this->uploadDir . $policy['filename'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $this->policyModel->delete($id);
        }
        $this->redirect('/policy');
    }
}
?>
