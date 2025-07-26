<?php
class AttendanceController extends BaseController {
    private $attendanceModel;

    public function __construct() {
        $this->checkAuth();
        $this->attendanceModel = new Attendance();
    }

    public function index() {
        $today_attendance = $this->attendanceModel->getTodayAttendance($_SESSION['user_id']);
        $attendance_history = $this->attendanceModel->getForEmployee($_SESSION['user_id']);

        $this->view('attendance/index', [
            'today_attendance' => $today_attendance,
            'attendance_history' => $attendance_history
        ]);
    }

    public function clockin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->attendanceModel->clockIn($_SESSION['user_id']);
        }
        $this->redirect('/attendance');
    }

    public function clockout() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $attendance_id = $_POST['attendance_id'];
            $this->attendanceModel->clockOut($attendance_id);
        }
        $this->redirect('/attendance');
    }
}
?>