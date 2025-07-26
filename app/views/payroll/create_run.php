<?php 
$title = "Run New Payroll";
ob_start(); 
?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="h5 mb-0"><?php echo $title; ?></h3>
            </div>
            <div class="card-body">
                <p class="card-text text-muted">Select the month and year to generate payslips for all employees with a defined salary structure. This action cannot be undone.</p>
                <form action="/payroll/storeRun" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="month" class="form-label">Month</label>
                            <select name="month" id="month" class="form-select" required>
                                <?php for ($m=1; $m<=12; $m++): ?>
                                    <option value="<?php echo $m; ?>" <?php echo $m == date('m') ? 'selected' : ''; ?>><?php echo date('F', mktime(0,0,0,$m, 1, date('Y'))); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="year" class="form-label">Year</label>
                            <input type="number" name="year" id="year" class="form-control" value="<?php echo date('Y'); ?>" required>
                        </div>
                    </div>
                    <div class="mt-4 d-flex justify-content-end">
                        <a href="/payroll/runs" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Execute Payroll Run</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
