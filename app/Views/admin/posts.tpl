<!-- Bootstrap 5 and FontAwesome for icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJZf6EJ6cUgu7nB0pNwKt+6cY5YP8f5xkU1Q7Xm6F5TzQ/tlQpg0Zc+f+zjM" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

<style>
    body {
        background: linear-gradient(120deg, #00d2ff, #3a7bd5);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .table-container {
        background: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .table th {
        background-color: #f8f9fa;
        color: #495057;
    }

    .table td {
        color: #495057;
    }

    .table-hover tbody tr:hover {
        background-color: #e9ecef;
    }

    .btn-custom {
        background-color: #007bff;
        color: white;
        border-radius: 50px;
        padding: 8px 20px;
        text-transform: uppercase;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .btn-custom:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    .back-button {
        background-color: #28a745;
        color: white;
        border-radius: 50px;
        padding: 8px 20px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .back-button:hover {
        background-color: #218838;
        transform: scale(1.05);
    }

    .card {
        border: none;
        background: #ffffff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        padding: 1.5rem;
    }
</style>

<div class="container my-5">
    <h2 class="text-white text-center mb-5">Manage Posts</h2>
    <div class="table-container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>User ID</th>
                    <th>Created At</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post): ?>
                    <tr>
                        <td><?php echo $post['id']; ?></td>
                        <td><?php echo htmlspecialchars($post['title']); ?></td>
                        <td><?php echo $post['user_id']; ?></td>
                        <td><?php echo (new DateTime($post['created_at']))->format('F j, Y, g:i A'); ?></td>
                        <td class="text-center">
                            <a href="<?php echo $basePath; ?>/admin/posts/delete/<?php echo $post['id']; ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer with the back button and post count -->
    <div class="card mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <a href="<?php echo $basePath; ?>/admin/dashboard" class="back-button">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
            <small class="text-muted">Total Posts: <?php echo count($posts); ?></small>
        </div>
    </div>
</div>

<!-- Add Bootstrap JS for any needed functionality -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybP1pWgD7P3cbSzdO0C2vNf7z4RjEFkJp6GyMtvP4iX2FYfl5" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0z33KNp3r0Xme5+Z6sFvFfX2IQdYtpSNTjo1dZpl7KrGnCdb" crossorigin="anonymous"></script>
