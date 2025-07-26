<?php 
$title = "My Shift Schedule";
ob_start(); 
?>
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="h5 mb-0">My Upcoming Shifts</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Shift Name</th>
                        <th scope="col">Shift Times</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">End Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($schedule)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">You do not have any shifts scheduled.</td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach ($schedule as $assignment): ?>
                    <tr>
                        <td class="ps-4"><?php echo htmlspecialchars($assignment['shift_name']); ?></td>
                        <td><?php echo date('g:i A', strtotime($assignment['start_time'])); ?> - <?php echo date('g:i A', strtotime($assignment['end_time'])); ?></td>
                        <td><?php echo htmlspecialchars($assignment['start_date']); ?></td>
                        <td><?php echo htmlspecialchars($assignment['end_date']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
