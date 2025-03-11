<?php

namespace App\Core;

class Controller {


    
    // Render a view template with the given data
    public function view($view, $data = []) {
        // Check if the view file exists
        $viewFile = __DIR__ . "/../Views/{$view}.tpl";

        if (file_exists($viewFile)) {
            // Extract data to variables
            extract($data);

            // Pass session messages automatically to the view and unset them after displaying
            if (isset($_SESSION['success_message'])) {
                $data['success_message'] = $_SESSION['success_message'];
                unset($_SESSION['success_message']); // Clear the message after it's passed to the view
            }

            if (isset($_SESSION['error_message'])) {
                $data['error_message'] = $_SESSION['error_message'];
                unset($_SESSION['error_message']); // Clear the message after it's passed to the view
            }

            // Include the view template
            require_once $viewFile;
        } else {
            echo "View file {$view}.tpl not found!";
        }
    }
    protected function forbidden() {
        http_response_code(403);
        echo "403 Forbidden - You don't have permission to access this resource";
        exit;
    }
    protected function redirect($url) {
        header("Location: $url");
        exit;
    }
    protected function notFound() {
        http_response_code(404);
        echo "404 Not Found - The requested resource doesn't exist";
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

