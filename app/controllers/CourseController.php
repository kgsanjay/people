<?php
class CourseController extends BaseController {
    private $courseModel;
    private $enrollmentModel;
    private $lessonModel;
    private $progressModel;
    private $notificationModel;
    private $employeeModel;

    public function __construct() {
        $this->checkAuth();
        $this->courseModel = new Course();
        $this->enrollmentModel = new CourseEnrollment();
        $this->lessonModel = new Lesson();
        $this->progressModel = new CourseProgress();
        $this->notificationModel = new Notification();
        $this->employeeModel = new Employee();
    }

    // Admin: Manage courses and lessons
    public function index() {
        if ($_SESSION['user_role'] !== 'admin') { exit('Access Denied'); }
        $courses = $this->courseModel->getAll();
        foreach ($courses as &$course) {
            $course['lessons'] = $this->lessonModel->getForCourse($course['id']);
        }
        $this->view('courses/index', ['courses' => $courses]);
    }

    public function create() {
        if ($_SESSION['user_role'] !== 'admin') { exit('Access Denied'); }
        $this->view('courses/form', ['action' => 'create']);
    }

    public function store() {
        if ($_SESSION['user_role'] !== 'admin') { exit('Access Denied'); }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->courseModel->create($_POST);
        }
        $this->redirect('/course');
    }
    
    public function storeLesson() {
        if ($_SESSION['user_role'] !== 'admin') { exit('Access Denied'); }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->lessonModel->create($_POST['course_id'], $_POST['title'], $_POST['content']);
        }
        $this->redirect('/course');
    }
    
    public function deleteLesson($lesson_id) {
        if ($_SESSION['user_role'] !== 'admin') { exit('Access Denied'); }
        $this->lessonModel->delete($lesson_id);
        $this->redirect('/course');
    }

    // Employee: View course catalog
    public function catalog() {
        $courses = $this->courseModel->getAll();
        $this->view('courses/catalog', ['courses' => $courses]);
    }

    // Employee: View a single course
    public function view($course_id) {
        $this->enrollmentModel->enroll($_SESSION['user_id'], $course_id); // Auto-enroll on view
        $course = $this->courseModel->findById($course_id);
        $lessons = $this->lessonModel->getForCourse($course_id);
        $completed_ids = $this->progressModel->getCompletedLessonIds($_SESSION['user_id'], $course_id);
        
        $this->view('courses/view', [
            'course' => $course, 
            'lessons' => $lessons,
            'completed_ids' => $completed_ids
        ]);
    }
    
    // Employee: Mark a lesson as complete
    public function completeLesson($course_id, $lesson_id) {
        $this->progressModel->markComplete($_SESSION['user_id'], $lesson_id);
        $this->redirect('/course/view/' . $course_id);
    }
}
?>