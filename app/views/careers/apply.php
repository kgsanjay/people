<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for <?php echo htmlspecialchars($job['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> 
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #f8f9fa;
        } 
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-sm">
                    <div class="card-body p-5">
                        <h1 class="h3 fw-bold text-dark">Apply for <?php echo htmlspecialchars($job['title']); ?></h1>
                        <p class="text-muted mb-4"><?php echo htmlspecialchars($job['department']); ?></p>
                        <form action="/careers/submit" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" name="name" id="name" class="form-control" required>
                                </div>
                                <div class="col-12">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" required>
                                </div>
                                <div class="col-12">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="tel" name="phone" id="phone" class="form-control" required>
                                </div>
                                <div class="col-12">
                                    <label for="resume" class="form-label">Upload Resume</label>
                                    <input type="file" name="resume" id="resume" class="form-control" required>
                                </div>
                            </div>
                            <div class="mt-4 d-flex justify-content-end">
                                <a href="/careers" class="btn btn-secondary me-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">Submit Application</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
