<?php 
$title = "Manage Projects";
ob_start(); 
?>
<div class="d-flex justify-content-end mb-3">
    <a href="/projects/create" class="btn btn-primary">
        Add New Project
    </a>
</div>
<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Project Name</th>
                        <th scope="col">Client</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($projects)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No projects have been created yet.</td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach ($projects as $project): ?>
                    <tr>
                        <td class="ps-4"><?php echo htmlspecialchars($project['name']); ?></td>
                        <td><?php echo htmlspecialchars($project['client']); ?></td>
                        <td>
                            <span class="badge <?php 
                                if ($project['status'] == 'active') echo 'bg-success-subtle text-success-emphasis';
                                elseif ($project['status'] == 'inactive') echo 'bg-warning-subtle text-warning-emphasis';
                                else echo 'bg-secondary-subtle text-secondary-emphasis';
                            ?>"><?php echo ucfirst(htmlspecialchars($project['status'])); ?></span>
                        </td>
                        <td>
                            <a href="/projects/edit/<?php echo $project['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                            <a href="/projects/delete/<?php echo $project['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</a>
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
