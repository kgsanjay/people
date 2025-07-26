<?php 
$title = "Manage Assets";
ob_start(); 
?>

<div class="d-flex justify-content-end mb-3">
    <a href="/asset/create" class="btn btn-primary">
        Add New Asset
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Asset Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Serial No.</th>
                        <th scope="col">Assigned To</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($assets as $asset): ?>
                    <tr>
                        <td class="ps-4"><?php echo htmlspecialchars($asset['name']); ?></td>
                        <td><?php echo htmlspecialchars($asset['category']); ?></td>
                        <td><?php echo htmlspecialchars($asset['serial_number']); ?></td>
                        <td>
                            <?php echo $asset['assigned_to_id'] ? htmlspecialchars($asset['first_name'] . ' ' . $asset['last_name']) : '<span class="text-muted">Unassigned</span>'; ?>
                        </td>
                        <td>
                             <span class="badge <?php 
                                if ($asset['status'] == 'assigned') echo 'bg-success-subtle text-success-emphasis';
                                elseif ($asset['status'] == 'in_storage') echo 'bg-primary-subtle text-primary-emphasis';
                                else echo 'bg-warning-subtle text-warning-emphasis';
                             ?>"><?php echo ucfirst(str_replace('_', ' ', htmlspecialchars($asset['status']))); ?></span>
                        </td>
                        <td>
                            <a href="/asset/edit/<?php echo $asset['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                            <a href="/asset/delete/<?php echo $asset['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</a>
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
