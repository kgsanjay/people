<?php 
$title = "Application Settings";
ob_start(); 
?>
<div class="row g-4">
    <!-- Manage Departments -->
    <div class="col-lg-4">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <h3 class="h5 mb-0">Manage Departments</h3>
            </div>
            <div class="card-body">
                <form action="/settings/addDepartment" method="POST" class="input-group mb-3">
                    <input type="text" name="name" placeholder="New department name..." class="form-control" required>
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
                <ul class="list-group list-group-flush">
                    <?php foreach($departments as $dept): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo htmlspecialchars($dept['name']); ?>
                        <a href="/settings/deleteDepartment/<?php echo $dept['id']; ?>" class="btn-close" aria-label="Delete" onclick="return confirm('Are you sure?')"></a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Manage Leave Types -->
    <div class="col-lg-4">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <h3 class="h5 mb-0">Manage Leave Types</h3>
            </div>
            <div class="card-body">
                <form action="/settings/addLeaveType" method="POST" class="input-group mb-3">
                    <input type="text" name="name" placeholder="New leave type name..." class="form-control" required>
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
                <ul class="list-group list-group-flush">
                    <?php foreach($leave_types as $type): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo htmlspecialchars($type['name']); ?>
                        <a href="/settings/deleteLeaveType/<?php echo $type['id']; ?>" class="btn-close" aria-label="Delete" onclick="return confirm('Are you sure?')"></a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Manage Award Types -->
    <div class="col-lg-4">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <h3 class="h5 mb-0">Manage Award Types</h3>
            </div>
            <div class="card-body">
                <form action="/settings/addAwardType" method="POST" class="input-group mb-3">
                    <input type="text" name="name" placeholder="New award type name..." class="form-control" required>
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
                <ul class="list-group list-group-flush">
                    <?php foreach($award_types as $type): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo htmlspecialchars($type['name']); ?>
                        <a href="/settings/deleteAwardType/<?php echo $type['id']; ?>" class="btn-close" aria-label="Delete" onclick="return confirm('Are you sure?')"></a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
