<?php 
$title = "Checklist Progress";
ob_start(); 
?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="h5 mb-0">Process for <?php echo htmlspecialchars($assignment['first_name'] . ' ' . $assignment['last_name']); ?></h3>
                <p class="text-muted small mb-0">Checklist: <?php echo htmlspecialchars($assignment['checklist_name']); ?></p>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <?php foreach($tasks as $task): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0 <?php echo $task['status'] == 'completed' ? 'text-decoration-line-through text-muted' : ''; ?>"><?php echo htmlspecialchars($task['task_name']); ?></p>
                            <small class="text-muted">Assigned to: <?php echo htmlspecialchars($task['assignee_first_name'] . ' ' . $task['assignee_last_name']); ?></small>
                        </div>
                        <?php if($task['status'] == 'completed'): ?>
                            <span class="badge bg-success-subtle text-success-emphasis">Completed</span>
                        <?php else: ?>
                            <span class="badge bg-warning-subtle text-warning-emphasis">Pending</span>
                        <?php endif; ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="card-footer text-end">
                <a href="/onboarding" class="btn btn-secondary">Back to Onboarding</a>
            </div>
        </div>
    </div>
</div>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
