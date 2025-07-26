<?php 
$title = "Team Feedback";
ob_start(); 
?>
<div class="d-grid gap-4">
    <?php if(empty($feedback)): ?>
        <div class="card">
            <div class="card-body text-center text-muted">
                No public feedback has been given to your team members yet.
            </div>
        </div>
    <?php endif; ?>
    <?php foreach($feedback as $item): ?>
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="h6 mb-0 fw-semibold"><?php echo htmlspecialchars($item['receiver_first_name'] . ' ' . $item['receiver_last_name']); ?></h4>
            <small class="text-muted"><?php echo date('M j, Y', strtotime($item['created_at'])); ?></small>
        </div>
        <div class="card-body">
            <blockquote class="blockquote mb-0">
                <p><?php echo nl2br(htmlspecialchars($item['content'])); ?></p>
                <footer class="blockquote-footer mt-2">Feedback from <cite title="Source Title"><?php echo htmlspecialchars($item['giver_first_name'] . ' ' . $item['giver_last_name']); ?></cite></footer>
            </blockquote>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
