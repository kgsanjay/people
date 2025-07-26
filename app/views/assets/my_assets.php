<?php 
$title = "My Assets";
ob_start(); 
?>

<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="h5 mb-0">Assets Assigned to Me</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Asset Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Serial No.</th>
                        <th scope="col">Purchase Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($assets)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No assets are currently assigned to you.</td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach ($assets as $asset): ?>
                    <tr>
                        <td class="ps-4"><?php echo htmlspecialchars($asset['name']); ?></td>
                        <td><?php echo htmlspecialchars($asset['category']); ?></td>
                        <td><?php echo htmlspecialchars($asset['serial_number']); ?></td>
                        <td><?php echo htmlspecialchars($asset['purchase_date']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
