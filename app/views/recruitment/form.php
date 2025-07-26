<?php 
$title = "Create Job Opening";
ob_start(); 
?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="h5 mb-0"><?php echo $title; ?></h3>
            </div>
            <div class="card-body">
                <form action="/recruitment/store" method="POST">
                    <div class="mb-3">
                        <label for="title" class="form-label">Job Title</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="department" class="form-label">Department</label>
                        <input type="text" name="department" id="department" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="open">Open</option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" rows="8" class="form-control" required></textarea>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="/recruitment" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Job</button>
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
