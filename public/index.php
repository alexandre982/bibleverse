<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Chargement automatique des classes via Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Récupération de la route dans l’URL, ex: ?route=connexion
$route = $_GET['route'] ?? '';

// Lancement du routeur qui va charger le contrôleur approprié
\Core\Router::parse($route);
