<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Custom Styles for 2025 */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .navbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .hero-section {
            background: #007bff;
            color: white;
            padding: 3rem 1rem;
            text-align: center;
            border-radius: 0 0 20px 20px;
        }
        .post-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            background: white;
        }
        .post-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }
        .post-card .card-body {
            padding: 1.5rem;
        }
        .btn-primary {
            background: #007bff;
            border: none;
            transition: background 0.3s ease;
        }
        .btn-primary:hover {
            background: #0056b3;
        }
        .search-bar {
            max-width: 500px;
            margin: 0 auto 2rem;
        }
        .dark-mode-toggle {
            cursor: pointer;
        }
        @media (max-width: 768px) {
            .hero-section { padding: 2rem 1rem; }
            .post-card { margin-bottom: 1.5rem; }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?php echo $basePath; ?>/"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if ($is_logged_in): ?>
                        <?php if ($is_admin): ?>
                            <li class="nav-item">
                                <a href="<?php echo $basePath; ?>/admin/dashboard" class="btn btn-warning me-2">Admin Dashboard</a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a href="<?php echo $basePath; ?>/post/create" class="btn btn-success me-2">Create Post</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $basePath; ?>/logout" class="btn btn-danger">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a href="<?php echo $basePath; ?>/login" class="btn btn-primary me-2">Login</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $basePath; ?>/signup" class="btn btn-success">Sign Up</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <span class="text-white ms-2 dark-mode-toggle" onclick="toggleDarkMode()">
                            <i class="fas fa-moon"></i>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <h1 class="display-4 fw-bold">Welcome to AI Forum</h1>
        <p class="lead">Share ideas, ask questions, and connect with the AI community.</p>
    </div>

    <!-- Main Content -->
    <div class="container my-5">
        <!-- Search Bar -->
        <form method="GET" action="<?php echo $basePath; ?>/" class="search-bar">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search posts..." 
                       value="<?php echo htmlspecialchars($search ?? ''); ?>">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
            </div>
        </form>

        <!-- Messages -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_SESSION['error_message']); unset($_SESSION['error_message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Posts -->
        <div class="row">
            <?php if (empty($posts)): ?>
                <div class="col-12 text-center">
                    <p class="text-muted">No posts found. <?php if ($is_logged_in): ?>Start by creating one!<?php endif; ?></p>
                </div>
            <?php else: ?>
                <?php foreach ($posts as $post): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card post-card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h5>
                                <p class="card-text text-muted"><?php echo substr(htmlspecialchars($post['content']), 0, 100) . '...'; ?></p>
                                <a href="<?php echo $basePath; ?>/post/<?php echo $post['id']; ?>" class="btn btn-primary btn-sm">View</a>
                                <?php if ($is_logged_in && isset($post['user_id']) && ($post['user_id'] == $_SESSION['user_id'] || $is_admin)): ?>
    <a href="<?php echo $basePath; ?>/post/edit/<?php echo $post['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
    <a href="<?php echo $basePath; ?>/post/delete/<?php echo $post['id']; ?>" 
       class="btn btn-danger btn-sm" 
       onclick="return confirm('Are you sure?')">Delete</a>
<?php endif; ?>
          </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?php if (!empty($search)): ?>
            <a href="<?php echo $basePath; ?>/" class="btn btn-secondary">Back to All Posts</a>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; <?php echo date('Y'); ?> AI Forum. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleDarkMode() {
            document.body.classList.toggle('bg-dark');
            document.body.classList.toggle('text-white');
            document.querySelectorAll('.post-card').forEach(card => {
                card.classList.toggle('bg-dark');
                card.classList.toggle('text-white');
            });
            document.querySelector('.hero-section').classList.toggle('bg-primary');
            document.querySelector('.hero-section').classList.toggle('bg-dark');
        }
    </script>
</body>
</html>