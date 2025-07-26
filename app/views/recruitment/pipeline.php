<?php 
$title = "Applicant Pipeline: " . htmlspecialchars($job['title']);
ob_start(); 
?>
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="h5 mb-0"><?php echo $title; ?></h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Candidate</th>
                        <th scope="col">Contact</th>
                        <th scope="col">Resume</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($applications)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No applications received for this job yet.</td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach($applications as $app): ?>
                    <tr>
                        <td class="ps-4"><?php echo htmlspecialchars($app['name']); ?></td>
                        <td><?php echo htmlspecialchars($app['email']); ?></td>
                        <td>
                            <a href="/public/uploads/<?php echo htmlspecialchars($app['resume_filename']); ?>" target="_blank" class="btn btn-sm btn-outline-secondary">View Resume</a>
                        </td>
                        <td>
                            <form action="/recruitment/updateStatus" method="POST" class="d-flex align-items-center gap-2">
                                <input type="hidden" name="application_id" value="<?php echo $app['id']; ?>">
                                <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                                <select name="status" class="form-select form-select-sm" style="width: 140px;">
                                    <option value="applied" <?php echo $app['status'] == 'applied' ? 'selected' : ''; ?>>Applied</option>
                                    <option value="shortlisted" <?php echo $app['status'] == 'shortlisted' ? 'selected' : ''; ?>>Shortlisted</option>
                                    <option value="interview" <?php echo $app['status'] == 'interview' ? 'selected' : ''; ?>>Interview</option>
                                    <option value="hired" <?php echo $app['status'] == 'hired' ? 'selected' : ''; ?>>Hired</option>
                                    <option value="rejected" <?php echo $app['status'] == 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            </form>
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
