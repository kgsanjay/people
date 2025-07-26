<?php 
$title = "Initiate Exit Process";
ob_start(); 
?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="h5 mb-0">Initiate Exit for <?php echo htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']); ?></h3>
            </div>
            <div class="card-body">
                <form action="/exit/store" method="POST">
                    <input type="hidden" name="employee_id" value="<?php echo $employee['id']; ?>">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="resignation_date" class="form-label">Resignation Date</label>
                            <input type="date" name="resignation_date" id="resignation_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="last_working_day" class="form-label">Last Working Day</label>
                            <input type="date" name="last_working_day" id="last_working_day" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label for="reason" class="form-label">Reason for Leaving</label>
                            <textarea name="reason" id="reason" rows="4" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="mt-4 d-flex justify-content-end">
                        <a href="/employees/profile/<?php echo $employee['id']; ?>" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Initiate Process</button>
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
