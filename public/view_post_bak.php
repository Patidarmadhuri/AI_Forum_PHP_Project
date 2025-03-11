<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

use App\Models\Post;

$postModel = new Post();
$post = $postModel->getPostById($_GET['id']);

if (!$post) {
    die("Post not found!");
}

$is_logged_in = isset($_SESSION['user_id']);
$is_admin = $_SESSION['is_admin'] ?? false;
$is_author = $is_logged_in && $_SESSION['user_id'] == $post['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($post['title']) ?></title>
    <!-- Include your CSS/JS here -->
</head>
<body>
    <h1><?= htmlspecialchars($post['title']) ?></h1>
    <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>

    <?php if ($is_logged_in && ($is_author || $is_admin)): ?>
        <div class="actions">
            <a href="/post/edit/<?= $post['id'] ?>" class="btn btn-warning">
                Edit
            </a>
            <a href="/post/delete/<?= $post['id'] ?>" 
               class="btn btn-danger"
               onclick="return confirm('Are you sure?')">
                Delete
            </a>
        </div>
    <?php endif; ?>
</body>
</html>