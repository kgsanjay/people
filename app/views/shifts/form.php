<?php 
$is_edit = ($action === 'edit');
$title = $is_edit ? "Edit Shift Type" : "Create Shift Type";
ob_start(); 
?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="h5 mb-0"><?php echo $title; ?></h3>
            </div>
            <div class="card-body">
                <form action="<?php echo $is_edit ? '/shift/update/' . $shift['id'] : '/shift/store'; ?>" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Shift Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?php echo $is_edit ? htmlspecialchars($shift['name']) : ''; ?>" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="start_time" class="form-label">Start Time</label>
                            <input type="time" name="start_time" id="start_time" class="form-control" value="<?php echo $is_edit ? htmlspecialchars($shift['start_time']) : ''; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="end_time" class="form-label">End Time</label>
                            <input type="time" name="end_time" id="end_time" class="form-control" value="<?php echo $is_edit ? htmlspecialchars($shift['end_time']) : ''; ?>" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <a href="/shift" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary"><?php echo $is_edit ? 'Update Shift' : 'Create Shift'; ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
