<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post;

class HomeController extends Controller {
    public function index() {
        $search = $_GET['search'] ?? '';
        $postModel = new Post();
        $posts = $postModel->searchPosts($search);
        
        $is_logged_in = isset($_SESSION['user_id']);
        $is_admin = $_SESSION['is_admin'] ?? false;

        $this->view('posts/index', [
            'posts' => $posts,
            'is_logged_in' => $is_logged_in,
            'is_admin' => $is_admin,
            'search' => $search
        ]);
    }
}