<?php 
$title = "Payroll Runs";
ob_start(); 
?>
<div class="d-flex justify-content-end mb-3">
    <a href="/payroll/createRun" class="btn btn-success">
        Run New Payroll
    </a>
</div>
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="h5 mb-0">Payroll Run History</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Pay Period</th>
                        <th scope="col">Run Date</th>
                        <th scope="col">Run By</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($runs as $run): ?>
                    <tr>
                        <td class="ps-4 fw-semibold"><?php echo date("F Y", mktime(0, 0, 0, $run['month'], 1, $run['year'])); ?></td>
                        <td><?php echo date('M j, Y', strtotime($run['run_date'])); ?></td>
                        <td><?php echo htmlspecialchars($run['first_name'] . ' ' . $run['last_name']); ?></td>
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
