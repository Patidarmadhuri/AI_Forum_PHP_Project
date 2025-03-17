<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - AI Forum</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo htmlspecialchars($basePath); ?>/">AI Forum</a>
            <div class="d-flex">
                <a href="<?php echo htmlspecialchars($basePath); ?>/admin/users" class="btn btn-primary me-2">Back to Users</a>
                <a href="<?php echo htmlspecialchars($basePath); ?>/logout" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <h2>Edit User</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($basePath); ?>/admin/users/edit/<?php echo htmlspecialchars($user['id']); ?>" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_admin" name="is_admin" <?php echo $user['is_admin'] ? 'checked' : ''; ?>>
                <label class="form-check-label" for="is_admin">Is Admin?</label>
            </div>
            <button type="submit" class="btn btn-success">Update User</button>
            <a href="<?php echo htmlspecialchars($basePath); ?>/admin/users" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>