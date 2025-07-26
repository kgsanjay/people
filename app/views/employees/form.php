<?php 
$is_edit = ($action === 'edit');
$title = $is_edit ? "Edit Employee" : "Create Employee";
ob_start(); 
?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="h5 mb-0"><?php echo $title; ?></h3>
            </div>
            <div class="card-body">
                <form action="<?php echo $is_edit ? '/employees/update/' . $employee['id'] : '/employees/store'; ?>" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $is_edit ? htmlspecialchars($employee['first_name']) : ''; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" name="last_name" id="last_name" class="form-control" value="<?php echo $is_edit ? htmlspecialchars($employee['last_name']) : ''; ?>" required>
                        </div>
                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="<?php echo $is_edit ? htmlspecialchars($employee['email']) : ''; ?>" required>
                        </div>
                        <?php if (!$is_edit): ?>
                        <div class="col-12">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <?php endif; ?>
                        <div class="col-md-6">
                            <label for="job_title" class="form-label">Job Title</label>
                            <input type="text" name="job_title" id="job_title" class="form-control" value="<?php echo $is_edit ? htmlspecialchars($employee['job_title']) : ''; ?>" required>
                        </div>
                         <div class="col-md-6">
                            <label for="department" class="form-label">Department</label>
                            <input type="text" name="department" id="department" class="form-control" value="<?php echo $is_edit ? htmlspecialchars($employee['department']) : ''; ?>" required>
                        </div>
                         <div class="col-md-6">
                            <label for="hire_date" class="form-label">Hire Date</label>
                            <input type="date" name="hire_date" id="hire_date" class="form-control" value="<?php echo $is_edit ? htmlspecialchars($employee['hire_date']) : ''; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="role" class="form-select">
                                <option value="employee" <?php echo ($is_edit && $employee['role'] == 'employee') ? 'selected' : ''; ?>>Employee</option>
                                <option value="manager" <?php echo ($is_edit && $employee['role'] == 'manager') ? 'selected' : ''; ?>>Manager</option>
                                <option value="admin" <?php echo ($is_edit && $employee['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="reports_to" class="form-label">Reports To (Manager)</label>
                            <select name="reports_to" id="reports_to" class="form-select">
                                <option value="">-- No Manager (Top Level) --</option>
                                <?php foreach($employees as $manager): ?>
                                    <?php if($is_edit && $manager['id'] == $employee['id']) continue; // Can't report to self ?>
                                    <option value="<?php echo $manager['id']; ?>" <?php echo ($is_edit && $employee['reports_to'] == $manager['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($manager['first_name'] . ' ' . $manager['last_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4 d-flex justify-content-end">
                        <a href="/employees" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary"><?php echo $is_edit ? 'Update Employee' : 'Create Employee'; ?></button>
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
