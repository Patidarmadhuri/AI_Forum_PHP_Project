<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AI Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 2rem;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            background: white;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        .btn-primary {
            background: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background: #0056b3;
        }
        @media (max-width: 768px) {
            .login-container {
                margin: 50px auto;
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
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

    <!-- Login Form -->
    <div class="login-container">
        <h2 class="text-center mb-4">Login to AI Forum</h2>

        <!-- Messages -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (isset($error_message) && !empty($error_message)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($error_message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo htmlspecialchars($basePath . '/login'); ?>" aria-label="Login Form">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required placeholder="Enter your password">
                <div class="form-text"><a href="<?php echo htmlspecialchars($basePath . '/forgot-password'); ?>">Forgot Password?</a></div>
            </div>
            <button type="submit" class="btn btn-primary w-100" aria-label="Login">Login</button>
        </form>
        <p class="text-center mt-3">Don't have an account? <a href="<?php echo htmlspecialchars($basePath . '/signup'); ?>">Sign Up</a></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleDarkMode() {
    document.body.classList.toggle('bg-dark');
    document.body.classList.toggle('text-white');

    // Toggle dark mode for forms
    const containers = document.querySelectorAll('.login-container, .signup-container');
    containers.forEach(container => {
        container.classList.toggle('bg-dark');
        container.classList.toggle('text-white');
    });
}
    </script>
</body>
</html>