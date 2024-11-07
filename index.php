<?php


$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = ltrim($path, '/');

$routes = include "Routing/routes.php";


$routes[$path]();

