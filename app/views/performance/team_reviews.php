<?php 
$title = "Team Reviews";
ob_start(); 
?>
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="h5 mb-0">Team Performance Reviews</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Employee</th>
                        <th scope="col">Review Cycle</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($reviews)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No performance reviews have been initiated for your team.</td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach($reviews as $review): ?>
                    <tr>
                        <td class="ps-4"><?php echo htmlspecialchars($review['first_name'] . ' ' . $review['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($review['cycle_name']); ?></td>
                        <td>
                            <span class="badge <?php 
                                if ($review['status'] == 'pending_self_assessment') echo 'bg-warning-subtle text-warning-emphasis';
                                elseif ($review['status'] == 'pending_manager_review') echo 'bg-primary-subtle text-primary-emphasis';
                                else echo 'bg-success-subtle text-success-emphasis';
                            ?>"><?php echo ucfirst(str_replace('_', ' ', $review['status'])); ?></span>
                        </td>
                        <td>
                            <a href="/performance/view/<?php echo $review['id']; ?>" class="btn btn-sm btn-outline-secondary">
                                <?php echo $review['status'] == 'pending_manager_review' ? 'Complete Review' : 'View'; ?>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
