<?php 
$title = "My Goals";
ob_start(); 
?>
<div class="d-grid gap-4">
    <?php if (empty($goals)): ?>
        <div class="card">
            <div class="card-body text-center text-muted">
                You do not have any goals set.
            </div>
        </div>
    <?php endif; ?>
    <?php foreach($goals as $goal): ?>
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="h5 mb-0"><?php echo htmlspecialchars($goal['title']); ?></h3>
                <span class="badge bg-primary-subtle text-primary-emphasis"><?php echo htmlspecialchars($goal['review_period']); ?></span>
            </div>
        </div>
        <div class="card-body">
            <h4 class="h6 text-muted mb-3">Key Results</h4>
            <div class="d-grid gap-3">
                <?php foreach($goal['key_results'] as $kr): ?>
                <div>
                    <p class="mb-1"><?php echo htmlspecialchars($kr['description']); ?></p>
                    <form action="/goal/updateProgress" method="POST" class="d-flex align-items-center gap-3">
                        <input type="hidden" name="kr_id" value="<?php echo $kr['id']; ?>">
                        <div class="progress flex-grow-1" style="height: 10px;">
                            <div class="progress-bar" role="progressbar" style="width: <?php echo $kr['progress']; ?>%;" aria-valuenow="<?php echo $kr['progress']; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <input type="range" name="progress" min="0" max="100" value="<?php echo $kr['progress']; ?>" class="form-range w-25">
                        <span class="fw-bold text-primary" style="width: 45px;"><?php echo $kr['progress']; ?>%</span>
                        <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
                    </form>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
