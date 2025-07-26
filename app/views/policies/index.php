<?php 
$title = "Manage Company Policies";
ob_start(); 
?>
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="h5 mb-0">Upload New Policy</h3>
            </div>
            <div class="card-body">
                <form action="/policy/upload" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Policy Title</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="policy_file" class="form-label">Policy Document (PDF)</label>
                        <input type="file" name="policy_file" id="policy_file" class="form-control" required accept=".pdf">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Publish Policy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="h5 mb-0">Published Policies</h3>
            </div>
            <div class="card-body">
                <div class="accordion" id="policyAccordion">
                    <?php foreach($policies as $policy): ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-<?php echo $policy['id']; ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $policy['id']; ?>">
                                <?php echo htmlspecialchars($policy['title']); ?>
                                <span class="badge bg-secondary ms-auto me-2"><?php echo count($policy['acknowledgments']); ?> Acknowledged</span>
                            </button>
                        </h2>
                        <div id="collapse-<?php echo $policy['id']; ?>" class="accordion-collapse collapse" data-bs-parent="#policyAccordion">
                            <div class="accordion-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <a href="/public/uploads/<?php echo htmlspecialchars($policy['filename']); ?>" target="_blank" class="btn btn-sm btn-outline-primary">View Document</a>
                                    <a href="/policy/delete/<?php echo $policy['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete Policy</a>
                                </div>
                                <strong>Acknowledged By:</strong>
                                <ul class="list-group list-group-flush mt-2">
                                    <?php if(empty($policy['acknowledgments'])): ?>
                                        <li class="list-group-item text-muted">No one has acknowledged this policy yet.</li>
                                    <?php endif; ?>
                                    <?php foreach($policy['acknowledgments'] as $ack): ?>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span><?php echo htmlspecialchars($ack['first_name'] . ' ' . $ack['last_name']); ?></span>
                                        <span class="text-muted small"><?php echo date('M j, Y', strtotime($ack['acknowledged_at'])); ?></span>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
