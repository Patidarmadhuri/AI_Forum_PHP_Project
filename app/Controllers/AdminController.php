<?php
namespace App\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Core\Controller;

class AdminController extends Controller {
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Helper method to check admin status
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

    // Your manageUsers() method
    public function manageUsers() {
        $this->requireAdmin();
        $userModel = new User();
        $users = $userModel->getAllUsers();
        $this->view('admin/users', [
            'users' => $users,
            'basePath' => '/AI_Forum_PHP_Project/public'
        ]);
    }

    public function createUser() {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
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

    public function editUser($userId) {
        $this->requireAdmin();
        $userModel = new User();
        $user = $userModel->getUserById($userId);
        if (!$user) return $this->notFound();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
            $is_admin = isset($_POST['is_admin']) ? 1 : 0;

            if ($userModel->updateUser($userId, $username, $email, $is_admin)) {
                $_SESSION['message'] = 'User updated successfully!';
                $this->redirect('/AI_Forum_PHP_Project/public/admin/users');
            } else {
                $_SESSION['error_message'] = 'Error updating user.';
            }
        }

        $this->view('admin/edit_user', [
            'user' => $user,
            'basePath' => '/AI_Forum_PHP_Project/public'
        ]);
    }

    public function deleteUser($userId) {
        $this->requireAdmin();
        $userModel = new User();
        if ($userId == $_SESSION['user_id']) {
            $_SESSION['error_message'] = 'Cannot delete yourself';
        } else {
            $userModel->deleteUser($userId);
            $_SESSION['message'] = 'User deleted successfully';
        }
        $this->redirect('/AI_Forum_PHP_Project/public/admin/users');
    }

    // Your managePosts() method
    public function managePosts() {
        $this->requireAdmin();
        $postModel = new Post();
        $posts = $postModel->getAllPosts();
        $this->view('admin/posts', [
            'posts' => $posts,
            'basePath' => '/AI_Forum_PHP_Project/public'
        ]);
    }

    public function deletePost($postId) {
        $this->requireAdmin();
        $postModel = new Post();
        $post = $postModel->getPostById($postId);
        if (!$post) {
            http_response_code(404);
            echo "Post not found";
            return;
        }
        $postModel->deletePost($postId);
        $_SESSION['message'] = 'Post deleted';
        $this->redirect('/AI_Forum_PHP_Project/public/admin/posts');
    }

    protected function redirect($url) {
        header("Location: $url");
        exit();
    }

    protected function notFound() {
        http_response_code(404);
        echo "404 - Page not found";
        exit();
    }
}