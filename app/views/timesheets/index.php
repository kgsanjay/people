<?php 
$title = "My Timesheets";
ob_start(); 
?>
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="h5 mb-0">My Time Entries</h3>
                <a href="/timesheet/create" class="btn btn-primary btn-sm">Log Time</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="ps-4">Date</th>
                                <th scope="col">Project</th>
                                <th scope="col">Hours</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($timesheets as $timesheet): ?>
                            <tr>
                                <td class="ps-4"><?php echo htmlspecialchars($timesheet['work_date']); ?></td>
                                <td><?php echo htmlspecialchars($timesheet['project_name']); ?></td>
                                <td><?php echo htmlspecialchars(number_format($timesheet['hours'], 2)); ?></td>
                                <td>
                                    <span class="badge <?php 
                                        if ($timesheet['submission_status'] == 'approved') echo 'bg-success-subtle text-success-emphasis';
                                        elseif ($timesheet['submission_status'] == 'rejected') echo 'bg-danger-subtle text-danger-emphasis';
                                        elseif (str_contains($timesheet['submission_status'], 'pending')) echo 'bg-warning-subtle text-warning-emphasis';
                                        else echo 'bg-secondary-subtle text-secondary-emphasis';
                                    ?>"><?php echo $timesheet['submission_status'] ? ucfirst($timesheet['submission_status']) : 'Not Submitted'; ?></span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="h5 mb-0">Submit Timesheet</h3>
            </div>
            <div class="card-body">
                <?php if(empty($unsubmitted)): ?>
                    <p class="text-muted">You have no unsubmitted time entries.</p>
                <?php else: 
                    $total_hours = array_sum(array_column($unsubmitted, 'hours'));
                    $start_date = min(array_column($unsubmitted, 'work_date'));
                    $end_date = max(array_column($unsubmitted, 'work_date'));
                ?>
                    <p class="mb-2">You have <strong><?php echo count($unsubmitted); ?></strong> unsubmitted entries totaling <strong><?php echo $total_hours; ?></strong> hours.</p>
                    <p class="small text-muted mb-3">For period: <?php echo $start_date; ?> to <?php echo $end_date; ?></p>
                    <form action="/timesheet/submit" method="POST">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">
                                Submit for Approval
                            </button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
