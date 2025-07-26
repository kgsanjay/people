<?php
class HelpDeskController extends BaseController {
    private $ticketModel;
    private $departmentModel;
    private $employeeModel;
    private $notificationModel;

    public function __construct() {
        $this->checkAuth();
        $this->ticketModel = new Ticket();
        $this->departmentModel = new Department();
        $this->employeeModel = new Employee();
        $this->notificationModel = new Notification();
    }

    // Admin/Manager view to manage all tickets
    public function index() {
        if ($_SESSION['user_role'] === 'employee') {
            $this->redirect('/helpdesk/myTickets');
        }
        $tickets = $this->ticketModel->getAll();
        $admins = $this->employeeModel->getAdminsAndManagers(); // Simplified: any admin/manager can be assigned
        $this->view('helpdesk/index', ['tickets' => $tickets, 'admins' => $admins]);
    }

    // Employee view to see their own tickets
    public function myTickets() {
        $tickets = $this->ticketModel->getForEmployee($_SESSION['user_id']);
        $this->view('helpdesk/my_tickets', ['tickets' => $tickets]);
    }

    public function create() {
        $departments = $this->departmentModel->getAll();
        $this->view('helpdesk/create', ['departments' => $departments]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $data['employee_id'] = $_SESSION['user_id'];
            if ($this->ticketModel->create($data)) {
                // Notify all admins/managers
                $admins = $this->employeeModel->getAdminsAndManagers();
                $message = "New help desk ticket '" . htmlspecialchars($data['subject']) . "' has been raised.";
                $link = "/helpdesk";
                foreach ($admins as $admin) {
                    $this->notificationModel->create($admin['id'], $message, $link);
                }
            }
            $this->redirect('/helpdesk/myTickets');
        }
    }

    public function update() {
        if ($_SESSION['user_role'] === 'employee') { exit('Access Denied'); }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ticket_id = $_POST['ticket_id'];
            $status = $_POST['status'];
            $assigned_to = $_POST['assigned_to'];
            
            $ticket = $this->ticketModel->findById($ticket_id);
            if ($this->ticketModel->updateStatusAndAssignment($ticket_id, $status, $assigned_to)) {
                // Notify employee of status change
                $message = "The status of your ticket '" . htmlspecialchars($ticket['subject']) . "' has been updated to " . ucfirst($status) . ".";
                $link = "/helpdesk/myTickets";
                $this->notificationModel->create($ticket['employee_id'], $message, $link);

                // Notify newly assigned user
                if ($assigned_to && $assigned_to != $ticket['assigned_to']) {
                    $message = "You have been assigned a new ticket: '" . htmlspecialchars($ticket['subject']) . "'.";
                    $this->notificationModel->create($assigned_to, $message, "/helpdesk");
                }
            }
        }
        $this->redirect('/helpdesk');
    }
}
?>
