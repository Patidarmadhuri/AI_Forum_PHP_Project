<?php
namespace App\Controllers;

use App\Models\Post;
use App\Core\Controller;

class PostController extends Controller {
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index() {
        $postModel = new Post();
        $search = $_GET['search'] ?? '';
        $posts = $search ? $postModel->searchPosts($search) : $postModel->getAllPosts();
        $this->view('posts/index', [
            'posts' => $posts,
            'search' => $search,
            'is_logged_in' => isset($_SESSION['user_id']),
            'is_admin' => $_SESSION['is_admin'] ?? false,
            'basePath' => '/AI_Forum_PHP_Project/public',
            'current_page' => 'home',
            'previous_url' => $_SERVER['REQUEST_URI']
        ]);
    }

    public function displayPost($id) {
        $postModel = new Post();
        $post = $postModel->getPostById($id);
        if (!$post) {
            http_response_code(404);
            echo "Post not found";
            return;
        }
        $this->view('posts/view', [
            'post' => $post,
            'is_logged_in' => isset($_SESSION['user_id']),
            'is_admin' => $_SESSION['is_admin'] ?? false,
            'basePath' => '/AI_Forum_PHP_Project/public'
        ]);
    }

    public function create() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/AI_Forum_PHP_Project/public/login');
        }
    
        $title = '';
        $content = '';
        $errors = [];
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
            $content = filter_var($_POST['content'], FILTER_SANITIZE_STRING);
            $user_id = $_SESSION['user_id'];
    
            $postModel = new Post();
            if ($postModel->createPost($user_id, $title, $content)) {
                $_SESSION['message'] = 'Post created successfully';
                $this->redirect('/AI_Forum_PHP_Project/public/');
            } else {
                $_SESSION['error_message'] = 'Failed to create post';
                $errors[] = 'Failed to create post';
            }
        }
    
        $this->view('posts/create', [
            'basePath' => '/AI_Forum_PHP_Project/public',
            'title' => $title,
            'content' => $content,
            'errors' => $errors
        ]);
    }

    public function edit($id) {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/AI_Forum_PHP_Project/public/login');
        }
        $postModel = new Post();
        $post = $postModel->getPostById($id);
        if (!$post || ($post['user_id'] != $_SESSION['user_id'] && !$_SESSION['is_admin'])) {
            $_SESSION['error_message'] = 'Unauthorized';
            $this->redirect('/AI_Forum_PHP_Project/public/');
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
            $content = filter_var($_POST['content'], FILTER_SANITIZE_STRING);
            if ($postModel->updatePost($id, $title, $content)) {
                $_SESSION['message'] = 'Post updated successfully';
                $this->redirect('/AI_Forum_PHP_Project/public/');
            } else {
                $_SESSION['error_message'] = 'Failed to update post';
            }
        }
    
        $this->view('posts/edit', [
            'post' => $post,
            'basePath' => '/AI_Forum_PHP_Project/public'
        ]);
    }

    public function delete($id) {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/AI_Forum_PHP_Project/public/login');
        }
        $postModel = new Post();
        $post = $postModel->getPostById($id);
        if (!$post || ($post['user_id'] != $_SESSION['user_id'] && !$_SESSION['is_admin'])) {
            $_SESSION['error_message'] = 'Unauthorized';
            $this->redirect('/AI_Forum_PHP_Project/public/');
        }
        if ($postModel->deletePost($id)) {
            $_SESSION['message'] = 'Post deleted successfully';
        } else {
            $_SESSION['error_message'] = 'Failed to delete post';
        }
        $this->redirect('/AI_Forum_PHP_Project/public/');
    }

    protected function redirect($url) {
        header("Location: $url");
        exit();
    }
}