<?php

namespace App\Controllers;

use App\Models\Publication;

class PraiseTestimonyController extends AbstractController
{
    public function showForm(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $this->render('praise-testimony/post.php', [
            'pageTitle' => 'Loue/Témoigne',
            'errors' => [],
            'old' => []
        ]);
    }

    public function submit(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $errors = [];
        $type = $_POST['type'] ?? '';
        $content = $_POST['content'] ?? '';
        $color = $_POST['color'] ?? '';

        $validTypes = ['praise', 'testimony'];
        $validColors = ['red', 'green', 'blue', 'violet', 'indigo', 'darkbrown'];

        if (!in_array($type, $validTypes)) {
            $errors[] = 'Type invalide.';
        }

        if (empty(trim($content))) {
            $errors[] = 'Le contenu est obligatoire.';
        }

        if (!in_array($color, $validColors)) {
            $errors[] = 'Couleur invalide.';
        }

        if (empty($errors) && isset($_SESSION['user']['id'])) {
            $publication = new Publication();

            $success = $publication->create([
                'user_id' => $_SESSION['user']['id'],
                'type' => $type,
                'content' => $content,
                'color' => $color
            ]);

            if ($success) {
                $_SESSION['flash'] = "Publication envoyée pour validation.";
                $this->redirect('loue-temoigne');
            } else {
                $errors[] = "Erreur lors de l'enregistrement.";
            }
        }

        $this->render('praise-testimony/post.php', [
            'pageTitle' => 'Loue/Témoigne',
            'errors' => $errors,
            'old' => $_POST
        ]);
    }

    public function showFeed(): void
    {
        $publicationModel = new Publication();
        $publications = $publicationModel->getValidated();

        $this->render('praise-testimony/feed.php', [
            'pageTitle' => 'Fil d’actualité',
            'publications' => $publications
        ]);
    }
}
