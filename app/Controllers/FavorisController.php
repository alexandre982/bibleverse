<?php
namespace App\Controllers;

use App\Models\Favori;

class FavorisController extends AbstractController
{
    protected Favori $favoriModel;

    public function __construct()
    {
        $this->favoriModel = new Favori();
    }

    public function liste(): void
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('connexion');
            return;
        }

        $userId = $_SESSION['user']['id'];
        $favorites = $this->favoriModel->findByUserIdWithVerse($userId);

        $this->render('favoris/liste.php', [
            'pageTitle' => 'Mes Favoris',
            'favorites' => $favorites,
        ]);
    }

    public function ajouter(): void
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('connexion');
            return;
        }

        $verseId = $_POST['verse_id'] ?? null;
        $userId = $_SESSION['user']['id'];

        if ($verseId) {
            if (!$this->favoriModel->exists($userId, $verseId)) {
                $this->favoriModel->add($userId, $verseId);
                $_SESSION['flash'] = 'Verset ajouté aux favoris.';
            } else {
                $_SESSION['flash'] = 'Ce verset est déjà dans vos favoris.';
            }
        }

        $this->redirect('verset-du-jour');
    }
}
