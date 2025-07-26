<?php 
$title = "Submit New Expense Claim";
ob_start(); 
?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="h5 mb-0"><?php echo $title; ?></h3>
            </div>
            <div class="card-body">
                <form action="/expenses/store" method="POST" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="expense_date" class="form-label">Expense Date</label>
                            <input type="date" name="expense_date" id="expense_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="category" class="form-label">Category</label>
                            <select name="category" id="category" class="form-select" required>
                                <option value="Travel">Travel</option>
                                <option value="Food">Food</option>
                                <option value="Accommodation">Accommodation</option>
                                <option value="Office Supplies">Office Supplies</option>
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
                        <a href="/expenses/myExpenses" class="btn btn-secondary me-2">Cancel</a>
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
