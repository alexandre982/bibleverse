<?php
namespace App\Controllers;

use App\Models\Publication;

class PraiseTestimonyController extends AbstractController
{
    private Publication $publicationModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->publicationModel = new Publication();
    }

    public function showForm(): void
    {
        if (!isset($_SESSION['user']['id'])) {
            $this->redirect('connexion');
            return;
        }

        $this->render('praise-testimony/post.php', [
            'pageTitle' => 'Loue & Témoigne',
            'errors'    => [],
            'old'       => []
        ]);
    }

    public function submit(): void
    {
        if (!isset($_SESSION['user']['id'])) {
            $this->redirect('connexion');
            return;
        }

        $errors  = [];
        $type    = $_POST['type']    ?? '';
        $content = $_POST['content'] ?? '';
        $color   = $_POST['color']   ?? '';

        if (!in_array($type, ['praise', 'testimony'])) {
            $errors[] = 'Type invalide.';
        }
        if (trim($content) === '') {
            $errors[] = 'Le contenu est obligatoire.';
        }
        if (!in_array($color, ['red', 'green', 'blue', 'violet', 'indigo', 'darkbrown'])) {
            $errors[] = 'Couleur invalide.';
        }

        if (empty($errors)) {
            $success = $this->publicationModel->create([
                'user_id' => $_SESSION['user']['id'],
                'type'    => $type,
                'content' => $content
            ]);

            if ($success) {
                $_SESSION['flash'] = 'Publication envoyée pour validation.';
                $_SESSION['highlightColor'] = $color;
                $this->redirect('fil-actualite');
                return;
            } else {
                $errors[] = "Erreur lors de l'enregistrement.";
            }
        }

        $this->render('praise-testimony/post.php', [
            'pageTitle' => 'Loue & Témoigne',
            'errors'    => $errors,
            'old'       => $_POST
        ]);
    }

    public function showFeed(): void
    {
        $publications = $this->publicationModel->getValidated();
        $highlightColor = $_SESSION['highlightColor'] ?? null;
        unset($_SESSION['highlightColor']);

        $this->render('praise-testimony/feed.php', [
            'pageTitle'      => 'Fil d’actualité',
            'publications'   => $publications,
            'highlightColor' => $highlightColor
        ]);
    }
}
