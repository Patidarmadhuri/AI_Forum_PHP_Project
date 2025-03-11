<?php
namespace App\Controllers;

use App\Models\User;
use App\Core\Controller;

class UserController extends Controller {
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    public function signup() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
    
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error_message'] = 'Invalid email format';
            } else {
                $userModel = new User();
                if ($userModel->register($username, $email, $password)) {
                    $_SESSION['message'] = 'Signup successful, please login';
                    $this->redirect('/AI_Forum_PHP_Project/public/login');
                } else {
                    $_SESSION['error_message'] = 'Signup failed, email might already exist';
                }
            }
        }
    
        $this->view('users/signup', [
            'basePath' => '/AI_Forum_PHP_Project/public'
        ]);
    }

    public function login() {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/AI_Forum_PHP_Project/public/');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error_message'] = 'Invalid email format';
            } else {
                $userModel = new User();
                $user = $userModel->login($email, $password);
                if ($user) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['is_admin'] = (int) $user['is_admin'];
                    $this->redirect('/AI_Forum_PHP_Project/public/');
                } else {
                    $_SESSION['error_message'] = 'Invalid login credentials';
                }
            }
        }
        $this->view('users/login', [
            'basePath' => '/AI_Forum_PHP_Project/public'
        ]);
    }

    // Add this logout method
    public function logout() {
        session_start(); // Ensure session is active
        session_unset(); // Clear all session variables
        session_destroy(); // Destroy the session
        $this->redirect('/AI_Forum_PHP_Project/public/');
    }

    protected function redirect($url) {
        header("Location: $url");
        exit();
    }
}