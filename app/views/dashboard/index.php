<?php
// Note: The old method of using ob_start() and requiring app.php at the end is no longer needed.
// The new app.php layout directly includes this view file.
?>

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Dashboard</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3><?php echo $total_employees; ?></h3>
                    <p>Total Employees</p>
                </div>
                <div class="icon"><i class="ion ion-person-stalker"></i></div>
                <a href="<?= BASE_URL ?>employees" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?php echo $present_today; ?></h3>
                    <p>Employees Present</p>
                </div>
                <div class="icon"><i class="ion ion-pie-graph"></i></div>
                <a href="<?= BASE_URL ?>attendance" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3><?php echo $pending_reviews; ?></h3>
                    <p>Pending Reviews</p>
                </div>
                <div class="icon"><i class="ion ion-clipboard"></i></div>
                <a href="<?= BASE_URL ?>performance" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3><?php echo $pending_expenses; ?></h3>
                    <p>Pending Expenses</p>
                </div>
                <div class="icon"><i class="ion ion-card"></i></div>
                <a href="<?= BASE_URL ?>expenses" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <!-- /.row -->

    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
            <!-- Announcements -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-bullhorn mr-1"></i> Company News</h3>
                </div>
                <div class="card-body">
                    <?php if (empty($announcements)): ?>
                        <p class="text-muted">No announcements at this time.</p>
                    <?php else: ?>
                        <?php foreach($announcements as $item): ?>
                        <div class="post">
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm" src="https://ui-avatars.com/api/?name=<?php echo urlencode($item['first_name'] . ' ' . $item['last_name']); ?>&background=random" alt="user image">
                                <span class="username">
                                    <a href="#"><?php echo htmlspecialchars($item['title']); ?></a>
                                </span>
                                <span class="description">Posted by <?php echo htmlspecialchars($item['first_name'] . ' ' . $item['last_name']); ?> - <?php echo date('F j, Y', strtotime($item['created_at'])); ?></span>
                            </div>
                            <p><?php echo nl2br(htmlspecialchars($item['content'])); ?></p>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">
            <!-- Recent Awards -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-trophy mr-1"></i> Recent Awards</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        <?php foreach($recent_awards as $award): ?>
                        <li class="item">
                            <div class="product-img">
                                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($award['first_name'] . ' ' . $award['last_name']); ?>&background=random" alt="Avatar" class="img-size-50 img-circle">
                            </div>
                            <div class="product-info">
                                <a href="javascript:void(0)" class="product-title"><?php echo htmlspecialchars($award['first_name'] . ' ' . $award['last_name']); ?></a>
                                <span class="product-description">
                                    Received '<?php echo htmlspecialchars($award['award_name']); ?>'
                                </span>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- right col -->
    </div>
    <!-- /.row (main row) -->
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->