<?php
class ReportController extends BaseController {

    public function __construct() {
        $this->authorize(['admin']);
    }

    public function index() {
        $this->view('reports/index');
    }

    public function headcount() {
        $employeeModel = new Employee();
        $data = $employeeModel->getHeadcountByDepartment();
        $this->view('reports/headcount', ['data' => $data]);
    }

    public function leave() {
        $leaveModel = new LeaveRequest();
        $results = [];
        
        // Check if form is submitted
        if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
            $start_date = $_GET['start_date'];
            $end_date = $_GET['end_date'];
            $status = $_GET['status'] ?? 'all';
            $results = $leaveModel->getReportByDateRange($start_date, $end_date, $status);
        }

        $this->view('reports/leave', ['results' => $results]);
    }

    public function attendance() {
        $employeeModel = new Employee();
        $attendanceModel = new Attendance();
        $results = [];

        if (isset($_GET['employee_id']) && isset($_GET['start_date'])) {
            $employee_id = $_GET['employee_id'];
            $start_date = $_GET['start_date'];
            $end_date = $_GET['end_date'];
            $results = $attendanceModel->getReportByEmployeeAndDate($employee_id, $start_date, $end_date);
        }

        $employees = $employeeModel->getAll();
        $this->view('reports/attendance', ['employees' => $employees, 'results' => $results]);
    }
}
?>
