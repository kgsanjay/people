<?php
class LoanController extends BaseController {
    private $loanModel;
    private $employeeModel;
    private $notificationModel;

    public function __construct() {
        $this->loanModel = new Loan();
        $this->employeeModel = new Employee();
        $this->notificationModel = new Notification();
    }

    // Admin view to manage all loans
    public function index() {
        $this->authorize(['admin']);
        $loans = $this->loanModel->getAll();
        $this->view('loans/index', ['loans' => $loans]);
    }

    // Employee view to see their own loans
    public function myLoans() {
        $this->authorize();
        $loans = $this->loanModel->getForEmployee($_SESSION['user_id']);
        $this->view('loans/my_loans', ['loans' => $loans]);
    }

    public function create() {
        $this->authorize();
        $this->view('loans/create');
    }

    public function store() {
        $this->authorize();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $data['employee_id'] = $_SESSION['user_id'];
            if ($this->loanModel->create($data)) {
                // Notify all admins/managers
                $admins = $this->employeeModel->getAdminsAndManagers();
                $message = "New loan request of ₹" . number_format($data['amount']) . " from " . $_SESSION['user_name'] . ".";
                $link = "/loan";
                foreach ($admins as $admin) {
                    $this->notificationModel->create($admin['id'], $message, $link);
                }
            }
            $this->redirect('/loan/myLoans');
        }
    }

    public function updateStatus($loan_id, $status) {
        $this->authorize(['admin']);
        
        if ($this->loanModel->updateStatus($loan_id, $status)) {
            $loan = $this->loanModel->findById($loan_id);
            $message = "Your loan request of ₹" . number_format($loan['amount']) . " has been " . $status . ".";
            $link = "/loan/myLoans";
            $this->notificationModel->create($loan['employee_id'], $message, $link);
        }
        $this->redirect('/loan');
    }
}
?>