<?php 
$is_edit = ($action ?? '') === 'edit';
$form_title = $is_edit ? "Edit Announcement" : "Create New Announcement";
$form_action = $is_edit ? "/announcement/update/" . $announcement['id'] : "/announcement/store";
?>
<h3 class="h4 mb-4 text-gray-700"><?php echo $form_title; ?></h3>
<div class="card">
    <div class="card-body">
        <form action="<?php echo $form_action; ?>" method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="<?php echo $is_edit ? htmlspecialchars($announcement['title']) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea name="content" id="content" rows="8" class="form-control" required><?php echo $is_edit ? htmlspecialchars($announcement['content']) : ''; ?></textarea>
            </div>
            <div>
                <button type="submit" class="btn btn-primary w-100"><?php echo $is_edit ? 'Update Announcement' : 'Publish Announcement'; ?></button>
                <?php if ($is_edit): ?>
                <a href="/announcement" class="d-block text-center mt-2 small">Cancel Edit</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>