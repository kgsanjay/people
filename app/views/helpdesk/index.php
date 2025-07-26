<?php 
$title = "Help Desk Tickets";
ob_start(); 
?>
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="h5 mb-0">All Submitted Tickets</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Employee</th>
                        <th scope="col">Subject & Department</th>
                        <th scope="col">Priority</th>
                        <th scope="col">Status & Assignment</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($tickets as $ticket): ?>
                    <tr>
                        <td class="ps-4"><?php echo htmlspecialchars($ticket['first_name'] . ' ' . $ticket['last_name']); ?></td>
                        <td>
                            <div class="fw-semibold"><?php echo htmlspecialchars($ticket['subject']); ?></div>
                            <div class="small text-muted"><?php echo htmlspecialchars($ticket['department_name']); ?></div>
                        </td>
                        <td>
                            <span class="fw-semibold <?php 
                                if ($ticket['priority'] == 'high') echo 'text-danger';
                                elseif ($ticket['priority'] == 'medium') echo 'text-warning';
                                else echo 'text-success';
                            ?>"><?php echo ucfirst($ticket['priority']); ?></span>
                        </td>
                        <td>
                            <form action="/helpdesk/update" method="POST" class="d-flex align-items-center gap-2">
                                <input type="hidden" name="ticket_id" value="<?php echo $ticket['id']; ?>">
                                <select name="status" class="form-select form-select-sm" style="width: 120px;">
                                    <option value="open" <?php echo $ticket['status'] == 'open' ? 'selected' : ''; ?>>Open</option>
                                    <option value="in_progress" <?php echo $ticket['status'] == 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                                    <option value="resolved" <?php echo $ticket['status'] == 'resolved' ? 'selected' : ''; ?>>Resolved</option>
                                    <option value="closed" <?php echo $ticket['status'] == 'closed' ? 'selected' : ''; ?>>Closed</option>
                                </select>
                                <select name="assigned_to" class="form-select form-select-sm" style="width: 120px;">
                                    <option value="">Unassigned</option>
                                    <?php foreach($admins as $admin): ?>
                                    <option value="<?php echo $admin['id']; ?>" <?php echo $ticket['assigned_to'] == $admin['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($admin['first_name']); ?></option>
                                    <?php endforeach; ?>
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
