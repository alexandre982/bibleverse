<?php
namespace App\Controllers;

use App\Models\Favorites;
use App\Models\Verse;

class FavorisController extends AbstractController
{
    private Favorites $favModel;

    public function __construct()
    {
        if(session_status()===PHP_SESSION_NONE) session_start();
        $this->favModel = new Favorites();
    }

    public function liste(): void
    {
        if(!isset($_SESSION['user']['id'])) $this->redirect('connexion');

        $favs = $this->favModel->getByUserId((int)$_SESSION['user']['id']);
        $this->render('favorite/favorites.php',[
            'pageTitle'=>'Mes Favoris',
            'favorites'=> $favs
        ]);
    }

    public function ajouter(): void
    {
        if(!isset($_SESSION['user']['id'])) $this->redirect('connexion');

        $userId=(int)$_SESSION['user']['id'];
        $verseId=(int)($_POST['verse_id']??0);

        if($verseId<=0){
            $_SESSION['flash']="Verse invalide.";
        }
        else if($this->favModel->exists($userId,$verseId)){
            $_SESSION['flash']="Verset déjà en favoris.";
        }
        else{
            $this->favModel->add($userId,$verseId);
            $_SESSION['flash']="Verset ajouté aux favoris.";
        }

        $this->redirect('verset-du-jour');
    }

    public function supprimer(): void
    {
        if(!isset($_SESSION['user']['id'])) $this->redirect('connexion');

        $favId=(int)($_POST['favorite_id']??0);
        if($favId>0){
            $this->favModel->remove($favId);
            $_SESSION['flash']="Favori supprimé.";
        } else {
            $_SESSION['flash']="Impossible de supprimer.";
        }
        $this->redirect('favoris');
    }
}
