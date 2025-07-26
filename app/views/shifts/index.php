<?php 
$title = "Shift Management";
ob_start(); 
?>
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="h5 mb-0">Shift Types</h3>
                <a href="/shift/create" class="btn btn-primary btn-sm">Add Shift</a>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <?php foreach($shifts as $shift): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-semibold"><?php echo htmlspecialchars($shift['name']); ?></div>
                            <small class="text-muted"><?php echo date('g:i A', strtotime($shift['start_time'])); ?> - <?php echo date('g:i A', strtotime($shift['end_time'])); ?></small>
                        </div>
                        <div>
                            <a href="/shift/edit/<?php echo $shift['id']; ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                            <a href="/shift/delete/<?php echo $shift['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</a>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="h5 mb-0">Employee Shift Roster</h3>
                <a href="/shift/assign" class="btn btn-success btn-sm">Assign Shift</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="ps-4">Employee</th>
                                <th scope="col">Shift Name</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($assignments as $assignment): ?>
                            <tr>
                                <td class="ps-4"><?php echo htmlspecialchars($assignment['first_name'] . ' ' . $assignment['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($assignment['shift_name']); ?></td>
                                <td><?php echo htmlspecialchars($assignment['start_date']); ?></td>
                                <td><?php echo htmlspecialchars($assignment['end_date']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
