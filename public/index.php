<?php
require "../vendor/autoload.php";

use BacByTouch\Router;

// Debug::dd($databaseConfig);

// Specify the path to your controllers directory
$controllerPath = __DIR__ . "/../app/controllers";


$router = new Router($controllerPath);
$routes = require "../config/routes.php";

// get uri witouth query
$requestUri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

// get query string
$queryString = parse_url($_SERVER["REQUEST_URI"], PHP_URL_QUERY);
parse_str($queryString, $queryParams);

// parse uri to parameters
$uriParts = explode("/", trim($requestUri, '/'));

$controller = $uriParts[0] ?? "";
$action = $uriParts[1] ??  "";

// remove controller and action from uri
unset($uriParts[0], $uriParts[1]);


$parameters = array_values($uriParts);

$parameters = array_merge($parameters, $queryParams);

$method = $_POST["_method"] ?? $_SERVER["REQUEST_METHOD"];

$router->route($requestUri, $method);
