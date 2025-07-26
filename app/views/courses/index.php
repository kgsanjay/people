<?php 
$title = "Manage Courses";
ob_start(); 
?>
<div class="row g-4">
    <div class="col-lg-4">
        <?php include __DIR__ . '/form.php'; ?>
    </div>
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="h4 text-gray-700 mb-0">Available Courses</h3>
            <a href="/course/enrollments" class="btn btn-secondary">Manage Enrollments</a>
        </div>
        <div class="d-grid gap-3">
            <?php foreach($courses as $course): ?>
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title h5"><?php echo htmlspecialchars($course['title']); ?></h4>
                    <h5 class="h6 mt-4">Lessons</h5>
                    <ul class="list-group list-group-flush">
                        <?php foreach($course['lessons'] as $lesson): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <?php echo htmlspecialchars($lesson['title']); ?>
                            <a href="/course/deleteLesson/<?php echo $lesson['id']; ?>" class="btn-close" aria-label="Delete"></a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <form action="/course/storeLesson" method="POST" class="input-group mt-3">
                        <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                        <input type="text" name="title" placeholder="New lesson title" class="form-control" required>
                        <input type="hidden" name="content" value="Lesson content placeholder.">
                        <button type="submit" class="btn btn-outline-primary">Add Lesson</button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
