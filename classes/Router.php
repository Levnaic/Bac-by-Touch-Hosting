<?php

namespace BacByTouch;

use BacByTouch\ErrorHandler;

class Router
{
    protected $routes = [];
    protected $controllerPath;

    public function __construct($controllerPath)
    {
        $this->controllerPath = $controllerPath;
    }

    public function get($uri, $controller)
    {
        $this->routes[] = [
            "uri" => $uri,
            "controller" => $controller,
            "method" => "GET"
        ];
    }

    public function post($uri, $controller)
    {
        $this->routes[] = [
            "uri" => $uri,
            "controller" => $controller,
            "method" => "POST"
        ];
    }

    public function delete($uri, $controller)
    {
        $this->routes[] = [
            "uri" => $uri,
            "controller" => $controller,
            "method" => "DELETE"
        ];
    }

    public function patch($uri, $controller)
    {
        $this->routes[] = [
            "uri" => $uri,
            "controller" => $controller,
            "method" => "PATCH"
        ];
    }

    public function put($uri, $controller)
    {
        $this->routes[] = [
            "uri" => $uri,
            "controller" => $controller,
            "method" => "PUT"
        ];
    }

    public function route($uri, $method)
    {
        $method = strtoupper($method);
        if ($this->isValidMethod($method)) {
            foreach ($this->routes as $route) {
                if ($route["uri"] == $uri && $route["method"] === $method) {
                    $this->includeController($route['controller']);
                    return;
                }
            }
        }
        ErrorHandler::logError("HTTP status 404", "Page with url: $uri not found", __CLASS__, __LINE__);
        Redirect::redirectToErrorPage();
    }

    protected function addRoute($uri, $controller, $method)
    {
        $this->routes[] = [
            "uri" => $uri,
            "controller" => $controller,
            "method" => $method
        ];
    }

    protected function isValidMethod($method)
    {
        $validMethods = ["GET", "POST", "DELETE", "PATCH", "PUT"];
        return in_array($method, $validMethods);
    }

    protected function includeController($controller)
    {
        $controllerFile = $this->controllerPath . "/{$controller}.php";

        if (file_exists($controllerFile)) {
            require $controllerFile;
        } else {
            ErrorHandler::logError("HTTP status 500", "Controller: $controller not found", __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
    }
}
