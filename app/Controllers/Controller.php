<?php
namespace App\Controllers;

class Controller {
    public function view($view, $data = []) {
        $viewFile = __DIR__ . "/../Views/{$view}.tpl";

        if (file_exists($viewFile)) {
            extract($data);

            if (isset($_SESSION['success_message'])) {
                $data['success_message'] = $_SESSION['success_message'];
                unset($_SESSION['success_message']);
            }

            if (isset($_SESSION['error_message'])) {
                $data['error_message'] = $_SESSION['error_message'];
                unset($_SESSION['error_message']);
            }

            require_once $viewFile;
        } else {
            echo "View file {$view}.tpl not found!";
        }
    }

    protected function forbidden() {
        http_response_code(403);
        $_SESSION['error_message'] = '403 Forbidden - You don\'t have permission to access this resource';
        $this->redirect('/AI_Forum_PHP_Project/public/');
        exit;
    }

    protected function redirect($url) {
        header("Location: $url");
        exit;
    }

    protected function notFound() {
        http_response_code(404);
        $_SESSION['error_message'] = '404 Not Found - The requested resource doesnt exist';
        $this->redirect('/AI_Forum_PHP_Project/public/');
        exit;
    }

    protected function requireLogin() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login.php');
        }
    }

    protected function requireAdmin() {
        if (!($_SESSION['is_admin'] ?? false)) {
            $this->forbidden();
        }
    }
}