<?php
class PayrollController extends BaseController {
    private $salaryModel;
    private $employeeModel;
    private $auditLogModel;
    private $payrollRunModel;
    private $payslipModel;
    private $notificationModel;

    public function __construct() {
        $this->salaryModel = new Salary();
        $this->employeeModel = new Employee();
        $this->auditLogModel = new AuditLog();
        $this->payrollRunModel = new PayrollRun();
        $this->payslipModel = new Payslip();
        $this->notificationModel = new Notification();
    }

    // Admin view for salary structures
    public function index() {
        $this->authorize(['admin']);
        $salaries = $this->salaryModel->getAllSalariesWithEmployee();
        $this->view('payroll/index', ['salaries' => $salaries]);
    }

    // Admin view to manage a single employee's salary
    public function manage($employee_id) {
        $this->authorize(['admin']);
        $employee = $this->employeeModel->findById($employee_id);
        $salary = $this->salaryModel->findByEmployeeId($employee_id);
        $this->view('payroll/manage', ['employee' => $employee, 'salary' => $salary]);
    }

    // Update salary structure
    public function update() {
        $this->authorize(['admin']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->salaryModel->createOrUpdate($_POST)) {
                $employee = $this->employeeModel->findById($_POST['employee_id']);
                $details = "Updated salary structure for " . $employee['first_name'] . " " . $employee['last_name'] . ".";
                $this->auditLogModel->logAction($_SESSION['user_id'], 'UPDATE_SALARY', $details);
            }
        }
        $this->redirect('/payroll');
    }

    // NEW: List all payroll runs
    public function runs() {
        $this->authorize(['admin']);
        $runs = $this->payrollRunModel->getAll();
        $this->view('payroll/runs', ['runs' => $runs]);
    }

    // NEW: Show form to create a new run
    public function createRun() {
        $this->authorize(['admin']);
        $this->view('payroll/create_run');
    }

    // NEW: Process and store a payroll run
    public function storeRun() {
        $this->authorize(['admin']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $month = $_POST['month'];
            $year = $_POST['year'];

            // 1. Create the payroll run record
            $run_id = $this->payrollRunModel->create($month, $year, $_SESSION['user_id']);

            // 2. Get all employees with salary structures
            $salaries = $this->salaryModel->getAllSalariesWithEmployee();

            // 3. Loop through and create a payslip for each
            foreach ($salaries as $s) {
                if (isset($s['basic_salary'])) { // Only process if salary is defined
                    $gross = $s['basic_salary'] + $s['hra'] + $s['travel_allowance'] + $s['medical_allowance'];
                    $deductions = $s['pf_deduction'] + $s['tax_deduction'];
                    $net = $gross - $deductions;

                    $payslipData = [
                        'payroll_run_id' => $run_id,
                        'employee_id' => $s['employee_id'],
                        'basic_salary' => $s['basic_salary'],
                        'hra' => $s['hra'],
                        'travel_allowance' => $s['travel_allowance'],
                        'medical_allowance' => $s['medical_allowance'],
                        'pf_deduction' => $s['pf_deduction'],
                        'tax_deduction' => $s['tax_deduction'],
                        'gross_earnings' => $gross,
                        'total_deductions' => $deductions,
                        'net_pay' => $net
                    ];
                    $this->payslipModel->create($payslipData);
                    
                    // 4. Notify employee
                    $message = "Your payslip for " . date("F", mktime(0, 0, 0, $month, 10)) . " " . $year . " is now available.";
                    $this->notificationModel->create($s['employee_id'], $message, "/payroll/myPayslip");
                }
            }
            $this->auditLogModel->logAction($_SESSION['user_id'], 'PAYROLL_RUN', "Executed payroll for " . date("F", mktime(0, 0, 0, $month, 10)) . " " . $year . ".");
        }
        $this->redirect('/payroll/runs');
    }

    // UPDATED: Employee view for their payslips
    public function myPayslip() {
        $this->authorize();
        $payslips = $this->payslipModel->getForEmployee($_SESSION['user_id']);
        $this->view('payroll/my_payslip', ['payslips' => $payslips]);
    }
    
    // NEW: Employee view for a single, historical payslip
    public function viewPayslip($payslip_id) {
        $this->authorize();
        $payslip = $this->payslipModel->findById($payslip_id);
        // Security check: ensure the user can only view their own payslip
        if ($payslip['employee_id'] != $_SESSION['user_id']) {
            exit('Access Denied');
        }
        $this->view('payroll/view_payslip', ['payslip' => $payslip]);
    }
}
?>
