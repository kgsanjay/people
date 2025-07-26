<?php 
$title = "View Payslip";
ob_start(); 
?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header text-center">
                <h2 class="h4 mb-0">Payslip for <?php echo date("F Y", mktime(0, 0, 0, $payslip['month'], 1, $payslip['year'])); ?></h2>
            </div>
            <div class="card-body p-4">
                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <div class="card bg-success-subtle border-0">
                            <div class="card-body text-center">
                                <h6 class="card-subtitle mb-2 text-success-emphasis">Total Earnings</h6>
                                <p class="card-text h4 fw-bold text-success-emphasis">₹<?php echo number_format($payslip['gross_earnings'], 2); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card bg-danger-subtle border-0">
                            <div class="card-body text-center">
                                <h6 class="card-subtitle mb-2 text-danger-emphasis">Total Deductions</h6>
                                <p class="card-text h4 fw-bold text-danger-emphasis">₹<?php echo number_format($payslip['total_deductions'], 2); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <h4 class="h6">Earnings</h4>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between"><span>Basic Salary</span> <span>₹<?php echo number_format($payslip['basic_salary'], 2); ?></span></li>
                            <li class="list-group-item d-flex justify-content-between"><span>HRA</span> <span>₹<?php echo number_format($payslip['hra'], 2); ?></span></li>
                            <li class="list-group-item d-flex justify-content-between"><span>Travel Allowance</span> <span>₹<?php echo number_format($payslip['travel_allowance'], 2); ?></span></li>
                            <li class="list-group-item d-flex justify-content-between"><span>Medical Allowance</span> <span>₹<?php echo number_format($payslip['medical_allowance'], 2); ?></span></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h4 class="h6">Deductions</h4>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between"><span>Provident Fund</span> <span>₹<?php echo number_format($payslip['pf_deduction'], 2); ?></span></li>
                            <li class="list-group-item d-flex justify-content-between"><span>Professional Tax</span> <span>₹<?php echo number_format($payslip['tax_deduction'], 2); ?></span></li>
                        </ul>
                    </div>
                </div>
                
                <div class="mt-4 card bg-primary-subtle border-0">
                    <div class="card-body text-center">
                        <h3 class="h5 text-primary-emphasis">Net Salary</h3>
                        <p class="display-6 fw-bold text-primary-emphasis">₹<?php echo number_format($payslip['net_pay'], 2); ?></p>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="/payroll/myPayslip" class="btn btn-sm btn-outline-secondary">Back to Payslip List</a>
            </div>
        </div>
    </div>
</div>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
