<?php 
$title = "Manage Salary";
ob_start(); 
?>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="h5 mb-0">Salary Structure for <?php echo htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']); ?></h3>
                <p class="text-muted small mb-0"><?php echo htmlspecialchars($employee['job_title']); ?></p>
            </div>
            <div class="card-body">
                <form action="/payroll/update" method="POST">
                    <input type="hidden" name="employee_id" value="<?php echo $employee['id']; ?>">
                    <div class="row g-3">
                        <!-- Earnings Section -->
                        <div class="col-12">
                            <h4 class="h6">Earnings</h4>
                            <hr class="mt-1">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Basic Salary</label>
                            <input type="number" step="0.01" name="basic_salary" class="form-control" value="<?php echo $salary['basic_salary'] ?? '0.00'; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">House Rent Allowance (HRA)</label>
                            <input type="number" step="0.01" name="hra" class="form-control" value="<?php echo $salary['hra'] ?? '0.00'; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Travel Allowance</label>
                            <input type="number" step="0.01" name="travel_allowance" class="form-control" value="<?php echo $salary['travel_allowance'] ?? '0.00'; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Medical Allowance</label>
                            <input type="number" step="0.01" name="medical_allowance" class="form-control" value="<?php echo $salary['medical_allowance'] ?? '0.00'; ?>">
                        </div>

                        <!-- Deductions Section -->
                        <div class="col-12 mt-4">
                            <h4 class="h6">Deductions</h4>
                            <hr class="mt-1">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Provident Fund (PF)</label>
                            <input type="number" step="0.01" name="pf_deduction" class="form-control" value="<?php echo $salary['pf_deduction'] ?? '0.00'; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Professional Tax</label>
                            <input type="number" step="0.01" name="tax_deduction" class="form-control" value="<?php echo $salary['tax_deduction'] ?? '0.00'; ?>">
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end">
                        <a href="/payroll" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Structure</button>
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
