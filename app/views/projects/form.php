<?php 
$is_edit = ($action === 'edit');
$title = $is_edit ? "Edit Project" : "Create Project";
ob_start(); 
?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="h5 mb-0"><?php echo $title; ?></h3>
            </div>
            <div class="card-body">
                <form action="<?php echo $is_edit ? '/projects/update/' . $project['id'] : '/projects/store'; ?>" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Project Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?php echo $is_edit ? htmlspecialchars($project['name']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="client" class="form-label">Client Name</label>
                        <input type="text" name="client" id="client" class="form-control" value="<?php echo $is_edit ? htmlspecialchars($project['client']) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="active" <?php echo ($is_edit && $project['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo ($is_edit && $project['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                            <option value="completed" <?php echo ($is_edit && $project['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="/projects" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary"><?php echo $is_edit ? 'Update Project' : 'Create Project'; ?></button>
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
