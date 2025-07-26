<?php 
$title = "Manage Enrollments";
ob_start(); 
?>
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="h5 mb-0">Course Enrollment Requests</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Employee</th>
                        <th scope="col">Course</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($enrollments as $item): ?>
                    <tr>
                        <td class="ps-4"><?php echo htmlspecialchars($item['first_name'] . ' ' . $item['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($item['training_title']); ?></td>
                        <td>
                            <span class="badge <?php 
                                if ($item['status'] == 'pending') echo 'bg-warning-subtle text-warning-emphasis';
                                elseif ($item['status'] == 'approved') echo 'bg-primary-subtle text-primary-emphasis';
                                elseif ($item['status'] == 'completed') echo 'bg-success-subtle text-success-emphasis';
                                else echo 'bg-danger-subtle text-danger-emphasis';
                            ?>"><?php echo ucfirst($item['status']); ?></span>
                        </td>
                        <td class="text-nowrap">
                            <?php if($item['status'] == 'pending'): ?>
                                <a href="/course/updateEnrollment/<?php echo $item['id']; ?>/approved" class="btn btn-sm btn-outline-success">Approve</a>
                                <a href="/course/updateEnrollment/<?php echo $item['id']; ?>/rejected" class="btn btn-sm btn-outline-danger">Reject</a>
                            <?php elseif($item['status'] == 'approved'): ?>
                                <a href="/course/updateEnrollment/<?php echo $item['id']; ?>/completed" class="btn btn-sm btn-outline-primary">Mark as Completed</a>
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
