<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Chargement automatique via Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Récupération de la route
$route = $_GET['route'] ?? '';

// Lancement du routeur
\Core\Router::parse($route);
