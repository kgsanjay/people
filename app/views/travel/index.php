<?php 
$title = "Manage Travel Requests";
ob_start(); 
?>
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="h5 mb-0">All Travel Requests</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="ps-4">Employee</th>
                        <th scope="col">Destination</th>
                        <th scope="col">Dates</th>
                        <th scope="col">Est. Cost</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($requests)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No travel requests have been submitted.</td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach($requests as $item): ?>
                    <tr>
                        <td class="ps-4"><?php echo htmlspecialchars($item['first_name'] . ' ' . $item['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($item['destination']); ?></td>
                        <td><?php echo htmlspecialchars($item['start_date']) . ' to ' . htmlspecialchars($item['end_date']); ?></td>
                        <td>₹<?php echo number_format($item['estimated_cost'], 2); ?></td>
                        <td><?php echo htmlspecialchars($item['status']); ?></td>
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
