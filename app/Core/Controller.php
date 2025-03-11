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
}
