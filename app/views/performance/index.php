<?php 
$title = "Performance Management";
ob_start(); 
?>
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="h5 mb-0">Create Review Cycle</h3>
            </div>
            <div class="card-body">
                <form action="/performance/createCycle" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Cycle Name</label>
                        <input type="text" name="name" id="name" placeholder="e.g., Annual Review 2025" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Create Cycle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="h5 mb-0">Initiate Reviews</h3>
            </div>
            <div class="card-body">
                <form action="/performance/initiateReviews" method="POST">
                    <div class="mb-3">
                        <label for="cycle_id" class="form-label">Select Cycle</label>
                        <select name="cycle_id" id="cycle_id" class="form-select" required>
                            <?php foreach($cycles as $cycle): ?>
                            <option value="<?php echo $cycle['id']; ?>"><?php echo htmlspecialchars($cycle['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="employee_ids" class="form-label">Select Employees (multiple selection is possible)</label>
                        <select name="employee_ids[]" id="employee_ids" class="form-select" multiple required size="10">
                            <?php foreach($employees as $employee): ?>
                            <option value="<?php echo $employee['id']; ?>"><?php echo htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">Start Reviews for Selected Employees</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
