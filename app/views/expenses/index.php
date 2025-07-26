<?php 
$title = "Manage Expense Claims";
ob_start(); 
?>
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="h5 mb-0">All Submitted Expense Claims</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Employee</th>
                        <th scope="col">Date</th>
                        <th scope="col">Category</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Status</th>
                        <th scope="col">Receipt</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($expenses as $item): ?>
                    <tr>
                        <td class="ps-4"><?php echo htmlspecialchars($item['first_name'] . ' ' . $item['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($item['expense_date']); ?></td>
                        <td><?php echo htmlspecialchars($item['category']); ?></td>
                        <td>₹<?php echo number_format($item['amount'], 2); ?></td>
                        <td><?php echo htmlspecialchars($item['status']); ?></td>
                        <td>
                            <?php if($item['receipt_filename']): ?>
                            <a href="/public/uploads/<?php echo htmlspecialchars($item['receipt_filename']); ?>" target="_blank" class="btn btn-sm btn-outline-secondary">View</a>
                            <?php else: echo 'N/A'; endif; ?>
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
