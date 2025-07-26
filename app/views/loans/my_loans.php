<?php 
$title = "My Loans";
ob_start(); 
?>
<div class="d-flex justify-content-end mb-3">
    <a href="/loan/create" class="btn btn-success">
        Request New Loan
    </a>
</div>
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="h5 mb-0">My Loan Requests</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Date Requested</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Reason</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($loans)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">You have not requested any loans.</td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach($loans as $loan): ?>
                    <tr>
                        <td class="ps-4"><?php echo date('M j, Y', strtotime($loan['created_at'])); ?></td>
                        <td>₹<?php echo number_format($loan['amount'], 2); ?></td>
                        <td><?php echo htmlspecialchars($loan['reason']); ?></td>
                        <td>
                            <span class="badge <?php 
                                if ($loan['status'] == 'pending') echo 'bg-warning-subtle text-warning-emphasis';
                                elseif ($loan['status'] == 'approved') echo 'bg-success-subtle text-success-emphasis';
                                else echo 'bg-danger-subtle text-danger-emphasis';
                            ?>"><?php echo ucfirst($loan['status']); ?></span>
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
