<?php 
$title = "Team Goals";
ob_start(); 
?>
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="h5 mb-0">Set New Goal</h3>
            </div>
            <div class="card-body">
                <form action="/goal/store" method="POST">
                    <div class="mb-3">
                        <label for="employee_id" class="form-label">Employee</label>
                        <select name="employee_id" id="employee_id" class="form-select" required>
                            <?php foreach($team_members as $member): ?>
                            <option value="<?php echo $member['id']; ?>"><?php echo htmlspecialchars($member['first_name'] . ' ' . $member['last_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Goal Title / Objective</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="review_period" class="form-label">Review Period</label>
                        <input type="text" name="review_period" id="review_period" placeholder="e.g., Q3 2025" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                            <option value="on_hold">On Hold</option>
                        </select>
                    </div>
                    <hr>
                    <h4 class="h6 mb-3">Key Results</h4>
                    <div class="d-grid gap-2 mb-3">
                        <input type="text" name="key_results[]" placeholder="Key Result 1" class="form-control form-control-sm">
                        <input type="text" name="key_results[]" placeholder="Key Result 2" class="form-control form-control-sm">
                        <input type="text" name="key_results[]" placeholder="Key Result 3" class="form-control form-control-sm">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Save Goal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <h3 class="h4 mb-4 text-gray-700">Team Goal Progress</h3>
        <div class="d-grid gap-3">
            <?php foreach($goals as $goal): ?>
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h4 class="h6 mb-0 fw-semibold"><?php echo htmlspecialchars($goal['first_name'] . ' ' . $goal['last_name']); ?></h4>
                    <p class="small text-muted mb-0"><?php echo htmlspecialchars($goal['title']); ?> (<?php echo htmlspecialchars($goal['review_period']); ?>)</p>
                </div>
                <div class="card-body">
                    <?php foreach($goal['key_results'] as $kr): ?>
                    <div class="mb-2">
                        <div class="d-flex justify-content-between">
                            <span class="small"><?php echo htmlspecialchars($kr['description']); ?></span>
                            <span class="small fw-bold"><?php echo $kr['progress']; ?>%</span>
                        </div>
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar" role="progressbar" style="width: <?php echo $kr['progress']; ?>%;" aria-valuenow="<?php echo $kr['progress']; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
