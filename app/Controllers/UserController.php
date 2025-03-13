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
        
        $error_message = ''; // Local variable to pass to view
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error_message'] = 'Invalid email format';
                $error_message = 'Invalid email format';
            } else {
                $userModel = new User();
                $result = $userModel->login($email, $password);
                
                if ($result['success']) {
                    $_SESSION['user_id'] = $result['user']['id'];
                    $_SESSION['username'] = $result['user']['username'];
                    $_SESSION['is_admin'] = (int) $result['user']['is_admin'];
                    $this->redirect('/AI_Forum_PHP_Project/public/');
                } else {
                    $_SESSION['error_message'] = $result['message'];
                    $error_message = $result['message']; // Set local variable
                    session_write_close(); // Ensure session is saved
                }
            }
        }
        
        $this->view('users/login', [
            'basePath' => '/AI_Forum_PHP_Project/public',
            'error_message' => $error_message // Pass to view
        ]);
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        $this->redirect('/AI_Forum_PHP_Project/public/');
    }

    protected function redirect($url) {
        header("Location: $url");
        exit();
    }
}