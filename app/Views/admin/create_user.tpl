<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User - AI Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo $basePath; ?>/">AI Forum</a>
            <div class="d-flex">
                <a href="<?php echo $basePath; ?>/admin/users" class="btn btn-primary me-2">Back to Users</a>
                <a href="<?php echo $basePath; ?>/logout" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Create New User</h2>
        <form method="POST" action="<?php echo $basePath; ?>/admin/users/create">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_admin" name="is_admin">
                <label class="form-check-label" for="is_admin">Is Admin</label>
            </div>
            <button type="submit" class="btn btn-primary">Create User</button>
            <a href="<?php echo $basePath; ?>/admin/users" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>