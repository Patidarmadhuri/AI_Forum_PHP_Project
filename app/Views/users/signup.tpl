<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - AI Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .signup-container { max-width: 400px; margin: 100px auto; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .form-control:focus { border-color: #28a745; box-shadow: 0 0 5px rgba(40,167,69,0.5); }
    </style>
</head>
<body class="bg-light">
    <div class="signup-container bg-white rounded">
        <h2 class="text-center mb-4">Join AI Forum</h2>
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($_SESSION['error_message']); unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="<?php echo $basePath; ?>/signup">
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
            </div>
            <button type="submit" class="btn btn-success w-100">Sign Up</button>
        </form>
        <p class="text-center mt-3">Already have an account? <a href="<?php echo $basePath; ?>/login">Login</a></p>
        <p class="text-center mt-2"><a href="<?php echo $basePath; ?>/" class="btn btn-primary">Back to Home</a></p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>