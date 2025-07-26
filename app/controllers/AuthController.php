<?php
class AuthController extends BaseController {
    public function login() {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/dashboard');
        }
        $this->view('auth/login');
    }

    public function attempt() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $employeeModel = new Employee();
            // The findByEmail method now checks if the user is active
            $user = $employeeModel->findByEmail($_POST['email']);

            if ($user && password_verify($_POST['password'], $user['password'])) {
                // Password is correct, start session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
                $_SESSION['user_role'] = $user['role'];
                $this->redirect('/dashboard');
            } else {
                // Invalid credentials or account is deactivated
                $this->view('auth/login', ['error' => 'Invalid credentials or account deactivated.']);
            }
        } else {
            $this->redirect('/login');
        }
    }

    public function logout() {
        session_destroy();
        $this->redirect('/login');
    }
}
?>