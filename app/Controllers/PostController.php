<?php
namespace App\Controllers;

use App\Models\Post;

class PostController extends Controller {
    public function __construct() {
    }

    public function index() {
        $postModel = new Post();
        $search    = $_GET['search'] ?? '';
        $posts     = $search ? $postModel->searchPosts($search) : $postModel->getAllPosts();

        if (empty($posts)) {
            $_SESSION['message'] = 'No posts found matching your search.';
        }

        $this->view('posts/index', [
            'posts'        => $posts,
            'search'       => htmlspecialchars($search),
            'is_logged_in' => isset($_SESSION['user_id']),
            'is_admin'     => $_SESSION['is_admin'] ?? false,
            'basePath'     => BASE_PATH,
            'current_page' => 'home'
        ]);
    }

    public function displayPost($id) {
        $postModel = new Post();
        $post      = $postModel->getPostById($id);

        if (!$post) {
            $this->renderError(404, 'Post not found');
            return;
        }

        $this->view('posts/view', [
            'post'         => $post,
            'is_logged_in' => isset($_SESSION['user_id']),
            'is_admin'     => $_SESSION['is_admin'] ?? false,
            'basePath'     => BASE_PATH
        ]);
    }

    public function createPostForm() {
        $this->ensureLoggedIn();

        $this->view('posts/create', [
            'basePath' => BASE_PATH,
            'is_admin' => $_SESSION['is_admin'] ?? false,
            'title'    => '',
            'content'  => '',
            'errors'   => []
        ]);
    }

    public function create() {
        $this->ensureLoggedIn();

        $title   = '';
        $content = '';
        $errors  = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title   = trim($_POST['title']);
            $content = trim($_POST['content']);
            $user_id = $_SESSION['user_id'];

            $errors = $this->validatePostData($title, $content);
            if (empty($errors)) {
                $postModel = new Post();

                try {
                    if ($postModel->createPost($user_id, $title, $content)) {
                        $_SESSION['message'] = 'Post created successfully';
                        $this->redirect(BASE_PATH . '/');
                    } else {
                        $errors[] = 'Failed to create post';
                    }
                } catch (\Exception $e) {
                    $errors[] = $e->getMessage();
                }
            }
        }

        $this->view('posts/create', [
            'basePath' => BASE_PATH,
            'is_admin' => $_SESSION['is_admin'] ?? false,
            'title'    => htmlspecialchars($title),
            'content'  => htmlspecialchars($content),
            'errors'   => $errors
        ]);
    }

    public function editPostForm($id) {
        $this->ensureLoggedIn();

        $postModel = new Post();
        $post      = $postModel->getPostById($id);

        $this->authorizeUser($post['user_id'], $_SESSION['is_admin'] ?? false);

        $this->view('posts/edit', [
            'post'     => $post,
            'basePath' => BASE_PATH,
            'errors'   => []
        ]);
    }

    public function update($id) {
        $this->ensureLoggedIn();

        $postModel = new Post();
        $post      = $postModel->getPostById($id);

        $this->authorizeUser($post['user_id'], $_SESSION['is_admin'] ?? false);

        $title   = trim($_POST['title']);
        $content = trim($_POST['content']);

        $errors = $this->validatePostData($title, $content);
        if (!empty($errors)) {
            $this->view('posts/edit', [
                'post'     => $post,
                'basePath' => BASE_PATH,
                'errors'   => $errors
            ]);
            return;
        }

        try {
            if ($postModel->updatePost($id, $title, $content)) {
                $_SESSION['message'] = 'Post updated successfully';
                $this->redirect(BASE_PATH . '/');
            } else {
                $_SESSION['error_message'] = 'Failed to update post';
                $this->redirect(BASE_PATH . '/post/edit/' . $id);
            }
        } catch (\Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            $this->redirect(BASE_PATH . '/post/edit/' . $id);
        }
    }

    public function confirmDelete($id) {
        $this->ensureLoggedIn();

        $postModel = new Post();
        $post      = $postModel->getPostById($id);

        $this->authorizeUser($post['user_id'], $_SESSION['is_admin'] ?? false);

        $this->view('posts/confirm_delete', [
            'post'     => $post,
            'basePath' => BASE_PATH,
        ]);
    }

    public function delete($id) {
        $this->ensureLoggedIn();

        $postModel = new Post();
        $post      = $postModel->getPostById($id);

        $this->authorizeUser($post['user_id'], $_SESSION['is_admin'] ?? false);

        try {
            if ($postModel->deletePost($id)) {
                $_SESSION['message'] = 'Post deleted successfully';
            } else {
                $_SESSION['error_message'] = 'Failed to delete post';
            }
        } catch (\Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
        }

        $this->redirect(BASE_PATH . '/');
    }

    private function validatePostData($title, $content) {
        $errors = [];
        if (empty(trim($title))) {
            $errors[] = 'Title is required.';
        }
        if (empty(trim($content))) {
            $errors[] = 'Content is required.';
        }
        return $errors;
    }

    protected function ensureLoggedIn() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
            $this->redirect(BASE_PATH . '/login');
        }
    }

    protected function authorizeUser($userId, $isAdmin = false) {
        if ($userId != $_SESSION['user_id'] && !$isAdmin) {
            $_SESSION['error_message'] = 'Unauthorized';
            $this->redirect(BASE_PATH . '/');
        }
    }

    protected function renderError($code, $message) {
        http_response_code($code);
        $this->view('errors/404', [
            'message'  => $message,
            'basePath' => BASE_PATH
        ]);
        exit;
    }
}