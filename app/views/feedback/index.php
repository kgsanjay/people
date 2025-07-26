<?php 
$title = "My Feedback";
ob_start(); 
?>
<div class="d-flex justify-content-end gap-2 mb-3">
    <a href="/feedback/request" class="btn btn-outline-secondary">Request Feedback</a>
    <a href="/feedback/give" class="btn btn-primary">Give Feedback</a>
</div>

<div class="row g-4">
    <!-- Feedback Received -->
    <div class="col-lg-4">
        <h3 class="h5 mb-3">Feedback I've Received</h3>
        <div class="d-grid gap-3">
            <?php foreach($received as $item): ?>
            <div class="card">
                <div class="card-body">
                    <p class="card-text"><?php echo nl2br(htmlspecialchars($item['content'])); ?></p>
                    <small class="text-muted">From: <?php echo htmlspecialchars($item['giver_first_name'] . ' ' . $item['giver_last_name']); ?></small>
                </div>
            </div>
            <?php endforeach; ?>
             <?php if(empty($received)) echo "<p class='text-muted'>No feedback received yet.</p>"; ?>
        </div>
    </div>

    <!-- Feedback Given -->
    <div class="col-lg-4">
        <h3 class="h5 mb-3">Feedback I've Given</h3>
        <div class="d-grid gap-3">
            <?php foreach($given as $item): ?>
            <div class="card">
                <div class="card-body">
                    <p class="card-text"><?php echo nl2br(htmlspecialchars($item['content'])); ?></p>
                    <small class="text-muted">To: <?php echo htmlspecialchars($item['receiver_first_name'] . ' ' . $item['receiver_last_name']); ?></small>
                </div>
            </div>
            <?php endforeach; ?>
            <?php if(empty($given)) echo "<p class='text-muted'>You haven't given any feedback yet.</p>"; ?>
        </div>
    </div>

    <!-- My Requests -->
    <div class="col-lg-4">
        <h3 class="h5 mb-3">Pending Requests</h3>
        <div class="d-grid gap-3">
            <?php foreach($requests as $item): ?>
            <div class="card bg-light border-warning">
                <div class="card-body">
                    <p class="card-text">You requested feedback from <strong><?php echo htmlspecialchars($item['requester_first_name'] . ' ' . $item['requester_last_name']); ?></strong></p>
                    <small class="text-muted">Context: <?php echo htmlspecialchars($item['context']); ?></small>
                    <a href="/feedback/give/<?php echo $item['requester_id']; ?>/<?php echo $item['id']; ?>" class="btn btn-sm btn-warning mt-2">Give Feedback Now</a>
                </div>
            </div>
            <?php endforeach; ?>
            <?php if(empty($requests)) echo "<p class='text-muted'>You have no pending requests for feedback.</p>"; ?>
        </div>
    </div>
</div>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
