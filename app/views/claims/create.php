<?php 
$title = "Submit New Claim";
ob_start(); 
?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="h5 mb-0"><?php echo $title; ?></h3>
            </div>
            <div class="card-body">
                <form action="/claims/store" method="POST" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="claim_date" class="form-label">Claim Date</label>
                            <input type="date" name="claim_date" id="claim_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="category" class="form-label">Category</label>
                            <select name="category" id="category" class="form-select" required>
                                <option value="Mobile Bill">Mobile Bill</option>
                                <option value="Internet Bill">Internet Bill</option>
                                <option value="Fuel">Fuel</option>
                                <option value="Team Lunch">Team Lunch</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="amount" class="form-label">Amount (₹)</label>
                            <input type="number" step="0.01" name="amount" id="amount" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" rows="4" class="form-control" required></textarea>
                        </div>
                        <div class="col-12">
                            <label for="receipt" class="form-label">Upload Receipt (Optional)</label>
                            <input type="file" name="receipt" id="receipt" class="form-control">
                        </div>
                    </div>
                    <div class="mt-4 d-flex justify-content-end">
                        <a href="/claims/myClaims" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Submit Claim</button>
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
