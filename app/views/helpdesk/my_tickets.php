<?php 
$title = "My Tickets";
ob_start(); 
?>
<div class="d-flex justify-content-end mb-3">
    <a href="/helpdesk/create" class="btn btn-success">
        Create New Ticket
    </a>
</div>
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="h5 mb-0">My Submitted Tickets</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Date Submitted</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Department</th>
                        <th scope="col">Status</th>
                        <th scope="col">Assigned To</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($tickets)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">You have not submitted any tickets.</td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach($tickets as $ticket): ?>
                    <tr>
                        <td class="ps-4"><?php echo date('M j, Y', strtotime($ticket['created_at'])); ?></td>
                        <td><?php echo htmlspecialchars($ticket['subject']); ?></td>
                        <td><?php echo htmlspecialchars($ticket['department_name']); ?></td>
                        <td>
                            <span class="badge <?php 
                                if ($ticket['status'] == 'open') echo 'bg-primary-subtle text-primary-emphasis';
                                elseif ($ticket['status'] == 'in_progress') echo 'bg-warning-subtle text-warning-emphasis';
                                elseif ($ticket['status'] == 'resolved') echo 'bg-success-subtle text-success-emphasis';
                                else echo 'bg-secondary-subtle text-secondary-emphasis';
                            ?>"><?php echo ucfirst(str_replace('_', ' ', $ticket['status'])); ?></span>
                        </td>
                        <td>
                            <?php echo $ticket['assigned_to'] ? htmlspecialchars($ticket['assigned_first_name'] . ' ' . $ticket['assigned_last_name']) : 'Unassigned'; ?>
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
