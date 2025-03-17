<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Posts - AI Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo htmlspecialchars($basePath); ?>/">AI Forum</a>
            <div class="d-flex">
                <a href="<?php echo htmlspecialchars($basePath); ?>/admin/dashboard" class="btn btn-primary me-2">Back to Dashboard</a>
                <a href="<?php echo htmlspecialchars($basePath); ?>/logout" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <h2>Manage Posts</h2>

        <!-- Add Post Button -->
        <a href="<?php echo htmlspecialchars($basePath); ?>/post/create" class="btn btn-success mb-3">Add New Post</a>

        <!-- Display a list of posts -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($posts)): ?>
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($post['id']); ?></td>
                            <td><?php echo htmlspecialchars($post['title']); ?></td>
                            <td><?php echo htmlspecialchars($post['username']); ?></td>
                            <td><?php echo htmlspecialchars($post['created_at']); ?></td>
                            <td>
                                <a href="<?php echo htmlspecialchars($basePath); ?>/post/edit/<?php echo htmlspecialchars($post['id']); ?>" 
                                   class="btn btn-primary btn-sm">Edit</a>
                                <a href="<?php echo htmlspecialchars($basePath); ?>/post/delete/<?php echo htmlspecialchars($post['id']); ?>" 
                                   class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No posts found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>