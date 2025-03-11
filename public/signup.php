<?php
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    $mysqli = new mysqli('localhost', 'root', '', 'forum_db');

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Prepare SQL query to check if email already exists
    $stmt = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $_SESSION['error_message'] = 'Email is already registered.';
    } else {
        // Prepare SQL query to insert new user
        $stmt = $mysqli->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = 'Account created successfully! Please log in.';
            header('Location: /AI_Forum_PHP_Project/public/login.php');
            exit();
        } else {
            $_SESSION['error_message'] = 'Something went wrong. Please try again.';
        }
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
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <h2>Sign Up</h2>

        <!-- Display error message if any -->
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error_message']; ?>
                <?php unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>

        <!-- Display success message if any -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success_message']; ?>
                <?php unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>

        <div class="mt-3">
            <p>Already have an account? <a href="/AI_Forum_PHP_Project/public/login.php">Login</a></p>
        </div>
    </div>

</body>
</html>
