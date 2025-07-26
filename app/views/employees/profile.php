<?php 
$title = "Employee Profile";
ob_start(); 
?>
<div class="card shadow-sm">
    <div class="card-header bg-light p-4 d-flex justify-content-between align-items-center">
        <div>
            <h2 class="h4 mb-0"><?php echo htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']); ?></h2>
            <p class="text-muted mb-0"><?php echo htmlspecialchars($employee['job_title']); ?> - <?php echo htmlspecialchars($employee['department']); ?></p>
        </div>
        <?php if($employee['is_active']): ?>
        <a href="/exit/initiate/<?php echo $employee['id']; ?>" class="btn btn-danger">
            Initiate Exit
        </a>
        <?php else: ?>
        <span class="badge bg-secondary">Deactivated</span>
        <?php endif; ?>
    </div>
    <div class="card-body p-4">
        <!-- Personal & Contact Details Form -->
        <form action="/employees/updateDetails" method="POST">
            <input type="hidden" name="employee_id" value="<?php echo $employee['id']; ?>">
            <h3 class="h5 mt-4">Personal & Contact Details</h3>
            <hr>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="dob" class="form-control" value="<?php echo $details['dob'] ?? ''; ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Marital Status</label>
                    <select name="marital_status" class="form-select">
                        <option value="single" <?php echo ($details['marital_status'] ?? '') == 'single' ? 'selected' : ''; ?>>Single</option>
                        <option value="married" <?php echo ($details['marital_status'] ?? '') == 'married' ? 'selected' : ''; ?>>Married</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Emergency Contact Name</label>
                    <input type="text" name="emergency_contact_name" class="form-control" value="<?php echo $details['emergency_contact_name'] ?? ''; ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Emergency Contact Phone</label>
                    <input type="text" name="emergency_contact_phone" class="form-control" value="<?php echo $details['emergency_contact_phone'] ?? ''; ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Address</label>
                    <textarea name="address" rows="3" class="form-control"><?php echo $details['address'] ?? ''; ?></textarea>
                </div>
            </div>
            <div class="mt-3 text-end">
                <button type="submit" class="btn btn-primary">Save Details</button>
            </div>
        </form>

        <!-- Dependents -->
        <h3 class="h5 mt-4">Dependents</h3>
        <hr>
        <table class="table">
            <tbody>
            <?php foreach($dependents as $dep): ?>
                <tr>
                    <td><?php echo htmlspecialchars($dep['name']); ?></td>
                    <td><?php echo htmlspecialchars($dep['relationship']); ?></td>
                    <td><?php echo htmlspecialchars($dep['dob']); ?></td>
                    <td class="text-end"><a href="/employees/deleteDependent/<?php echo $employee['id']; ?>/<?php echo $dep['id']; ?>" class="btn btn-sm btn-outline-danger">Remove</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <form action="/employees/addDependent" method="POST" class="row g-3 align-items-end mt-2 pt-3 border-top">
            <input type="hidden" name="employee_id" value="<?php echo $employee['id']; ?>">
            <div class="col-md-4">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Relationship</label>
                <input type="text" name="relationship" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Date of Birth</label>
                <input type="date" name="dob" class="form-control" required>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success w-100">Add</button>
            </div>
        </form>
        
        <!-- Employee Files -->
        <h3 class="h5 mt-4">Employee Files</h3>
        <hr>
        <table class="table">
            <tbody>
            <?php foreach($files as $file): ?>
                <tr>
                    <td><a href="/public/uploads/<?php echo htmlspecialchars($file['filename']); ?>" target="_blank"><?php echo htmlspecialchars($file['title']); ?></a></td>
                    <td class="text-muted small"><?php echo date('M j, Y', strtotime($file['created_at'])); ?></td>
                    <td class="text-end"><a href="/employees/deleteFile/<?php echo $employee['id']; ?>/<?php echo $file['id']; ?>" class="btn btn-sm btn-outline-danger">Delete</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <form action="/employees/uploadFile" method="POST" enctype="multipart/form-data" class="row g-3 align-items-end mt-2 pt-3 border-top">
            <input type="hidden" name="employee_id" value="<?php echo $employee['id']; ?>">
            <div class="col-md-5">
                <label class="form-label">File Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="col-md-5">
                <label class="form-label">Upload File</label>
                <input type="file" name="employee_file" class="form-control" required>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success w-100">Upload</button>
            </div>
        </form>
        
        <!-- Awards -->
        <h3 class="h5 mt-4">Awards & Recognition</h3>
        <hr>
        <ul class="list-group list-group-flush">
            <?php foreach($awards as $award): ?>
            <li class="list-group-item">
                <strong><?php echo htmlspecialchars($award['award_name']); ?></strong> on <?php echo date('M j, Y', strtotime($award['date_awarded'])); ?>
                <div class="text-muted small ps-3">Reason: <?php echo htmlspecialchars($award['reason']); ?> (Given by <?php echo htmlspecialchars($award['giver_first_name']); ?>)</div>
            </li>
            <?php endforeach; ?>
        </ul>
        <form action="/award/give" method="POST" class="row g-3 align-items-end mt-2 pt-3 border-top">
            <input type="hidden" name="employee_id" value="<?php echo $employee['id']; ?>">
            <div class="col-md-4">
                <label class="form-label">Award Type</label>
                <select name="award_type_id" class="form-select" required>
                    <?php foreach($award_types as $type): ?>
                    <option value="<?php echo $type['id']; ?>"><?php echo htmlspecialchars($type['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Date</label>
                <input type="date" name="date_awarded" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Reason</label>
                <input type="text" name="reason" class="form-control" required>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success w-100">Give Award</button>
            </div>
        </form>
    </div>
</div>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
