<?php 
$title = "My Payslips";
ob_start(); 
?>
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="h5 mb-0">My Payslip History</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Pay Period</th>
                        <th scope="col">Gross Earnings</th>
                        <th scope="col">Net Pay</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($payslips)): ?>
                        <tr><td colspan="4" class="text-center text-muted py-4">No payslips have been generated for you yet.</td></tr>
                    <?php endif; ?>
                    <?php foreach($payslips as $slip): ?>
                    <tr>
                        <td class="ps-4 fw-semibold"><?php echo date("F Y", mktime(0, 0, 0, $slip['month'], 1, $slip['year'])); ?></td>
                        <td>₹<?php echo number_format($slip['gross_earnings'], 2); ?></td>
                        <td class="fw-bold">₹<?php echo number_format($slip['net_pay'], 2); ?></td>
                        <td>
                            <a href="/payroll/viewPayslip/<?php echo $slip['id']; ?>" class="btn btn-sm btn-outline-primary">View Details</a>
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
