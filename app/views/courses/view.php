<?php 
$title = "Course: " . htmlspecialchars($course['title']);
$total_lessons = count($lessons);
$completed_lessons = count($completed_ids);
$progress = $total_lessons > 0 ? round(($completed_lessons / $total_lessons) * 100) : 0;
ob_start(); 
?>
<div class="card shadow-sm">
    <div class="card-body p-4">
        <h2 class="card-title display-6 fw-bold text-dark"><?php echo htmlspecialchars($course['title']); ?></h2>
        <p class="card-text text-muted mt-2"><?php echo htmlspecialchars($course['description']); ?></p>

        <div class="mt-4">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="h6 mb-0">Progress</h3>
                <span class="fw-bold text-primary"><?php echo $progress; ?>% Complete</span>
            </div>
            <div class="progress mt-2" style="height: 10px;">
                <div class="progress-bar" role="progressbar" style="width: <?php echo $progress; ?>%" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <p class="text-muted small text-end mt-1"><?php echo $completed_lessons; ?> of <?php echo $total_lessons; ?> lessons complete</p>
        </div>

        <div class="mt-5">
            <h3 class="h5 mb-3">Lessons</h3>
            <div class="list-group">
                <?php foreach($lessons as $lesson): ?>
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <?php if(in_array($lesson['id'], $completed_ids)): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle-fill text-success me-3" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                            </svg>
                        <?php else: ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-circle text-muted me-3" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            </svg>
                        <?php endif; ?>
                        <h4 class="h6 mb-0 <?php echo in_array($lesson['id'], $completed_ids) ? 'text-muted text-decoration-line-through' : 'text-dark'; ?>">
                            <?php echo htmlspecialchars($lesson['title']); ?>
                        </h4>
                    </div>
                    <?php if(!in_array($lesson['id'], $completed_ids)): ?>
                        <a href="/course/completeLesson/<?php echo $course['id']; ?>/<?php echo $lesson['id']; ?>" class="btn btn-sm btn-outline-primary">Mark as Complete</a>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
