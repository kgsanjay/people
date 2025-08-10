<?php
class PerformanceController extends BaseController {
    private $reviewCycleModel;
    private $performanceReviewModel;
    private $employeeModel;
    private $notificationModel;

    public function __construct() {
        $this->reviewCycleModel = new ReviewCycle();
        $this->performanceReviewModel = new PerformanceReview();
        $this->employeeModel = new Employee();
        $this->notificationModel = new Notification();
    }

    // Admin: Manage review cycles
    public function index() {
        $this->authorize(['admin']);
        $cycles = $this->reviewCycleModel->getAll();
        $employees = $this->employeeModel->getAll();
        $this->view('performance/index', ['cycles' => $cycles, 'employees' => $employees]);
    }

    public function createCycle() {
        $this->authorize(['admin']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->reviewCycleModel->create($_POST['name'], $_POST['start_date'], $_POST['end_date']);
        }
        $this->redirect('/performance');
    }

    public function initiateReviews() {
        $this->authorize(['admin']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cycle_id = $_POST['cycle_id'];
            $employee_ids = $_POST['employee_ids'];
            foreach ($employee_ids as $employee_id) {
                $employee = $this->employeeModel->findById($employee_id);
                if ($employee && $employee['reports_to']) {
                    $this->performanceReviewModel->create($cycle_id, $employee_id, $employee['reports_to']);
                    $message = "A new performance review has been initiated for you. Please complete your self-assessment.";
                    $this->notificationModel->create($employee_id, $message, "/performance/myReviews");
                }
            }
        }
        $this->redirect('/performance');
    }

    // Employee: View their own reviews
    public function myReviews() {
        $this->authorize();
        $reviews = $this->performanceReviewModel->getForEmployee($_SESSION['user_id']);
        $this->view('performance/my_reviews', ['reviews' => $reviews]);
    }

    // Manager: View team reviews
    public function team() {
        $this->authorize(['admin', 'manager']);
        $reviews = $this->performanceReviewModel->getForManager($_SESSION['user_id']);
        $this->view('performance/team_reviews', ['reviews' => $reviews]);
    }
    
    public function view($review_id) {
        $this->authorize();
        $review = $this->performanceReviewModel->findById($review_id);
        // Security check
        if ($review['employee_id'] != $_SESSION['user_id'] && $review['manager_id'] != $_SESSION['user_id']) {
            exit('Access Denied');
        }
        $this->view('performance/view_review', ['review' => $review]);
    }

    public function saveSelfAssessment() {
        $this->authorize();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $review_id = $_POST['review_id'];
            $review = $this->performanceReviewModel->findById($review_id);
            if ($review['employee_id'] == $_SESSION['user_id']) {
                $this->performanceReviewModel->submitSelfAssessment($review_id, $_POST['self_assessment']);
                $message = $review['first_name'] . " has completed their self-assessment. Please complete the manager review.";
                $this->notificationModel->create($review['manager_id'], $message, "/performance/view/" . $review_id);
            }
        }
        $this->redirect('/performance/myReviews');
    }

    public function saveManagerReview() {
        $this->authorize();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $review_id = $_POST['review_id'];
            $review = $this->performanceReviewModel->findById($review_id);
            if ($review['manager_id'] == $_SESSION['user_id']) {
                $this->performanceReviewModel->submitManagerReview($review_id, $_POST['manager_assessment'], $_POST['rating']);
                $message = "Your manager has completed your performance review for '" . $review['cycle_name'] . "'.";
                $this->notificationModel->create($review['employee_id'], $message, "/performance/view/" . $review_id);
            }
        }
        $this->redirect('/performance/team');
    }
}
?>
