<?php 
$title = "My Claims";
ob_start(); 
?>
<div class="d-flex justify-content-end mb-3">
    <a href="/claims/create" class="btn btn-success">
        Submit New Claim
    </a>
</div>
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="h5 mb-0">My Submitted Claims</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Date</th>
                        <th scope="col">Category</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($claims)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">You have not submitted any claims.</td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach($claims as $item): ?>
                    <tr>
                        <td class="ps-4"><?php echo htmlspecialchars($item['claim_date']); ?></td>
                        <td><?php echo htmlspecialchars($item['category']); ?></td>
                        <td>₹<?php echo number_format($item['amount'], 2); ?></td>
                        <td><?php echo htmlspecialchars($item['status']); ?></td>
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
