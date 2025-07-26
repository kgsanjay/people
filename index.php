<?php
session_start();
require_once __DIR__ . '/config/database.php';

spl_autoload_register(function ($class_name) {
    if (file_exists(__DIR__ . '/app/controllers/' . $class_name . '.php')) {
        require_once __DIR__ . '/app/controllers/' . $class_name . '.php';
    } elseif (file_exists(__DIR__ . '/app/models/' . $class_name . '.php')) {
        require_once __DIR__ . '/app/models/' . $class_name . '.php';
    }
});

class BaseModel {
    protected static $conn;
    public function __construct() {
        if (self::$conn === null) {
            date_default_timezone_set('Asia/Kolkata');
            self::$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if (self::$conn->connect_error) {
                die("Connection failed: " . self::$conn->connect_error);
            }
        }
    }
}

class BaseController {
    protected function view($view, $data = []) {
        extract($data);
        require __DIR__ . '/app/views/' . $view . '.php';
    }
    protected function redirect($url) {
        header('Location: ' . $url);
        exit();
    }
    protected function checkAuth() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
    }
    protected function loadNotifications() {
        if (isset($_SESSION['user_id'])) {
            $notificationModel = new Notification();
            return $notificationModel->getUnreadForUser($_SESSION['user_id']);
        }
        return [];
    }
}

$request_uri = strtok($_SERVER['REQUEST_URI'], '?');
$base_path = '/people';
$request = str_replace($base_path, '', $request_uri);
$request = trim($request, '/');
$segments = explode('/', $request);

$controller_name = 'DashboardController';
$method_name = 'index';
$params = [];

if (!empty($segments[0])) {
    if ($segments[0] === 'careers') {
        $controller_name = 'CareersController';
    } else {
        $controller_name = ucfirst($segments[0]) . 'Controller';
    }
    $method_name = isset($segments[1]) ? $segments[1] : 'index';
    $params = array_slice($segments, 2);
}

if ($request === 'login' || empty($segments[0])) {
    $controller_name = 'DashboardController';
    if($request === 'login') {
        $controller_name = 'AuthController';
        $method_name = 'login';
    }
}
if ($request === 'logout') {
    $controller_name = 'AuthController';
    $method_name = 'logout';
}
if ($request === 'auth/attempt') {
    $controller_name = 'AuthController';
    $method_name = 'attempt';
}

if (class_exists($controller_name)) {
    $controller = new $controller_name();
    if (method_exists($controller, $method_name)) {
        call_user_func_array([$controller, $method_name], $params);
    } else {
        http_response_code(404);
        echo "404 - Method Not Found";
    }
} else {
    if ($controller_name !== 'AuthController' && $controller_name !== 'CareersController') {
         http_response_code(404);
         echo "404 - Controller Not Found: {$controller_name}";
    }
}
?>