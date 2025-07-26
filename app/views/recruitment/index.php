<?php 
$title = "Recruitment";
ob_start(); 
?>
<div class="d-flex justify-content-end mb-3">
    <a href="/recruitment/create" class="btn btn-primary">
        Create Job Opening
    </a>
</div>
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="h5 mb-0">Job Openings</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Title</th>
                        <th scope="col">Department</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($jobs)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No job openings have been created yet.</td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach($jobs as $job): ?>
                    <tr>
                        <td class="ps-4"><?php echo htmlspecialchars($job['title']); ?></td>
                        <td><?php echo htmlspecialchars($job['department']); ?></td>
                        <td>
                            <span class="badge <?php echo $job['status'] == 'open' ? 'bg-success-subtle text-success-emphasis' : 'bg-secondary-subtle text-secondary-emphasis'; ?>">
                                <?php echo ucfirst($job['status']); ?>
                            </span>
                        </td>
                        <td>
                            <a href="/recruitment/pipeline/<?php echo $job['id']; ?>" class="btn btn-sm btn-outline-primary">View Pipeline</a>
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
