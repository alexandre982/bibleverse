<?php
namespace Core;

class Router
{
    public static function parse(string $route): void
    {
        switch ($route) {
            case 'inscription':
                (new \App\Controllers\AuthController())->register();
                break;

            case 'connexion':
                (new \App\Controllers\AuthController())->login();
                break;

            case 'verset-du-jour':
                (new \App\Controllers\VerseController())->show();
                break;

            case 'loue-temoigne':
                (new \App\Controllers\AuthController())->loueTemoigne();
                break;

            case 'favoris':
                (new \App\Controllers\FavorisController())->liste();
                break;

            case 'ajouter-favori':
                (new \App\Controllers\FavorisController())->ajouter();
                break;

            case 'deconnexion':
                session_start();
                session_destroy();
                header('Location: ?route=connexion');
                exit;

            default:
                (new \App\Controllers\VerseController())->show();
                break;
        }
    }
}
