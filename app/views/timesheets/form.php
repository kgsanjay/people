<?php 
$title = "Log Time";
ob_start(); 
?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="h5 mb-0"><?php echo $title; ?></h3>
            </div>
            <div class="card-body">
                <form action="/timesheet/store" method="POST">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="project_id" class="form-label">Project</label>
                            <select name="project_id" id="project_id" class="form-select" required>
                                <option value="">-- Select a Project --</option>
                                <?php foreach ($projects as $project): ?>
                                    <?php if ($project['status'] === 'active'): ?>
                                    <option value="<?php echo $project['id']; ?>"><?php echo htmlspecialchars($project['name']); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="work_date" class="form-label">Work Date</label>
                            <input type="date" name="work_date" id="work_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="hours" class="form-label">Hours</label>
                            <input type="number" name="hours" id="hours" step="0.01" min="0" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label">Description / Work Done</label>
                            <textarea name="description" id="description" rows="4" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <a href="/timesheet" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Entry</button>
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
