<?php 
$title = "Attendance Report";
ob_start(); 
?>
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="h5 mb-0">Generate Attendance Report</h3>
    </div>
    <div class="card-body">
        <form method="GET" action="/report/attendance" class="row g-3 align-items-end bg-light p-3 rounded">
            <div class="col-md-4">
                <label for="employee_id" class="form-label">Employee</label>
                <select name="employee_id" id="employee_id" class="form-select" required>
                    <option value="">Select Employee</option>
                    <?php foreach($employees as $employee): ?>
                    <option value="<?php echo $employee['id']; ?>" <?php echo ($_GET['employee_id'] ?? '') == $employee['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="<?php echo $_GET['start_date'] ?? ''; ?>" required>
            </div>
            <div class="col-md-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="<?php echo $_GET['end_date'] ?? ''; ?>" required>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Generate</button>
            </div>
        </form>

        <?php if(!empty($results)): ?>
        <div class="mt-4 table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Clock In</th>
                        <th scope="col">Clock Out</th>
                        <th scope="col">Total Hours</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($results as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['work_date']); ?></td>
                        <td><?php echo date('h:i A', strtotime($row['clock_in'])); ?></td>
                        <td><?php echo $row['clock_out'] ? date('h:i A', strtotime($row['clock_out'])) : 'N/A'; ?></td>
                        <td>
                            <?php 
                                if ($row['clock_out']) {
                                    $in = new DateTime($row['clock_in']);
                                    $out = new DateTime($row['clock_out']);
                                    echo $in->diff($out)->format('%h h %i m');
                                } else {
                                    echo 'N/A';
                                }
                            ?>
                        </td>
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
