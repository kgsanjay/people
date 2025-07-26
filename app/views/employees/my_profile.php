<?php 
$title = "My Profile";
ob_start(); 
?>
<div class="card shadow-sm">
    <div class="card-header bg-light p-4">
        <h2 class="h4 mb-0"><?php echo htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']); ?></h2>
        <p class="text-muted mb-0"><?php echo htmlspecialchars($employee['job_title']); ?> - <?php echo htmlspecialchars($employee['department']); ?></p>
    </div>
    <div class="card-body p-4">
        <!-- Personal Details -->
        <h3 class="h5 mt-4">Personal Details</h3>
        <hr>
        <div class="row g-3">
            <div class="col-md-6"><strong class="text-muted">Date of Birth:</strong> <?php echo htmlspecialchars($details['dob'] ?? 'N/A'); ?></div>
            <div class="col-md-6"><strong class="text-muted">Marital Status:</strong> <?php echo ucfirst(htmlspecialchars($details['marital_status'] ?? 'N/A')); ?></div>
            <div class="col-12"><strong class="text-muted">Address:</strong> <?php echo htmlspecialchars($details['address'] ?? 'N/A'); ?></div>
        </div>

        <!-- Emergency Contact -->
        <h3 class="h5 mt-4">Emergency Contact</h3>
        <hr>
        <div class="row g-3">
            <div class="col-md-6"><strong class="text-muted">Name:</strong> <?php echo htmlspecialchars($details['emergency_contact_name'] ?? 'N/A'); ?></div>
            <div class="col-md-6"><strong class="text-muted">Phone:</strong> <?php echo htmlspecialchars($details['emergency_contact_phone'] ?? 'N/A'); ?></div>
        </div>

        <!-- Dependents -->
        <h3 class="h5 mt-4">Dependents</h3>
        <hr>
        <ul class="list-group list-group-flush">
            <?php foreach($dependents as $dep): ?>
            <li class="list-group-item"><?php echo htmlspecialchars($dep['name']); ?> (<?php echo htmlspecialchars($dep['relationship']); ?>) - DOB: <?php echo htmlspecialchars($dep['dob']); ?></li>
            <?php endforeach; ?>
            <?php if(empty($dependents)) echo "<li class='list-group-item text-muted'>No dependents listed.</li>"; ?>
        </ul>
        
        <!-- Files -->
        <h3 class="h5 mt-4">My Files</h3>
        <hr>
        <ul class="list-group list-group-flush">
            <?php foreach($files as $file): ?>
            <li class="list-group-item"><a href="/public/uploads/<?php echo htmlspecialchars($file['filename']); ?>" target="_blank" class="text-decoration-none"><?php echo htmlspecialchars($file['title']); ?></a></li>
            <?php endforeach; ?>
            <?php if(empty($files)) echo "<li class='list-group-item text-muted'>No files uploaded.</li>"; ?>
        </ul>
        
        <!-- Awards -->
        <h3 class="h5 mt-4">My Awards</h3>
        <hr>
        <ul class="list-group list-group-flush">
            <?php foreach($awards as $award): ?>
            <li class="list-group-item">
                <strong><?php echo htmlspecialchars($award['award_name']); ?></strong> on <?php echo date('M j, Y', strtotime($award['date_awarded'])); ?>
                <div class="text-muted small ps-3">Reason: <?php echo htmlspecialchars($award['reason']); ?> (Given by <?php echo htmlspecialchars($award['giver_first_name']); ?>)</div>
            </li>
            <?php endforeach; ?>
            <?php if(empty($awards)) echo "<li class='list-group-item text-muted'>No awards received yet.</li>"; ?>
        </ul>
    </div>
</div>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
