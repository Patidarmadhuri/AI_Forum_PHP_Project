<?php
namespace App\Controllers;

use App\Models\User;
use App\Models\Post;

class AdminController extends Controller {
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    protected function requireAdmin() {
        if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
            $this->redirect('/AI_Forum_PHP_Project/public/');
        }
    }

    public function dashboard() {
        $this->requireAdmin();
        $this->view('admin/dashboard', [
            'basePath' => '/AI_Forum_PHP_Project/public'
        ]);
    }

    public function manageUsers() {
        $this->requireAdmin();
        $userModel = new User();
        $users     = $userModel->getAllUsers();
        $this->view('admin/users', [
            'users'    => $users,
            'basePath' => '/AI_Forum_PHP_Project/public'
        ]);
    }

    public function createUser() {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email    = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';
            $is_admin = isset($_POST['is_admin']) ? 1 : 0;

            $userModel = new User();
            if ($userModel->register($username, $email, $password, $is_admin)) {
                $_SESSION['message'] = 'User created successfully!';
                $this->redirect('/AI_Forum_PHP_Project/public/admin/users');
            } else {
                $_SESSION['error_message'] = 'Error creating user.';
            }
        }
        $this->view('admin/create_user', [
            'basePath' => '/AI_Forum_PHP_Project/public'
        ]);
    }

    public function createUserForm() {
        $this->requireAdmin();
        $this->view('admin/create_user', [
            'basePath' => '/AI_Forum_PHP_Project/public',
            'errors'   => []
        ]);
    }

    public function editUserForm($userId) {
        $this->requireAdmin();
        $userModel = new User();
        $user      = $userModel->getUserById($userId);

        if (!$user) {
            $this->notFound();
        }

        $this->view('admin/edit_user', [
            'user'     => $user,
            'basePath' => '/AI_Forum_PHP_Project/public'
        ]);
    }

    public function editUser($userId) {
        $this->requireAdmin();
        $userModel = new User();
        $user      = $userModel->getUserById($userId);
        if (!$user) return $this->notFound();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email    = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
            $is_admin = isset($_POST['is_admin']) ? 1 : 0;

            if ($userModel->updateUser($userId, $username, $email, $is_admin)) {
                $_SESSION['message'] = 'User updated successfully!';
                $this->redirect('/AI_Forum_PHP_Project/public/admin/users');
            } else {
                $_SESSION['error_message'] = 'Error updating user.';
            }
        }

        $this->view('admin/edit_user', [
            'user'     => $user,
            'basePath' => '/AI_Forum_PHP_Project/public'
        ]);
    }

    public function deleteUser($userId) {
        $this->requireAdmin();

        $userModel = new User();

        if ($userId == $_SESSION['user_id']) {
            $_SESSION['error_message'] = 'Cannot delete yourself.';
            $this->redirect('/AI_Forum_PHP_Project/public/admin/users');
        }

        if ($userModel->deleteUser($userId)) {
            $_SESSION['message'] = 'User deleted successfully.';
        } else {
            $_SESSION['error_message'] = 'Failed to delete user.';
        }

        $this->redirect('/AI_Forum_PHP_Project/public/admin/users');
    }

    public function managePosts() {
        if (!isset($_SESSION['user_id']) || !($_SESSION['is_admin'] ?? false)) {
            $_SESSION['error_message'] = 'Unauthorized';
            $this->redirect('/AI_Forum_PHP_Project/public/');
        }

        $postModel = new Post();
        $posts     = $postModel->getAllPosts();

        $this->view('admin/manage_posts', [
            'posts'    => $posts,
            'basePath' => '/AI_Forum_PHP_Project/public',
        ]);
    }

    public function createPostForm() {
        $this->requireAdmin();
        $this->view('admin/create_post', [
            'basePath' => '/AI_Forum_PHP_Project/public'
        ]);
    }

    public function createPost() {
        $this->requireAdmin();

        $user_id = $_SESSION['user_id'];
        $title   = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');

        if (empty($title) || empty($content)) {
            $_SESSION['error_message'] = 'Title and content are required.';
            $this->redirect('/AI_Forum_PHP_Project/public/admin/posts/create');
        }

        $postModel = new Post();
        if ($postModel->createPost($user_id, $title, $content)) {
            $_SESSION['message'] = 'Post created successfully.';
            $this->redirect('/AI_Forum_PHP_Project/public/admin/posts');
        } else {
            $_SESSION['error_message'] = 'Failed to create post.';
            $this->redirect('/AI_Forum_PHP_Project/public/admin/posts/create');
        }
    }

    public function editPostForm($postId) {
        $this->requireAdmin();
        $postModel = new Post();
        $post      = $postModel->getPostById($postId);

        if (!$post) {
            $this->notFound();
        }

        $this->view('admin/edit_post', [
            'post'     => $post,
            'basePath' => '/AI_Forum_PHP_Project/public'
        ]);
    }

    public function updatePost($postId) {
        $this->requireAdmin();

        $title   = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');

        if (empty($title) || empty($content)) {
            $_SESSION['error_message'] = 'Title and content are required.';
            $this->redirect("/AI_Forum_PHP_Project/public/admin/posts/edit/$postId");
        }

        $postModel = new Post();
        if ($postModel->updatePost($postId, $title, $content)) {
            $_SESSION['message'] = 'Post updated successfully.';
            $this->redirect('/AI_Forum_PHP_Project/public/admin/posts');
        } else {
            $_SESSION['error_message'] = 'Failed to update post.';
            $this->redirect("/AI_Forum_PHP_Project/public/admin/posts/edit/$postId");
        }
    }

    public function deletePost($postId) {
        $this->requireAdmin();
        $postModel = new Post();
        $post      = $postModel->getPostById($postId);
        if (!$post) {
            $_SESSION['error_message'] = 'Post not found';
            $this->redirect('/AI_Forum_PHP_Project/public/admin/posts');
        }

        $postModel->deletePost($postId);
        $_SESSION['message'] = 'Post deleted';
        $this->redirect('/AI_Forum_PHP_Project/public/admin/posts');
    }

    public function updateUser($userId) {
        $this->requireAdmin();

        $username = trim($_POST['username'] ?? '');
        $email    = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $is_admin = isset($_POST['is_admin']) ? 1 : 0;

        if (empty($username) || empty($email)) {
            $_SESSION['error_message'] = 'Username and email are required.';
            $this->redirect("/AI_Forum_PHP_Project/public/admin/users/edit/$userId");
        }

        $userModel = new User();
        if ($userModel->updateUser($userId, $username, $email, $is_admin)) {
            $_SESSION['message'] = 'User updated successfully.';
            $this->redirect('/AI_Forum_PHP_Project/public/admin/users');
        } else {
            $_SESSION['error_message'] = 'Failed to update user.';
            $this->redirect("/AI_Forum_PHP_Project/public/admin/users/edit/$userId");
        }
    }

    protected function redirect($url) {
        header("Location: $url");
        exit;
    }

    protected function notFound() {
        http_response_code(404);
        $_SESSION['error_message'] = '404 - Page not found';
        $this->redirect('/AI_Forum_PHP_Project/public/');
        exit;
    }
}