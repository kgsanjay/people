<?php 
$title = "Request Feedback";
ob_start(); 
?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="h5 mb-0"><?php echo $title; ?></h3>
            </div>
            <div class="card-body">
                <form action="/feedback/storeRequest" method="POST">
                    <div class="mb-3">
                        <label for="provider_id" class="form-label">Request From</label>
                        <select name="provider_id" id="provider_id" class="form-select" required>
                            <?php foreach($employees as $employee): ?>
                            <?php if($employee['id'] != $_SESSION['user_id']): ?>
                            <option value="<?php echo $employee['id']; ?>"><?php echo htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']); ?></option>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="context" class="form-label">What do you want feedback on?</label>
                        <textarea name="context" id="context" rows="4" class="form-control" placeholder="e.g., My presentation on the Q3 project." required></textarea>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="/feedback" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Send Request</button>
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
