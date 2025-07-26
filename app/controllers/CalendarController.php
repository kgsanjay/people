<?php
class CalendarController extends BaseController {

    public function __construct() {
        $this.checkAuth();
    }

    public function index() {
        $leaveModel = new LeaveRequest();
        $reviewModel = new PerformanceReview();
        
        $events = [];

        // Fetch approved leaves
        $approvedLeaves = $leaveModel->getAllApprovedForCalendar();
        foreach ($approvedLeaves as $leave) {
            $events[] = [
                'title' => $leave['first_name'] . ' ' . $leave['last_name'] . ' on Leave',
                'start' => $leave['start_date'],
                'end' => date('Y-m-d', strtotime($leave['end_date'] . ' +1 day')), // FullCalendar end date is exclusive
                'backgroundColor' => '#f59e0b', // amber-500
                'borderColor' => '#f59e0b'
            ];
        }

        // Fetch performance reviews
        $reviews = $reviewModel->getAllForCalendar();
        foreach ($reviews as $review) {
            $events[] = [
                'title' => 'Review: ' . $review['first_name'] . ' ' . $review['last_name'],
                'start' => $review['review_date'],
                'backgroundColor' => '#8b5cf6', // violet-500
                'borderColor' => '#8b5cf6'
            ];
        }

        // Pass events as a JSON string to the view
        $this->view('calendar/index', ['eventsJson' => json_encode($events)]);
    }
}
?>