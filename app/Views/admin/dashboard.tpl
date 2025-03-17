<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Set character encoding and viewport for responsiveness -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - AI Forum</title>

    <!-- Include Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <!-- Brand/logo -->
            <a class="navbar-brand" href="<?php echo htmlspecialchars($basePath); ?>/">AI Forum</a>
            <div class="d-flex">
                <!-- Back to Home button -->
                <a href="<?php echo htmlspecialchars($basePath); ?>/" class="btn btn-primary me-2">Back to Home</a>
                <!-- Logout button -->
                <a href="<?php echo htmlspecialchars($basePath); ?>/logout" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <h2>Admin Dashboard</h2>

        <!-- Debugging Output (Optional) -->
        <!--
        <?php // Uncomment this section for debugging purposes
        // var_dump($data); // Example: Dump data passed to the view
        ?>
        -->

        <!-- Admin Actions -->
        <div class="row">
            <!-- Manage Users Button -->
            <div class="col-md-6">
                <a href="<?php echo htmlspecialchars($basePath); ?>/admin/users" class="btn btn-primary btn-lg w-100 mb-3">
                    Manage Users
                </a>
            </div>

            <!-- Manage Posts Button -->
            <div class="col-md-6">
                <a href="<?php echo htmlspecialchars($basePath); ?>/admin/posts" class="btn btn-primary btn-lg w-100 mb-3">
                    Manage Posts
                </a>
            </div>
        </div>
    </div>
</body>
</html>