<?php 
$title = "My Assigned Tasks";
ob_start(); 
?>
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="h5 mb-0">My Pending Tasks</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Task</th>
                        <th scope="col">For Employee</th>
                        <th scope="col">Checklist</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($tasks)): ?>
                        <tr><td colspan="4" class="text-center text-muted py-4">You have no pending tasks.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td class="ps-4"><?php echo htmlspecialchars($task['task_name']); ?></td>
                        <td><?php echo htmlspecialchars($task['first_name'] . ' ' . $task['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($task['checklist_name']); ?></td>
                        <td>
                            <form action="/onboarding/updateTask" method="POST">
                                <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                <button type="submit" class="btn btn-sm btn-success">Mark as Complete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
