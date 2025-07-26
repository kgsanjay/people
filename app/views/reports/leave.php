<?php 
$title = "Leave Report";
ob_start(); 
?>
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="h5 mb-0">Generate Leave Report</h3>
    </div>
    <div class="card-body">
        <form method="GET" action="/report/leave" class="row g-3 align-items-end bg-light p-3 rounded mb-4">
            <div class="col-md-4">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="<?php echo $_GET['start_date'] ?? ''; ?>" required>
            </div>
            <div class="col-md-4">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="<?php echo $_GET['end_date'] ?? ''; ?>" required>
            </div>
            <div class="col-md-2">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="all" <?php echo ($_GET['status'] ?? '') == 'all' ? 'selected' : ''; ?>>All</option>
                    <option value="pending" <?php echo ($_GET['status'] ?? '') == 'pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="approved" <?php echo ($_GET['status'] ?? '') == 'approved' ? 'selected' : ''; ?>>Approved</option>
                    <option value="rejected" <?php echo ($_GET['status'] ?? '') == 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Generate</button>
            </div>
        </form>

        <?php if(!empty($results)): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Employee</th>
                        <th scope="col">Leave Type</th>
                        <th scope="col">Dates</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($results as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['leave_type_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['start_date']); ?> to <?php echo htmlspecialchars($row['end_date']); ?></td>
                        <td><?php echo ucfirst($row['status']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
