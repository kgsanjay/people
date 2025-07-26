<?php
class ProjectController extends BaseController {
    private $projectModel;
    private $auditLogModel;

    public function __construct() {
        $this->checkAuth();
        // Only admins can manage projects
        if ($_SESSION['user_role'] !== 'admin') {
            echo "Access Denied";
            exit();
        }
        $this->projectModel = new Project();
        $this->auditLogModel = new AuditLog();
    }

    public function index() {
        $projects = $this->projectModel->getAll();
        $this->view('projects/index', ['projects' => $projects]);
    }

    public function create() {
        $this->view('projects/form', ['action' => 'create']);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->projectModel->create($_POST)) {
                $this->auditLogModel->logAction($_SESSION['user_id'], 'CREATE_PROJECT', "Created project: " . $_POST['name']);
            }
            $this->redirect('/projects');
        }
    }

    public function edit($id) {
        $project = $this->projectModel->findById($id);
        $this->view('projects/form', ['action' => 'edit', 'project' => $project]);
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->projectModel->update($id, $_POST)) {
                $this->auditLogModel->logAction($_SESSION['user_id'], 'UPDATE_PROJECT', "Updated project ID: " . $id);
            }
            $this->redirect('/projects');
        }
    }

    public function delete($id) {
        $project = $this->projectModel->findById($id);
        if ($this->projectModel->delete($id)) {
            $this->auditLogModel->logAction($_SESSION['user_id'], 'DELETE_PROJECT', "Deleted project: " . $project['name'] . " (ID: " . $id . ")");
        }
        $this->redirect('/projects');
    }
}
?>
