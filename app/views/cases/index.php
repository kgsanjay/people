<?php 
$title = "Manage Cases";
ob_start(); 
?>
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="h5 mb-0">All Submitted Cases</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Employee</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Category</th>
                        <th scope="col">Status & Assignment</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($cases as $case): ?>
                    <tr>
                        <td class="ps-4"><?php echo htmlspecialchars($case['first_name'] . ' ' . $case['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($case['subject']); ?></td>
                        <td><?php echo htmlspecialchars($case['category']); ?></td>
                        <td>
                            <form action="/cases/update" method="POST" class="d-flex align-items-center gap-2">
                                <input type="hidden" name="case_id" value="<?php echo $case['id']; ?>">
                                <select name="status" class="form-select form-select-sm" style="width: 120px;">
                                    <option value="open" <?php echo $case['status'] == 'open' ? 'selected' : ''; ?>>Open</option>
                                    <option value="in_progress" <?php echo $case['status'] == 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                                    <option value="resolved" <?php echo $case['status'] == 'resolved' ? 'selected' : ''; ?>>Resolved</option>
                                </select>
                                <select name="assigned_to" class="form-select form-select-sm" style="width: 120px;">
                                    <option value="">Unassigned</option>
                                    <?php foreach($admins as $admin): ?>
                                    <option value="<?php echo $admin['id']; ?>" <?php echo $case['assigned_to'] == $admin['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($admin['first_name']); ?></option>
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
