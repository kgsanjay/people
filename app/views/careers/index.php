<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Careers - People HRMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> 
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #f8f9fa;
        } 
        .job-card {
            transition: all 0.2s ease-in-out;
        }
        .job-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <header class="text-center mb-5">
            <h1 class="display-4 fw-bold text-dark">Join Our Team</h1>
            <p class="lead text-muted">We're looking for passionate people to join us on our mission.</p>
        </header>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="d-grid gap-4">
                    <?php if (empty($jobs)): ?>
                        <div class="card shadow-sm">
                            <div class="card-body text-center text-muted">
                                There are currently no open positions. Please check back later!
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php foreach($jobs as $job): ?>
                    <div class="card shadow-sm job-card">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h2 class="h4 fw-semibold text-primary"><?php echo htmlspecialchars($job['title']); ?></h2>
                                    <p class="text-muted mb-3"><?php echo htmlspecialchars($job['department']); ?></p>
                                    <div class="prose">
                                        <?php echo nl2br(htmlspecialchars($job['description'])); ?>
                                    </div>
                                </div>
                                <a href="/careers/apply/<?php echo $job['id']; ?>" class="btn btn-success flex-shrink-0 ms-4">Apply Now</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
