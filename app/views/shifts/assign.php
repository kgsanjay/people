<?php 
$title = "Assign Employee to Shift";
ob_start(); 
?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="h5 mb-0"><?php echo $title; ?></h3>
            </div>
            <div class="card-body">
                <form action="/shift/storeAssignment" method="POST">
                    <div class="mb-3">
                        <label for="employee_id" class="form-label">Employee</label>
                        <select name="employee_id" id="employee_id" class="form-select" required>
                            <option value="">-- Select Employee --</option>
                            <?php foreach($employees as $employee): ?>
                            <option value="<?php echo $employee['id']; ?>"><?php echo htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="shift_id" class="form-label">Shift</label>
                        <select name="shift_id" id="shift_id" class="form-select" required>
                            <option value="">-- Select Shift --</option>
                            <?php foreach($shifts as $shift): ?>
                            <option value="<?php echo $shift['id']; ?>"><?php echo htmlspecialchars($shift['name']); ?> (<?php echo date('g:i A', strtotime($shift['start_time'])); ?> - <?php echo date('g:i A', strtotime($shift['end_time'])); ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <a href="/shift" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Assign Shift</button>
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
