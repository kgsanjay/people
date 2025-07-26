<?php
// This is an example of what your notifications.php could look like.
// You would fetch your actual notifications from the database here.
$notifications = [
    ['icon' => 'fas fa-envelope', 'message' => '4 new messages', 'time' => '3 mins', 'url' => '#'],
    ['icon' => 'fas fa-users', 'message' => '8 friend requests', 'time' => '12 hours', 'url' => '#'],
    ['icon' => 'fas fa-file', 'message' => '3 new reports', 'time' => '2 days', 'url' => '#'],
];
$notification_count = count($notifications);
?>

<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <?php if ($notification_count > 0): ?>
            <span class="badge badge-warning navbar-badge"><?= $notification_count ?></span>
        <?php endif; ?>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header"><?= $notification_count ?> Notifications</span>
        <div class="dropdown-divider"></div>
        <?php foreach ($notifications as $notification): ?>
            <a href="<?= $notification['url'] ?>" class="dropdown-item">
                <i class="<?= $notification['icon'] ?> mr-2"></i> <?= $notification['message'] ?>
                <span class="float-right text-muted text-sm"><?= $notification['time'] ?></span>
            </a>
            <div class="dropdown-divider"></div>
        <?php endforeach; ?>
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
    </div>
</li>
