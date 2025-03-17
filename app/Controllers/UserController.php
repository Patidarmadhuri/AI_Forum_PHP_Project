<?php
namespace App\Controllers;

ob_start();

use App\Models\User;

class UserController extends Controller {
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function signup() {
        $data = ['basePath' => '/AI_Forum_PHP_Project/public'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim(filter_var($_POST['username'] ?? '', FILTER_SANITIZE_STRING));
            $email = trim(filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL));
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($email) || empty($password)) {
                $data['error_message'] = 'All fields are required.';
            } 
            elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $data['error_message'] = 'Invalid email format.';
            } 
            elseif (!$this->validatePassword($password)) {
                $data['error_message'] = 'Password must be at least 8 characters long and include uppercase letters, numbers, and special characters.';
            } else {
                $userModel = new User();
                $result = $userModel->register($username, $email, $password);

                if ($result === true) {
                    $_SESSION['message'] = 'Signup successful, please login.';
                    header("Location: /AI_Forum_PHP_Project/public/login");
                    exit;
                } elseif ($result === 'email_exists') {
                    $data['error_message'] = 'This email is already registered.';
                } else {
                    $data['error_message'] = 'Signup failed due to an unexpected error.';
                }
            }
        }

        $this->view('users/signup', $data);
    }

    private function validatePassword($password) {
        return strlen($password) >= 8 &&               
               preg_match('/[A-Z]/', $password) &&    
               preg_match('/[a-z]/', $password) &&    
               preg_match('/[0-9]/', $password) &&    
               preg_match('/[^a-zA-Z0-9]/', $password);
    }

    protected function redirect($url) {
        error_log("Redirecting to: $url");
        header("Location: $url");
        exit();
    }

    public function login() {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/AI_Forum_PHP_Project/public/');
        }

        $error_message = '';

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
                    $error_message = $result['message'];
                    session_write_close();
                }
            }
        }

        $this->view('users/login', [
            'basePath' => '/AI_Forum_PHP_Project/public',
            'error_message' => $error_message
        ]);
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        session_unset();
        session_destroy();
    
        $this->redirect('/AI_Forum_PHP_Project/public/');
    }
}