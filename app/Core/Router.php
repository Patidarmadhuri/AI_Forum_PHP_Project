<?php
namespace App\Core;

class Router {
    protected $routes = [
        '/' => 'PostController@index',
        '/post/(\d+)' => 'PostController@displayPost',
        '/post/edit/(\d+)' => 'PostController@edit',
        '/login' => 'UserController@login',
        '/signup' => 'UserController@signup',
        '/logout' => 'UserController@logout',
        '/post/create' => 'PostController@create',
        '/post/update' => 'PostController@update',
        '/post/delete/(\d+)' => 'PostController@delete',
        '/admin/dashboard' => 'AdminController@dashboard',
        '/admin/users' => 'AdminController@manageUsers',
        '/admin/users/create' => 'AdminController@createUser',
        '/admin/users/edit/(\d+)' => 'AdminController@editUser',
        '/admin/users/delete/(\d+)' => 'AdminController@deleteUser',
        '/admin/posts' => 'AdminController@managePosts',
        '/admin/posts/delete/(\d+)' => 'AdminController@deletePost',
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

        foreach ($this->routes as $pattern => $route) {
            $pattern = '@^' . preg_replace('/\\\d\+/', '(\d+)', $pattern) . '$@';
            if (preg_match($pattern, $requestUrl, $matches)) {
                array_shift($matches);
                list($controller, $method) = explode('@', $route);
                $controllerClass = "App\\Controllers\\" . $controller;
                if (class_exists($controllerClass)) {
                    $controllerInstance = new $controllerClass();
                    return call_user_func_array([$controllerInstance, $method], $matches);
                }
            }
        }
        http_response_code(404);
        echo "404 - Page not found";
    }
}