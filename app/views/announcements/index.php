<?php 
$title = "Manage Announcements";
ob_start(); 
?>
<div class="row">
    <div class="col-lg-4">
        <?php include __DIR__ . '/form.php'; ?>
    </div>
    <div class="col-lg-8">
        <h3 class="h4 mb-4 text-gray-700">Published Announcements</h3>
        <div class="card">
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Author</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($announcements as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['title']); ?></td>
                            <td><?php echo htmlspecialchars($item['first_name'] . ' ' . $item['last_name']); ?></td>
                            <td>
                                <a href="/announcement/edit/<?php echo $item['id']; ?>" class="text-primary me-2">Edit</a>
                                <a href="/announcement/delete/<?php echo $item['id']; ?>" class="text-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
