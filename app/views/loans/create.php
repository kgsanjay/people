<?php 
$title = "Request a Loan";
ob_start(); 
?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="h5 mb-0"><?php echo $title; ?></h3>
            </div>
            <div class="card-body">
                <form action="/loan/store" method="POST">
                    <div class="mb-3">
                        <label for="amount" class="form-label">Loan Amount (₹)</label>
                        <input type="number" step="0.01" name="amount" id="amount" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason for Loan</label>
                        <textarea name="reason" id="reason" rows="4" class="form-control" required></textarea>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="/loan/myLoans" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Submit Request</button>
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
