<?php 
$is_edit = ($action ?? '') === 'edit';
$form_title = $is_edit ? "Edit Training Course" : "Create New Course";
$form_action = $is_edit ? "/course/update/" . $course['id'] : "/course/store";
?>
<h3 class="h4 mb-4 text-gray-700"><?php echo $form_title; ?></h3>
<div class="card shadow-sm">
    <div class="card-body">
        <form action="<?php echo $form_action; ?>" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Course Title</label>
                <input type="text" name="title" id="title" class="form-control" value="<?php echo $is_edit ? htmlspecialchars($course['title']) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" rows="4" class="form-control" required><?php echo $is_edit ? htmlspecialchars($course['description']) : ''; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="duration_hours" class="form-label">Duration (in hours)</label>
                <input type="number" name="duration_hours" id="duration_hours" class="form-control" value="<?php echo $is_edit ? htmlspecialchars($course['duration_hours']) : ''; ?>" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary"><?php echo $is_edit ? 'Update Course' : 'Create Course'; ?></button>
                <?php if ($is_edit): ?>
                <a href="/course" class="d-block text-center mt-2 small">Cancel Edit</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>
