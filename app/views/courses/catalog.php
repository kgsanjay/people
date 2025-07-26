<?php 
$title = "Learning Catalog";
ob_start(); 
?>
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    <?php foreach($courses as $course): ?>
    <div class="col">
        <div class="card h-100 shadow-sm">
            <div class="card-body d-flex flex-column">
                <h3 class="card-title h5 fw-semibold text-primary"><?php echo htmlspecialchars($course['title']); ?></h3>
                <p class="card-subtitle mb-2 text-muted small">Duration: <?php echo htmlspecialchars($course['duration_hours']); ?> hours</p>
                <p class="card-text flex-grow-1"><?php echo htmlspecialchars($course['description']); ?></p>
                <a href="/course/view/<?php echo $course['id']; ?>" class="btn btn-primary mt-auto">
                    Start Learning
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
