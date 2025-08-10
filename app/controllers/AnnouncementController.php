<?php
class AnnouncementController extends BaseController {
    private $announcementModel;
    private $employeeModel;
    private $notificationModel;

    public function __construct() {
        $this->authorize(['admin']);
        $this->announcementModel = new Announcement();
        $this->employeeModel = new Employee();
        $this->notificationModel = new Notification();
    }
    public function index() {
        $announcements = $this->announcementModel->getAll();
        $this->view('announcements/index', ['announcements' => $announcements]);
    }
    public function create() {
        $this->view('announcements/form', ['action' => 'create']);
    }
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = ['user_id' => $_SESSION['user_id'], 'title' => $_POST['title'], 'content' => $_POST['content']];
            if ($this->announcementModel->create($data)) {
                $employees = $this->employeeModel->getAllIds();
                $message = "New Announcement: " . htmlspecialchars($data['title']);
                $link = "/dashboard";
                foreach ($employees as $employee) {
                    if ($employee['id'] != $_SESSION['user_id']) {
                        $this->notificationModel->create($employee['id'], $message, $link);
                    }
                }
            }
        }
        $this->redirect('/zoho_clone/announcement');
    }
    public function edit($id) {
        $announcement = $this->announcementModel->findById($id);
        $this->view('announcements/form', ['action' => 'edit', 'announcement' => $announcement]);
    }
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = ['title' => $_POST['title'], 'content' => $_POST['content']];
            $this->announcementModel->update($id, $data);
        }
        $this->redirect('/zoho_clone/announcement');
    }
    public function delete($id) {
        $this->announcementModel->delete($id);
        $this->redirect('/zoho_clone/announcement');
    }
}
?>