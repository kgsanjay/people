<?php 
$title = "Give Feedback";
ob_start(); 
?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="h5 mb-0"><?php echo $title; ?></h3>
            </div>
            <div class="card-body">
                <form action="/feedback/storeFeedback" method="POST">
                    <input type="hidden" name="request_id" value="<?php echo $request_id ?? ''; ?>">
                    <div class="mb-3">
                        <label for="receiver_id" class="form-label">To</label>
                        <select name="receiver_id" id="receiver_id" class="form-select" <?php echo isset($receiver_id) ? 'disabled' : ''; ?> required>
                            <?php foreach($employees as $employee): ?>
                            <option value="<?php echo $employee['id']; ?>" <?php echo ($receiver_id ?? 0) == $employee['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if(isset($receiver_id)): ?>
                        <input type="hidden" name="receiver_id" value="<?php echo $receiver_id; ?>">
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Feedback</label>
                        <textarea name="content" id="content" rows="6" class="form-control" required></textarea>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" name="is_public" id="is_public" value="1" class="form-check-input">
                        <label for="is_public" class="form-check-label">Visible to manager</label>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="/feedback" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Submit Feedback</button>
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
