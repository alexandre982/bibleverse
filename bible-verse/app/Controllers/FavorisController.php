<?php
namespace App\Controllers;

use App\Models\Favorites;
use App\Models\Verse;

class FavorisController extends AbstractController
{
    public function liste(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user']['id'])) {
            $this->redirect('connexion');
        }

        $favoritesModel = new Favorites();
        $favorites = $favoritesModel->getByUserId($_SESSION['user']['id']);

        $this->render('favorite/favorites.php', [
            'pageTitle' => 'Mes Favoris',
            'favorites' => $favorites
        ]);
    }

    public function ajouter(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $verseId = (int)($_POST['verse_id'] ?? 0);
        $userId = $_SESSION['user']['id'] ?? null;

        if ($userId && $verseId > 0) {
            // Vérifie que le verset existe
            $verseModel = new Verse();
            $verse = $verseModel->getById($verseId);

            if ($verse) {
                $favoritesModel = new Favorites();
                $favoritesModel->add($userId, $verseId);
                $_SESSION['flash'] = "Verset ajouté aux favoris.";
            } else {
                $_SESSION['flash'] = "Verset invalide.";
            }
        } else {
            $_SESSION['flash'] = "Données invalides.";
        }

        header("Location: ?route=verset-du-jour");
        exit;
    }

    public function supprimer(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $id = $_GET['id'] ?? null;
        $userId = $_SESSION['user']['id'] ?? null;

        if ($id && $userId) {
            $favoritesModel = new Favorites();
            $favoritesModel->remove($userId, (int)$id);
            $_SESSION['flash'] = "Favori supprimé.";
        }
        $this->redirect('favoris');
    }

    public function modifier(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['verse_id'])) {
            $favoritesModel = new Favorites();
            $favoritesModel->update((int)$_POST['id'], (int)$_POST['verse_id']);
            $_SESSION['flash'] = "Favori modifié.";
        }
        $this->redirect('favoris');
    }
}
