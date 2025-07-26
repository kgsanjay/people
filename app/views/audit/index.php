<?php 
$title = "Audit Log";
ob_start(); 
?>
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="h5 mb-0">System Actions Log</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Timestamp</th>
                        <th scope="col">User</th>
                        <th scope="col">Action</th>
                        <th scope="col">Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($logs)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No audit records found.</td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach($logs as $log): ?>
                    <tr>
                        <td class="ps-4 text-nowrap"><?php echo date('M j, Y, g:i:s a', strtotime($log['created_at'])); ?></td>
                        <td><?php echo htmlspecialchars($log['first_name'] . ' ' . $log['last_name']); ?></td>
                        <td>
                            <span class="badge bg-secondary-subtle text-secondary-emphasis font-monospace"><?php echo htmlspecialchars($log['action']); ?></span>
                        </td>
                        <td><?php echo htmlspecialchars($log['details']); ?></td>
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
