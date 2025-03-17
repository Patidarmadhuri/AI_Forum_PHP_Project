<?php
namespace App\Core;

class Router {
    protected $routes = [
        'GET' => [
            '/' => 'PostController@index',
            '/post/(\d+)' => 'PostController@displayPost',
            '/login' => 'UserController@login',
            '/signup' => 'UserController@signup',
            '/admin/dashboard' => 'AdminController@dashboard',
            '/logout' => 'UserController@logout',
            '/post/create' => 'PostController@createPostForm',
            '/post/edit/(\d+)' => 'PostController@editPostForm',
            '/post/delete/(\d+)' => 'PostController@confirmDelete',
            '/admin/users' => 'AdminController@manageUsers',
            '/admin/users/create' => 'AdminController@createUserForm',
            '/admin/users/edit/(\d+)' => 'AdminController@editUserForm',
            '/admin/users/delete/(\d+)' => 'AdminController@deleteUser',
            '/admin/posts' => 'AdminController@managePosts',
        ],
        'POST' => [
            '/login' => 'UserController@login',
            '/signup' => 'UserController@signup',
            '/logout' => 'UserController@logout',
            '/post/create' => 'PostController@create',
            '/post/update/(\d+)' => 'PostController@update',
            '/post/delete/(\d+)' => 'PostController@delete',
            '/admin/users/create' => 'AdminController@createUser',
            '/admin/users/edit/(\d+)' => 'AdminController@updateUser',
            '/admin/posts/create' => 'AdminController@createPost',
            '/admin/posts/edit/(\d+)' => 'AdminController@updatePost',
            '/admin/posts/delete/(\d+)' => 'AdminController@deletePost',
        ],
    ];

    public function route($url) {
        $basePath = trim(dirname($_SERVER['SCRIPT_NAME']), '/');
        $requestUrl = isset($_GET['url']) ? '/' . trim($_GET['url'], '/') : trim(parse_url($url, PHP_URL_PATH), '/');
        
        if ($basePath && strpos($requestUrl, $basePath) === 0) {
            $requestUrl = substr($requestUrl, strlen($basePath));
            $requestUrl = trim($requestUrl, '/') ? '/' . trim($requestUrl, '/') : '/';
        }

        if ($requestUrl === '' || $requestUrl === '/index.php') {
            $requestUrl = '/';
        }

        $httpMethod = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$httpMethod])) {
            foreach ($this->routes[$httpMethod] as $pattern => $route) {
                $regexPattern = '@^' . preg_replace('/\\\d\+/', '(\d+)', $pattern) . '$@';

                if (preg_match($regexPattern, $requestUrl, $matches)) {
                    array_shift($matches);

                    list($controller, $method) = explode('@', $route);
                    $controllerClass = "App\\Controllers\\" . $controller;

                    if (class_exists($controllerClass)) {
                        $controllerInstance = new $controllerClass();

                        return call_user_func_array([$controllerInstance, $method], array_slice($matches, 1));
                    }
                }
            }
        }

        http_response_code(404);
        $filePath = __DIR__ . "/../../Views/errors/404.tpl";
        if (file_exists($filePath)) {
            include $filePath;
        } else {
            http_response_code(404);
            echo "<h1>404 - Page Not Found</h1>";
            echo "<p>The requested page could not be found.</p>";
            exit;
        }
        exit;
    }
}