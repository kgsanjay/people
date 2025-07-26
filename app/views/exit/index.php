<?php 
$title = "Manage Employee Exits";
ob_start(); 
?>
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="h5 mb-0">Employee Exit Processes</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Employee</th>
                        <th scope="col">Resignation Date</th>
                        <th scope="col">Last Working Day</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($exits)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No exit processes have been initiated.</td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach($exits as $exit): ?>
                    <tr>
                        <td class="ps-4"><?php echo htmlspecialchars($exit['first_name'] . ' ' . $exit['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($exit['resignation_date']); ?></td>
                        <td><?php echo htmlspecialchars($exit['last_working_day']); ?></td>
                        <td>
                            <span class="badge <?php echo $exit['status'] == 'completed' ? 'bg-success-subtle text-success-emphasis' : 'bg-warning-subtle text-warning-emphasis'; ?>">
                                <?php echo ucfirst(str_replace('_', ' ', $exit['status'])); ?>
                            </span>
                        </td>
                        <td>
                            <?php if($exit['status'] == 'in_progress'): ?>
                                <a href="/exit/complete/<?php echo $exit['id']; ?>" class="btn btn-sm btn-outline-success" onclick="return confirm('This will deactivate the employee account and complete the exit process. Are you sure?')">Mark as Completed</a>
                            <?php else: ?>
                                <span class="text-muted">Completed</span>
                            <?php endif; ?>
                        </td>
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
