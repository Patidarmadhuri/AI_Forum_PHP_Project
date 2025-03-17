<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - AI Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh; }
        .signup-container { max-width: 400px; margin: 100px auto; padding: 2rem; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1); border-radius: 15px; background: white; }
        .form-control:focus { border-color: #28a745; box-shadow: 0 0 5px rgba(40, 167, 69, 0.5); }
        .btn-success { background: #28a745; border: none; }
        .btn-success:hover { background: #1e7e34; }
        @media (max-width: 768px) { .signup-container { margin: 50px auto; padding: 1.5rem; } }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?php echo htmlspecialchars($basePath); ?>/">AI Forum</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="<?php echo htmlspecialchars($basePath); ?>/" class="btn btn-primary me-2">Back to Home</a>
                    </li>
                    <li class="nav-item">
                        <span class="text-white ms-2 dark-mode-toggle" onclick="toggleDarkMode()">
                            <i class="fas fa-moon"></i>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="signup-container">
        <h2 class="text-center mb-4">Join AI Forum</h2>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($error_message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php 
                echo htmlspecialchars($_SESSION['message']); 
                unset($_SESSION['message']); 
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="/AI_Forum_PHP_Project/public/signup" aria-label="Sign Up Form">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required placeholder="Choose a username">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required placeholder="Create a password">
                <div class="form-text">Use at least 8 characters with a mix of letters, numbers, and symbols.</div>
            </div>
            <button type="submit" class="btn btn-success w-100" aria-label="Sign Up">Sign Up</button>
        </form>
        <p class="text-center mt-3">Already have an account? <a href="<?php echo htmlspecialchars($basePath . '/login'); ?>">Login</a></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleDarkMode() {
            document.body.classList.toggle('bg-dark');
            document.body.classList.toggle('text-white');
            const containers = document.querySelectorAll('.login-container, .signup-container');
            containers.forEach(container => {
                container.classList.toggle('bg-dark');
                container.classList.toggle('text-white');
            });
        }
    </script>
</body>
</html>