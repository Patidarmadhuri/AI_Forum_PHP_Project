<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AI Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .login-container { max-width: 400px; margin: 100px auto; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .form-control:focus { border-color: #007bff; box-shadow: 0 0 5px rgba(0,123,255,0.5); }
    </style>
</head>
<body class="bg-light">
    <div class="login-container bg-white rounded">
        <h2 class="text-center mb-4">Login to AI Forum</h2>
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($error_message) && !empty($error_message)): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="<?php echo htmlspecialchars($basePath . '/login'); ?>">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required placeholder="Enter your password">
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <p class="text-center mt-3">Don't have an account? <a href="<?php echo htmlspecialchars($basePath . '/signup'); ?>">Sign Up</a></p>
        <p class="text-center mt-2"><a href="<?php echo htmlspecialchars($basePath . '/'); ?>" class="btn btn-primary">Back to Home</a></p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>