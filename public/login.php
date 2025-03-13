<?php
session_start();

// Redirect to posts page if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: /AI_Forum_PHP_Project/public/posts.php'); // Update this to match the correct page
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    $mysqli = new mysqli('localhost', 'root', '', 'forum_db');

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL query to check user
    $stmt = $mysqli->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    // If email exists, verify the password
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();
        
        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Set session variables
            $_SESSION['user_id'] = $user_id;
            header('Location: /AI_Forum_PHP_Project/public/posts.php'); // Redirect to posts page
            exit();
        } else {
            $_SESSION['error_message'] = 'Incorrect password.';
        }
    } else {
        $_SESSION['error_message'] = 'No user found with that email address.';
    }
    
    $stmt->close();
    $mysqli->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <h2>Login</h2>

        <!-- Display error message if any -->
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error_message']; ?>
                <?php unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>

        <div class="mt-3">
            <p>Don't have an account? <a href="/AI_Forum_PHP_Project/public/signup.php">Sign Up</a></p>
        </div>
    </div>

</body>
</html>
