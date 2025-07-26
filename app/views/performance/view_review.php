<?php 
$title = "Performance Review";
ob_start(); 
$is_employee = $_SESSION['user_id'] == $review['employee_id'];
$is_manager = $_SESSION['user_id'] == $review['manager_id'];
?>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2 class="h5 mb-0">Review for <?php echo htmlspecialchars($review['first_name'] . ' ' . $review['last_name']); ?></h2>
                <p class="text-muted small mb-0">Cycle: <?php echo htmlspecialchars($review['cycle_name']); ?></p>
            </div>
            <div class="card-body p-4">
                <!-- Self Assessment Section -->
                <div class="mb-4">
                    <h3 class="h6">Self Assessment</h3>
                    <?php if ($review['status'] == 'pending_self_assessment' && $is_employee): ?>
                        <form action="/performance/saveSelfAssessment" method="POST">
                            <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                            <textarea name="self_assessment" rows="8" class="form-control mt-2" placeholder="Describe your accomplishments, strengths, and areas for improvement..." required></textarea>
                            <button type="submit" class="btn btn-primary mt-2">Submit Assessment</button>
                        </form>
                    <?php else: ?>
                        <div class="p-3 bg-light rounded mt-2">
                            <p class="mb-0 fst-italic"><?php echo nl2br(htmlspecialchars($review['self_assessment'] ?? 'Not yet submitted.')); ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Manager Review Section -->
                <div>
                    <h3 class="h6">Manager Review</h3>
                    <?php if ($review['status'] == 'pending_manager_review' && $is_manager): ?>
                        <form action="/performance/saveManagerReview" method="POST">
                            <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                            <div class="mb-3">
                                <label for="manager_assessment" class="form-label">Manager's Assessment</label>
                                <textarea name="manager_assessment" id="manager_assessment" rows="8" class="form-control" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="rating" class="form-label">Overall Rating (1-5)</label>
                                <input type="number" name="rating" id="rating" min="1" max="5" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success">Finalize Review</button>
                        </form>
                    <?php else: ?>
                        <div class="p-3 bg-light rounded mt-2">
                            <p class="mb-0 fst-italic"><?php echo nl2br(htmlspecialchars($review['manager_assessment'] ?? 'Not yet submitted.')); ?></p>
                        </div>
                        <?php if($review['rating']): ?>
                        <p class="mt-2 fw-bold">Final Rating: <span class="badge bg-primary fs-6"><?php echo $review['rating']; ?> / 5</span></p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
