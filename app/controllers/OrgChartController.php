<?php
class OrgChartController extends BaseController {

    public function __construct() {
        $this->checkAuth();
    }

    public function index() {
        $employeeModel = new Employee();
        $employees = $employeeModel->getHierarchy();
        
        $chartData = [];
        foreach ($employees as $employee) {
            $node = [
                'v' => (string)$employee['id'],
                'f' => $employee['first_name'] . ' ' . $employee['last_name'] . '<div style="color:red; font-style:italic">' . $employee['job_title'] . '</div>'
            ];
            $manager = $employee['reports_to'] ? (string)$employee['reports_to'] : '';
            $chartData[] = [$node, $manager, ''];
        }

        $this->view('orgchart/index', ['chartDataJson' => json_encode($chartData)]);
    }
}
?>
