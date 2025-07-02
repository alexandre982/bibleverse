<?php
declare(strict_types=1);


require_once __DIR__ . '/../vendor/autoload.php';

use Core\Router;

$route = $_GET['route'] ?? '';
Router::parse($route);

