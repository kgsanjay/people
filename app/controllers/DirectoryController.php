<?php
class DirectoryController extends BaseController {
    private $employeeModel;

    public function __construct() {
        $this->checkAuth();
        $this->employeeModel = new Employee();
    }

    public function index() {
        $employees = $this->employeeModel->getAll();
        $this->view('directory/index', ['employees' => $employees]);
    }
}
?>