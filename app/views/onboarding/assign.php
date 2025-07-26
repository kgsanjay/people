<?php 
$title = "Assign Checklist";
ob_start(); 
?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="h5 mb-0"><?php echo $title; ?></h3>
            </div>
            <div class="card-body">
                <form action="/onboarding/storeAssignment" method="POST">
                    <div class="mb-3">
                        <label for="employee_id" class="form-label">Employee</label>
                        <select name="employee_id" id="employee_id" class="form-select" required>
                            <option value="">-- Select Employee --</option>
                            <?php foreach($employees as $employee): ?>
                            <option value="<?php echo $employee['id']; ?>"><?php echo htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="checklist_id" class="form-label">Checklist Template</label>
                        <select name="checklist_id" id="checklist_id" class="form-select" required>
                            <option value="">-- Select Template --</option>
                            <?php foreach($checklists as $checklist): ?>
                            <option value="<?php echo $checklist['id']; ?>"><?php echo htmlspecialchars($checklist['name']); ?> (<?php echo ucfirst($checklist['type']); ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="/onboarding" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">Assign Checklist</button>
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
