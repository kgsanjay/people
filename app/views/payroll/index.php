<?php 
$title = "Payroll Summary";
ob_start(); 
?>
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="h5 mb-0">Salary Structures</h3>
        <a href="/payroll/runs" class="btn btn-secondary btn-sm">View Payroll Runs</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Employee</th>
                        <th scope="col">Gross Earnings</th>
                        <th scope="col">Deductions</th>
                        <th scope="col">Net Pay</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($salaries as $s): ?>
                    <?php
                        $gross = ($s['basic_salary'] ?? 0) + ($s['hra'] ?? 0) + ($s['travel_allowance'] ?? 0) + ($s['medical_allowance'] ?? 0);
                        $deductions = ($s['pf_deduction'] ?? 0) + ($s['tax_deduction'] ?? 0);
                        $net = $gross - $deductions;
                    ?>
                    <tr>
                        <td class="ps-4">
                            <div class="fw-semibold"><?php echo htmlspecialchars($s['first_name'] . ' ' . $s['last_name']); ?></div>
                            <div class="small text-muted"><?php echo htmlspecialchars($s['job_title']); ?></div>
                        </td>
                        <td class="text-success">₹<?php echo number_format($gross, 2); ?></td>
                        <td class="text-danger">₹<?php echo number_format($deductions, 2); ?></td>
                        <td class="fw-bold">₹<?php echo number_format($net, 2); ?></td>
                        <td>
                            <a href="/payroll/manage/<?php echo $s['id']; ?>" class="btn btn-sm btn-outline-primary">Manage Salary</a>
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
