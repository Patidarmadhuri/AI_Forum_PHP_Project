<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Posts - AI Forum</title>
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
                <!-- Create Post Button -->
                <a href="<?php echo htmlspecialchars($basePath); ?>/admin/posts/create" class="btn btn-success me-2">Create Post</a>
                <!-- Back to Dashboard Button -->
                <a href="<?php echo htmlspecialchars($basePath); ?>/admin/dashboard" class="btn btn-primary me-2">Back to Dashboard</a>
                <!-- Logout Button -->
                <a href="<?php echo htmlspecialchars($basePath); ?>/logout" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <h2 class="mb-4">Manage Posts</h2>

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

        <!-- Posts Table -->
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($posts)): ?>
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($post['id']); ?></td>
                            <td><?php echo htmlspecialchars($post['title']); ?></td>
                            <td><?php echo htmlspecialchars($post['username'] ?? 'Unknown'); ?></td>
                            <td>
                                <!-- Edit Button -->
                                <a href="<?php echo htmlspecialchars($basePath); ?>/admin/posts/edit/<?php echo htmlspecialchars($post['id']); ?>" 
                                   class="btn btn-warning btn-sm me-2">Edit</a>
                                <!-- Delete Button -->
                                <a href="<?php echo htmlspecialchars($basePath); ?>/admin/posts/delete/<?php echo htmlspecialchars($post['id']); ?>" 
                                   class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No posts found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>