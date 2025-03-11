<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?> - AI Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-light">
    <?php $basePath = $basePath ?? '/AI_Forum_PHP_Project/public'; ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo $basePath; ?>/">AI Forum</a>
            <div class="d-flex">
                <a href="<?php echo $basePath; ?>/" class="btn btn-primary me-2">Back to Home</a>
                <?php if ($is_logged_in): ?>
                    <a href="<?php echo $basePath; ?>/logout" class="btn btn-danger">Logout</a>
                <?php else: ?>
                    <a href="<?php echo $basePath; ?>/login" class="btn btn-primary me-2">Login</a>
                    <a href="<?php echo $basePath; ?>/signup" class="btn btn-success">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h2><?php echo htmlspecialchars($post['title']); ?></h2>
                <p class="text-muted">
                    Posted on: 
                    <?php 
                        $date = new DateTime($post['created_at']);
                        echo $date->format('F j, Y, g:i A');
                    ?>
                </p>
            </div>
            <div class="card-body">
                <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
            </div>
            <div class="card-footer">
                <a href="<?php echo $basePath; ?>/" class="btn btn-primary">Back to Home</a>
                <?php if ($is_logged_in && ($post['user_id'] == $_SESSION['user_id'] || $is_admin)): ?>
                    <a href="<?php echo $basePath; ?>/post/edit/<?php echo $post['id']; ?>" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="<?php echo $basePath; ?>/post/delete/<?php echo $post['id']; ?>" 
                       class="btn btn-danger" 
                       onclick="return confirm('Are you sure?')">
                        <i class="fas fa-trash"></i> Delete
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>