<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Deletion - AI Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo htmlspecialchars($basePath); ?>/">AI Forum</a>
            <div class="d-flex">
                <a href="<?php echo htmlspecialchars($basePath); ?>/" class="btn btn-primary me-2">Back to Home</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="<?php echo htmlspecialchars($basePath); ?>/logout" class="btn btn-danger">Logout</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Confirm Deletion</h2>
        <p>Are you sure you want to delete the post titled "<?php echo htmlspecialchars($post['title']); ?>"?</p>
        <form action="<?php echo htmlspecialchars($basePath); ?>/post/delete/<?php echo htmlspecialchars($post['id']); ?>" method="POST">
            <button type="submit" class="btn btn-danger">Yes, Delete</button>
            <a href="<?php echo htmlspecialchars($basePath); ?>/" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>