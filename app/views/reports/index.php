<?php 
$title = "Reports & Analytics";
ob_start(); 
?>
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    <div class="col">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Headcount Report</h5>
                <p class="card-text">View a breakdown of employees by department.</p>
                <a href="/report/headcount" class="btn btn-primary">View Report</a>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Leave Report</h5>
                <p class="card-text">Analyze leave data by date range and status.</p>
                <a href="/report/leave" class="btn btn-primary">View Report</a>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Attendance Report</h5>
                <p class="card-text">Generate detailed attendance logs for employees.</p>
                <a href="/report/attendance" class="btn btn-primary">View Report</a>
            </div>
        </div>
    </div>
</div>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
