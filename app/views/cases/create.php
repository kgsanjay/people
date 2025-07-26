<?php 
$title = "Submit a New Case";
ob_start(); 
?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="h5 mb-0"><?php echo $title; ?></h3>
            </div>
            <div class="card-body">
                <form action="/cases/store" method="POST">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="category" class="form-label">Category</label>
                            <select name="category" id="category" class="form-select" required>
                                <option value="Payroll Query">Payroll Query</option>
                                <option value="Leave Policy">Leave Policy</option>
                                <option value="IT Support">IT Support</option>
                                <option value="Grievance">Grievance</option>
                                <option value="General Question">General Question</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" rows="6" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="mt-4 d-flex justify-content-end">
                        <a href="/cases/myCases" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Submit Case</button>
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
