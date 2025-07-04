<?php
namespace Core;

use App\Controllers\AuthController;
use App\Controllers\VerseController;
use App\Controllers\PraiseTestimonyController;
use App\Controllers\FavorisController;
use App\Controllers\AdminDashboardController;

class Router
{
    public static function parse(string $route): void
    {
        switch ($route) {
            case 'inscription':
                (new AuthController())->register(); break;
            case 'connexion':
                (new AuthController())->login(); break;
            case 'verset-du-jour':
                (new VerseController())->show(); break;
            case 'loue-temoigne':
                (new PraiseTestimonyController())->showForm(); break;
            case 'envoyer-loue-temoigne':
                (new PraiseTestimonyController())->submit(); break;
            case 'fil-actualite':
                (new PraiseTestimonyController())->showFeed(); break;
            case 'favoris':
                (new FavorisController())->liste(); break;
            case 'ajouter-favori':
                (new FavorisController())->ajouter(); break;
            case 'supprimer-favori':
                (new FavorisController())->supprimer(); break;
            case 'admin':
            case 'dashboard':
                (new AdminDashboardController())->index(); break;
            case 'valider-publication':
                (new AdminDashboardController())->validatePublication(); break;
            case 'supprimer-publication':
                (new AdminDashboardController())->deletePublication(); break;
            case 'modifier-publication':
                (new AdminDashboardController())->updatePublication(); break;
            case 'deconnexion':
                if (session_status()===PHP_SESSION_NONE) session_start();
                session_destroy();
                header('Location:?route=connexion'); exit;
            default:
                (new VerseController())->show(); break;
        }
    }
}
