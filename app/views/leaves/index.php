<?php 
$title = "My Leave";
ob_start(); 
?>
<div class="d-flex justify-content-end mb-3">
    <a href="/leave/create" class="btn btn-success">
        Apply for Leave
    </a>
</div>
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="h5 mb-0">My Leave History</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Start Date</th>
                        <th scope="col">End Date</th>
                        <th scope="col">Type</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($leaves)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">You have not applied for any leave yet.</td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach ($leaves as $leave): ?>
                    <tr>
                        <td class="ps-4"><?php echo htmlspecialchars($leave['start_date']); ?></td>
                        <td><?php echo htmlspecialchars($leave['end_date']); ?></td>
                        <td><?php echo htmlspecialchars($leave['leave_type_name']); ?></td>
                        <td>
                            <span class="badge <?php 
                                if (str_contains($leave['status'], 'approved')) echo 'bg-success-subtle text-success-emphasis';
                                elseif (str_contains($leave['status'], 'rejected')) echo 'bg-danger-subtle text-danger-emphasis';
                                else echo 'bg-warning-subtle text-warning-emphasis';
                            ?>"><?php echo htmlspecialchars($leave['status']); ?></span>
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
