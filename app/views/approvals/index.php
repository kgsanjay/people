<?php 
$title = "My Approvals";
ob_start(); 
?>
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="h5 mb-0">Pending Requests</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Employee</th>
                        <th scope="col">Request Details</th>
                        <th scope="col">Approval Step</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($requests)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">You have no pending approval requests.</td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach($requests as $req): ?>
                    <tr>
                        <td class="ps-4"><?php echo htmlspecialchars($req['first_name'] . ' ' . $req['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($req['subject']); ?></td>
                        <td><?php echo htmlspecialchars($req['step_name']); ?></td>
                        <td>
                            <?php $processUrl = "/" . $req['request_type'] . "/processApproval/" . $req['id']; ?>
                            <a href="<?php echo $processUrl; ?>/approved" class="btn btn-sm btn-outline-success">Approve</a>
                            <a href="<?php echo $processUrl; ?>/rejected" class="btn btn-sm btn-outline-danger">Reject</a>
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
