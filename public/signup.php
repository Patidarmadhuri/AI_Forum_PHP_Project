<?php
session_start();

$mysqli = new mysqli('localhost', 'root', '', 'forum_db');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = 'Invalid email format.';
        header('Location: /AI_Forum_PHP_Project/public/signup.php');
        exit();
    }

    if (!validatePassword($password)) {
        $_SESSION['error_message'] = 'Password must be at least 8 characters long and include uppercase letters, numbers, and special characters.';
        header('Location: /AI_Forum_PHP_Project/public/signup.php');
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['error_message'] = 'Email is already registered.';
    } else {
        $stmt = $mysqli->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = 'Account created successfully! Please log in.';
            header('Location: /AI_Forum_PHP_Project/public/login.php');
            exit();
        } else {
            $_SESSION['error_message'] = 'An unexpected error occurred. Please try again.';
        }
    }

    $stmt->close();
    $mysqli->close();
}

function validatePassword($password) {
    return strlen($password) >= 8 &&
           preg_match('/[A-Z]/', $password) &&
           preg_match('/[a-z]/', $password) &&
           preg_match('/[0-9]/', $password) &&
           preg_match('/[^a-zA-Z0-9]/', $password);
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

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($_SESSION['error_message']); unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($_SESSION['success_message']); unset($_SESSION['success_message']); ?>
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
                <small class="form-text text-muted">
                    Use at least 8 characters with a mix of uppercase letters, lowercase letters, numbers, and special characters (e.g., @, #, $).
                </small>
            </div>
            <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>

        <div class="mt-3">
            <p>Already have an account? <a href="/AI_Forum_PHP_Project/public/login.php">Login</a></p>
        </div>
    </div>
</body>
</html>