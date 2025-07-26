<?php 
$title = "Apply for Leave";
ob_start(); 
?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="h5 mb-0"><?php echo $title; ?></h3>
            </div>
            <div class="card-body">
                <form action="/leave/store" method="POST">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="leave_type_id" class="form-label">Leave Type</label>
                            <select name="leave_type_id" id="leave_type_id" class="form-select" required>
                                <?php foreach($leave_types as $type): ?>
                                <option value="<?php echo $type['id']; ?>"><?php echo htmlspecialchars($type['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label for="reason" class="form-label">Reason</label>
                            <textarea name="reason" id="reason" rows="4" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="mt-4 d-flex justify-content-end">
                        <a href="/leave" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Submit Request</button>
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
