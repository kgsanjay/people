<?php 
$title = "Company Policies";
ob_start(); 
?>
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="h5 mb-0">Company Policies & Handbooks</h3>
    </div>
    <div class="card-body p-0">
        <ul class="list-group list-group-flush">
            <?php if (empty($policies)): ?>
                <li class="list-group-item text-center text-muted py-4">No company policies have been published yet.</li>
            <?php endif; ?>
            <?php foreach($policies as $policy): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <div>
                    <h4 class="h6 mb-0"><?php echo htmlspecialchars($policy['title']); ?></h4>
                    <small class="text-muted">Published on <?php echo date('F j, Y', strtotime($policy['created_at'])); ?></small>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <a href="/public/uploads/<?php echo htmlspecialchars($policy['filename']); ?>" target="_blank" class="btn btn-sm btn-outline-secondary">View Policy</a>
                    <?php if(in_array($policy['id'], $acknowledged_ids)): ?>
                        <span class="badge bg-success-subtle text-success-emphasis p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle me-1" viewBox="0 0 16 16">
                              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                              <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                            </svg>
                            Acknowledged
                        </span>
                    <?php else: ?>
                        <a href="/policy/acknowledge/<?php echo $policy['id']; ?>" class="btn btn-sm btn-success">Acknowledge</a>
                    <?php endif; ?>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
