<?php 
$is_edit = ($action === 'edit');
$title = $is_edit ? "Edit Asset" : "Create Asset";
ob_start(); 
?>

<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="h5 mb-0"><?php echo $title; ?></h3>
    </div>
    <div class="card-body">
        <form action="<?php echo $is_edit ? '/asset/update/' . $asset['id'] : '/asset/store'; ?>" method="POST">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Asset Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?php echo $is_edit ? htmlspecialchars($asset['name']) : ''; ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="category" class="form-label">Category</label>
                    <input type="text" name="category" id="category" placeholder="e.g., Laptop, Phone" class="form-control" value="<?php echo $is_edit ? htmlspecialchars($asset['category']) : ''; ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="serial_number" class="form-label">Serial Number</label>
                    <input type="text" name="serial_number" id="serial_number" class="form-control" value="<?php echo $is_edit ? htmlspecialchars($asset['serial_number']) : ''; ?>">
                </div>
                <div class="col-md-6">
                    <label for="purchase_date" class="form-label">Purchase Date</label>
                    <input type="date" name="purchase_date" id="purchase_date" class="form-control" value="<?php echo $is_edit ? htmlspecialchars($asset['purchase_date']) : ''; ?>" required>
                </div>
                <div class="col-12">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="in_storage" <?php echo ($is_edit && $asset['status'] == 'in_storage') ? 'selected' : ''; ?>>In Storage</option>
                        <option value="assigned" <?php echo ($is_edit && $asset['status'] == 'assigned') ? 'selected' : ''; ?>>Assigned</option>
                        <option value="in_repair" <?php echo ($is_edit && $asset['status'] == 'in_repair') ? 'selected' : ''; ?>>In Repair</option>
                        <option value="disposed" <?php echo ($is_edit && $asset['status'] == 'disposed') ? 'selected' : ''; ?>>Disposed</option>
                    </select>
                </div>
                <div class="col-12">
                    <label for="assigned_to_id" class="form-label">Assigned To</label>
                    <select name="assigned_to_id" id="assigned_to_id" class="form-select">
                        <option value="">-- Unassigned --</option>
                        <?php foreach($employees as $employee): ?>
                        <option value="<?php echo $employee['id']; ?>" <?php echo ($is_edit && $asset['assigned_to_id'] == $employee['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="mt-4 d-flex justify-content-end">
                <a href="/asset" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary"><?php echo $is_edit ? 'Update Asset' : 'Create Asset'; ?></button>
            </div>
        </form>
    </div>
</div>

<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
