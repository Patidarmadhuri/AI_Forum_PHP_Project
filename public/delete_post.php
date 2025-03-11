<?php
session_start();
require_once __DIR__ . '/../app/Models/Post.php';
require_once __DIR__ . '/../includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$postId = $_GET['id'] ?? null;
if (!$postId) {
    header("Location: index.php");
    exit;
}

$postModel = new App\Models\Post();
$post = $postModel->getPostById($postId);

if (!$post || ($_SESSION['user_id'] != $post['user_id'] && !($_SESSION['is_admin'] ?? false))) {
    die("Unauthorized access!");
}

$postModel->deletePost($postId);
header("Location: index.php");
exit;
?>