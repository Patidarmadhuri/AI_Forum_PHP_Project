<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - AI Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo $basePath; ?>/">AI Forum</a>
            <div class="d-flex">
                <a href="<?php echo $basePath; ?>/" class="btn btn-primary me-2">Back to Home</a>
                <a href="<?php echo $basePath; ?>/logout" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Admin Dashboard</h2>
        <!-- Debugging output -->
      
        <div class="row">
            <div class="col-md-6">
                <a href="<?php echo $basePath; ?>/admin/users" class="btn btn-primary btn-lg w-100 mb-3">Manage Users</a>
            </div>
            <div class="col-md-6">
                <a href="<?php echo $basePath; ?>/admin/posts" class="btn btn-primary btn-lg w-100 mb-3">Manage Posts</a>
            </div>
        </div>
    </div>
</body>
</html>