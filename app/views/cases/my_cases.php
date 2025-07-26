<?php 
$title = "My Cases";
ob_start(); 
?>
<div class="d-flex justify-content-end mb-3">
    <a href="/cases/create" class="btn btn-success">
        Submit New Case
    </a>
</div>
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="h5 mb-0">My Submitted Cases</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Date Submitted</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Status</th>
                        <th scope="col">Assigned To</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($cases)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">You have not submitted any cases.</td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach($cases as $case): ?>
                    <tr>
                        <td class="ps-4"><?php echo date('M j, Y', strtotime($case['created_at'])); ?></td>
                        <td><?php echo htmlspecialchars($case['subject']); ?></td>
                        <td>
                            <span class="badge <?php 
                                if ($case['status'] == 'open') echo 'bg-primary-subtle text-primary-emphasis';
                                elseif ($case['status'] == 'in_progress') echo 'bg-warning-subtle text-warning-emphasis';
                                else echo 'bg-success-subtle text-success-emphasis';
                            ?>"><?php echo ucfirst(str_replace('_', ' ', $case['status'])); ?></span>
                        </td>
                        <td>
                            <?php echo $case['assigned_to'] ? htmlspecialchars($case['assigned_first_name'] . ' ' . $case['assigned_last_name']) : 'Unassigned'; ?>
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
