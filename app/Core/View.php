<?php

namespace App\Core;

class View {
    // Method to render views with data
    public function render($view, $data = []) {
        // Extract data as variables to be available in the template
        extract($data);

        // Include the view file (make sure the path is correct)
        include __DIR__ . '/../Views/' . $view . '.tpl';
    }
}
