<div class="container mt-4">
    <h2>Manage Users</h2>
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($_SESSION['error_message']); unset($_SESSION['error_message']); ?>
        </div>
    <?php endif; ?>
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
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo $user['is_admin'] ? 'Yes' : 'No'; ?></td>
                    <td>
                        <a href="<?php echo $basePath; ?>/admin/users/delete/<?php echo $user['id']; ?>" 
                           class="btn btn-danger btn-sm" 
                           onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="<?php echo $basePath; ?>/admin/dashboard" class="btn btn-secondary">Back to Dashboard</a>
</div>