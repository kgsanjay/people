<?php 
$title = "My Attendance";
ob_start(); 
?>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="row g-4">
            <!-- Clock In/Out Section -->
            <div class="col-md-5">
                <div class="card shadow-sm text-center h-100">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <h3 class="card-title h5">Today's Attendance</h3>
                        <p class="card-text text-muted mb-4"><?php echo date('l, F j, Y'); ?></p>
                        
                        <?php if (!$today_attendance): ?>
                            <!-- Not clocked in yet -->
                            <form action="/attendance/clockin" method="POST">
                                <button type="submit" class="btn btn-success btn-lg w-100">
                                    Clock In
                                </button>
                            </form>
                        <?php elseif (!$today_attendance['clock_out']): ?>
                            <!-- Clocked in, but not out -->
                            <div class="mb-3">
                                <span class="text-muted">Clocked In at:</span>
                                <span class="fw-bold text-success"><?php echo date('h:i A', strtotime($today_attendance['clock_in'])); ?></span>
                            </div>
                            <form action="/attendance/clockout" method="POST">
                                <input type="hidden" name="attendance_id" value="<?php echo $today_attendance['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-lg w-100">
                                    Clock Out
                                </button>
                            </form>
                        <?php else: ?>
                            <!-- Clocked in and out for the day -->
                            <div class="mb-2">
                                <span class="text-muted">Clocked In:</span>
                                <span class="fw-bold text-success"><?php echo date('h:i A', strtotime($today_attendance['clock_in'])); ?></span>
                            </div>
                            <div>
                                 <span class="text-muted">Clocked Out:</span>
                                <span class="fw-bold text-danger"><?php echo date('h:i A', strtotime($today_attendance['clock_out'])); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Attendance History Section -->
            <div class="col-md-7">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="h5 mb-0">My Attendance History</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="ps-4">Date</th>
                                        <th scope="col">Clock In</th>
                                        <th scope="col">Clock Out</th>
                                        <th scope="col">Total Hours</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($attendance_history)): ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">No attendance records found.</td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php foreach ($attendance_history as $record): ?>
                                    <tr>
                                        <td class="ps-4"><?php echo htmlspecialchars($record['work_date']); ?></td>
                                        <td class="text-success fw-semibold"><?php echo date('h:i A', strtotime($record['clock_in'])); ?></td>
                                        <td class="text-danger fw-semibold">
                                            <?php echo $record['clock_out'] ? date('h:i A', strtotime($record['clock_out'])) : 'N/A'; ?>
                                        </td>
                                        <td>
                                            <?php 
                                                if ($record['clock_out']) {
                                                    $clock_in = new DateTime($record['clock_in']);
                                                    $clock_out = new DateTime($record['clock_out']);
                                                    $interval = $clock_in->diff($clock_out);
                                                    echo $interval->format('%h h %i m');
                                                } else {
                                                    echo 'N/A';
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean();
require __DIR__ . '/../layouts/app.php';
?>
