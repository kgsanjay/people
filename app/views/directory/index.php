<?php 
$title = "Company Directory";
ob_start(); 
?>
<div class="mb-4">
    <input type="text" id="searchInput" placeholder="Search by name or department..." class="form-control form-control-lg shadow-sm">
</div>

<div id="employeeGrid" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
    <?php foreach($employees as $employee): ?>
    <div class="col employee-card" 
         data-name="<?php echo strtolower(htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name'])); ?>"
         data-department="<?php echo strtolower(htmlspecialchars($employee['department'])); ?>">
        <div class="card h-100 text-center shadow-sm">
            <div class="card-body">
                <img class="rounded-circle mb-3" width="100" height="100" src="https://ui-avatars.com/api/?name=<?php echo urlencode($employee['first_name'] . ' ' . $employee['last_name']); ?>&background=random&color=fff" alt="Profile Picture">
                <h5 class="card-title fw-semibold mb-0"><?php echo htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']); ?></h5>
                <p class="card-text text-muted"><?php echo htmlspecialchars($employee['job_title']); ?></p>
                <p class="card-text small text-muted mt-1"><?php echo htmlspecialchars($employee['department']); ?></p>
                <a href="mailto:<?php echo htmlspecialchars($employee['email']); ?>" class="btn btn-sm btn-outline-primary mt-2">
                    Email
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const employeeCards = document.querySelectorAll('.employee-card');

    searchInput.addEventListener('keyup', function() {
        const searchTerm = searchInput.value.toLowerCase();

        employeeCards.forEach(card => {
            const name = card.dataset.name;
            const department = card.dataset.department;

            if (name.includes(searchTerm) || department.includes(searchTerm)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });
});
</script>

<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
