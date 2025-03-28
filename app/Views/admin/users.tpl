<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Set character encoding and viewport for responsiveness -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - AI Forum</title>

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
                <!-- Back to Dashboard button -->
                <a href="<?php echo htmlspecialchars($basePath); ?>/admin/dashboard" class="btn btn-primary me-2">Back to Dashboard</a>
                <!-- Logout button -->
                <a href="<?php echo htmlspecialchars($basePath); ?>/logout" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <h2>Manage Users</h2>

        <!-- Add User Button -->
        <a href="<?php echo htmlspecialchars($basePath); ?>/admin/users/create" class="btn btn-success mb-3">Add New User</a>

        <!-- Display a list of users -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Admin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo $user['is_admin'] ? 'Yes' : 'No'; ?></td>
                            <td>
                                <a href="<?php echo htmlspecialchars($basePath); ?>/admin/users/edit/<?php echo htmlspecialchars($user['id']); ?>" 
                                   class="btn btn-primary btn-sm">Edit</a>
                                <a href="<?php echo htmlspecialchars($basePath); ?>/admin/users/delete/<?php echo htmlspecialchars($user['id']); ?>" 
                                   class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>