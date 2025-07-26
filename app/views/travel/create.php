<?php 
$title = "Submit New Travel Request";
ob_start(); 
?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="h5 mb-0"><?php echo $title; ?></h3>
            </div>
            <div class="card-body">
                <form action="/travel/store" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label for="destination" class="form-label">Destination</label>
                            <input type="text" name="destination" id="destination" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label for="estimated_cost" class="form-label">Estimated Cost (₹)</label>
                            <input type="number" step="0.01" name="estimated_cost" id="estimated_cost" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label for="purpose" class="form-label">Purpose of Travel</label>
                            <textarea name="purpose" id="purpose" rows="4" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <a href="/travel/myTravel" class="btn btn-secondary me-2">Cancel</a>
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
