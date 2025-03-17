<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post - AI Forum</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <!-- Brand/logo -->
            <a class="navbar-brand" href="<?php echo htmlspecialchars($basePath); ?>/">AI Forum</a>
            <div class="d-flex">
                <?php if ($is_admin): ?>
                    <!-- Back to Manage Posts Button (Admin Only) -->
                    <a href="<?php echo htmlspecialchars($basePath); ?>/admin/posts" class="btn btn-primary me-2">Back to Posts</a>
                <?php endif; ?>
                <!-- Logout Button -->
                <a href="<?php echo htmlspecialchars($basePath); ?>/logout" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <h2 class="mb-4"><?php echo $is_admin ? 'Create New Post (Admin)' : 'Create New Post'; ?></h2>

        <!-- Display Success/Error Messages -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success" role="alert">
                <?php echo htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($_SESSION['error_message']); unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Create Post Form -->
        <form method="POST" action="<?php echo htmlspecialchars($basePath); ?>/<?php echo $is_admin ? 'admin/posts/create' : 'post/create'; ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" 
                       value="<?php echo htmlspecialchars($title ?? ''); ?>" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" rows="5" required><?php 
                    echo htmlspecialchars($content ?? ''); 
                ?></textarea>
            </div>
            <button type="submit" class="btn btn-success">Create Post</button>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>