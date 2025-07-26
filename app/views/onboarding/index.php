<?php 
$title = "Onboarding & Offboarding";
ob_start(); 
?>
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="h5 mb-0">Create Checklist Template</h3>
            </div>
            <div class="card-body">
                <form action="/onboarding/storeTemplate" method="POST" id="templateForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">Template Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Template Type</label>
                        <select name="type" id="type" class="form-select">
                            <option value="onboarding">Onboarding</option>
                            <option value="offboarding">Offboarding</option>
                        </select>
                    </div>
                    <hr>
                    <h4 class="h6">Checklist Items</h4>
                    <div id="task-container" class="d-grid gap-2 mb-2">
                        <!-- Tasks will be added here by JS -->
                    </div>
                    <button type="button" id="addTaskBtn" class="btn btn-sm btn-outline-secondary mb-3">+ Add Task</button>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Save Template</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="h5 mb-0">Active Processes</h3>
                 <a href="/onboarding/assign" class="btn btn-success btn-sm">Assign Checklist</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="ps-4">Employee</th>
                                <th scope="col">Process</th>
                                <th scope="col">Type</th>
                                <th scope="col">Assigned On</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($assignments as $item): ?>
                            <tr>
                                <td class="ps-4"><?php echo htmlspecialchars($item['first_name'] . ' ' . $item['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($item['checklist_name']); ?></td>
                                <td><span class="badge <?php echo $item['type'] == 'onboarding' ? 'bg-primary-subtle text-primary-emphasis' : 'bg-danger-subtle text-danger-emphasis'; ?>"><?php echo ucfirst($item['type']); ?></span></td>
                                <td><?php echo date('M j, Y', strtotime($item['created_at'])); ?></td>
                                <td><a href="/onboarding/progress/<?php echo $item['id']; ?>" class="btn btn-sm btn-outline-secondary">View Progress</a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addTaskBtn = document.getElementById('addTaskBtn');
    const taskContainer = document.getElementById('task-container');
    let taskIndex = 0;

    function addTask() {
        const taskHtml = `
            <div class="input-group">
                <input type="text" name="tasks[${taskIndex}][name]" placeholder="Task Name" class="form-control" required>
                <select name="tasks[${taskIndex}][role]" class="form-select">
                    <option value="employee">Employee</option>
                    <option value="manager">Manager</option>
                    <option value="admin">Admin/HR</option>
                </select>
            </div>
        `;
        taskContainer.insertAdjacentHTML('beforeend', taskHtml);
        taskIndex++;
    }

    addTaskBtn.addEventListener('click', addTask);
    addTask(); // Add one task by default
});
</script>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
