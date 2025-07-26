<?php 
$title = "Manage Loan Requests";
ob_start(); 
?>
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="h5 mb-0">All Loan Requests</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Employee</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Reason</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($loans)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No loan requests found.</td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach($loans as $loan): ?>
                    <tr>
                        <td class="ps-4"><?php echo htmlspecialchars($loan['first_name'] . ' ' . $loan['last_name']); ?></td>
                        <td>₹<?php echo number_format($loan['amount'], 2); ?></td>
                        <td><?php echo htmlspecialchars($loan['reason']); ?></td>
                        <td>
                            <span class="badge <?php 
                                if ($loan['status'] == 'pending') echo 'bg-warning-subtle text-warning-emphasis';
                                elseif ($loan['status'] == 'approved') echo 'bg-success-subtle text-success-emphasis';
                                else echo 'bg-danger-subtle text-danger-emphasis';
                            ?>"><?php echo ucfirst($loan['status']); ?></span>
                        </td>
                        <td class="text-nowrap">
                            <?php if($loan['status'] == 'pending'): ?>
                                <a href="/loan/updateStatus/<?php echo $loan['id']; ?>/approved" class="btn btn-sm btn-outline-success">Approve</a>
                                <a href="/loan/updateStatus/<?php echo $loan['id']; ?>/rejected" class="btn btn-sm btn-outline-danger">Reject</a>
                            <?php else: ?>
                                <span class="text-muted small">Actioned</span>
                            <?php endif; ?>
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
