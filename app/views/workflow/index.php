<?php 
$title = "Manage Workflows";
ob_start(); 
?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="h5 mb-0">Create New Workflow</h3>
            </div>
            <div class="card-body">
                <p class="card-text text-muted small">The system will automatically use the first workflow created for each type (e.g., the first 'Leave' workflow will be used for all leave requests).</p>
                <form action="/workflow/create" method="POST" id="workflowForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">Workflow Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="e.g., Standard Leave Approval" required>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Workflow Type</label>
                        <select name="type" id="type" class="form-select">
                            <option value="leave">Leave</option>
                            <option value="expense">Expense</option>
                            <option value="travel">Travel</option>
                            <option value="timesheet">Timesheet</option>
                            <option value="claim">Claim</option>
                        </select>
                    </div>
                    <hr class="my-4">
                    <h4 class="h6 mb-3">Approval Steps (in order)</h4>
                    <div id="step-container" class="d-grid gap-3 mb-3">
                        <!-- Steps will be added here by JS -->
                    </div>
                    <button type="button" id="addStepBtn" class="btn btn-sm btn-outline-secondary mb-3">+ Add Step</button>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Save Workflow</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addStepBtn = document.getElementById('addStepBtn');
    const stepContainer = document.getElementById('step-container');
    let stepIndex = 0;

    function addStep() {
        const stepHtml = `
            <div class="input-group">
                <span class="input-group-text">${stepIndex + 1}.</span>
                <input type="text" name="steps[${stepIndex}][name]" placeholder="Step Name (e.g., Manager Approval)" class="form-control" required>
                <select name="steps[${stepIndex}][role]" class="form-select">
                    <option value="manager">Employee's Manager</option>
                    <option value="admin">Admin/HR</option>
                </select>
            </div>
        `;
        stepContainer.insertAdjacentHTML('beforeend', stepHtml);
        stepIndex++;
    }

    addStepBtn.addEventListener('click', addStep);
    // Add the first step by default
    addStep();
});
</script>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
