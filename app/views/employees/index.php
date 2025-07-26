<?php 
$title = "Manage Employees";
ob_start(); 
?>
<div class="d-flex justify-content-end mb-3">
    <a href="/employees/create" class="btn btn-primary">
        Add New Employee
    </a>
</div>
<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Name</th>
                        <th scope="col">Job Title</th>
                        <th scope="col">Department</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($employees as $employee): ?>
                    <tr>
                        <td class="ps-4"><?php echo htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($employee['job_title']); ?></td>
                        <td><?php echo htmlspecialchars($employee['department']); ?></td>
                        <td>
                            <a href="/employees/profile/<?php echo $employee['id']; ?>" class="btn btn-sm btn-outline-primary">View Profile</a>
                            <a href="/employees/delete/<?php echo $employee['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</a>
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
