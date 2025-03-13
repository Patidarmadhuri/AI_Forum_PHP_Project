<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin Panel</title>

    <!-- Bootstrap 5 and FontAwesome for icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJZf6EJ6cUgu7nB0pNwKt+6cY5YP8f5xkU1Q7Xm6F5TzQ/tlQpg0Zc+f+zjM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        .card {
            border: none;
            border-radius: 12px;
            margin-top: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: white;
            padding: 1.5rem;
            border-radius: 12px 12px 0 0;
        }

        .card-footer {
            background-color: #f9f9f9;
            border-radius: 0 0 12px 12px;
            padding: 15px;
        }

        .table thead th {
            background-color: #f8f9fa;
            color: #495057;
            font-weight: bold;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f3f5;
            cursor: pointer;
        }

        .table td, .table th {
            vertical-align: middle;
            text-align: center;
        }

        .badge {
            font-size: 0.9rem;
            padding: 6px 12px;
            border-radius: 20px;
        }

        .btn-custom {
            background-color: #007bff;
            color: white;
            padding: 8px 14px;
            border-radius: 4px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
            padding: 8px 14px;
            border-radius: 4px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #c82333;
            transform: scale(1.05);
        }

        .back-button {
            background-color: #6c757d;
            color: white;
            padding: 8px 14px;
            border-radius: 4px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            background-color: #5a6268;
            transform: scale(1.05);
        }

        .alert-dismissible .btn-close {
            background-color: transparent;
            border: none;
            opacity: 0.5;
        }

        .table-responsive {
            margin-top: 20px;
        }

        .btn-sm {
            font-size: 0.85rem;
            padding: 5px 10px;
        }

        .tooltip-inner {
            background-color: #007bff;
        }

        .tooltip-arrow {
            border-top-color: #007bff;
        }

        .alert {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
    </style>
</head>
<body class="bg-light">

    <div class="container">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="m-0">Manage Users</h2>
                <a href="<?php echo $basePath; ?>/admin/users/create" class="btn btn-light btn-custom">
                    <i class="fas fa-user-plus"></i> Add User
                </a>
            </div>

            <!-- Success Message -->
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-success alert-dismissible fade show m-3">
                    <?php echo htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Error Message -->
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger alert-dismissible fade show m-3">
                    <?php echo htmlspecialchars($_SESSION['error_message']); unset($_SESSION['error_message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo $user['id']; ?></td>
                                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td>
                                        <span class="badge <?php echo $user['is_admin'] ? 'bg-success' : 'bg-secondary'; ?>">
                                            <?php echo $user['is_admin'] ? 'Admin' : 'User'; ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?php echo $basePath; ?>/admin/users/edit/<?php echo $user['id']; ?>" class="btn btn-primary btn-sm me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit User">
                                            <i class="fas fa-user-edit"></i> Edit
                                        </a>
                                        <a href="<?php echo $basePath; ?>/admin/users/delete/<?php echo $user['id']; ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this user?')" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete User">
                                            <i class="fas fa-user-times"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer text-center">
                <a href="<?php echo $basePath; ?>/admin/dashboard" class="back-button">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS for any needed functionality -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybP1pWgD7P3cbSzdO0C2vNf7z4RjEFkJp6GyMtvP4iX2FYfl5" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0z33KNp3r0Xme5+Z6sFvFfX2IQdYtpSNTjo1dZpl7KrGnCdb" crossorigin="anonymous"></script>

    <!-- Initialize tooltips -->
    <script>
        var tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        var tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>

</body>
</html>
