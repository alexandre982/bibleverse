<?php

namespace App\Controllers;

use App\Models\Publication;
use App\Models\User;
use App\Models\Favorites;

class AdminDashboardController extends AbstractController
{
    public function index(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $this->redirect('connexion');
        }

        $publicationModel = new Publication();
        $userCount = (new User())->countAll();
        $favoriCount = (new Favorites())->countAll();
        $publicationCount = $publicationModel->countAll();
        $pending = $publicationModel->getPending();

        $this->render('admin/dashboard.php', [
            'pageTitle' => 'Dashboard Admin',
            'userCount' => $userCount,
            'favoriCount' => $favoriCount,
            'publicationCount' => $publicationCount,
            'pending' => $pending
        ]);
    }

    public function validatePublication(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $this->redirect('connexion');
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            $publicationModel = new Publication();
            $publicationModel->validate((int)$id);
        }

        $this->redirect('dashboard');
    }

    public function deletePublication(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $this->redirect('connexion');
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            $publicationModel = new Publication();
            $publicationModel->delete((int)$id);
        }

        $this->redirect('dashboard');
    }

    public function updatePublication(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $this->redirect('connexion');
        }

        $id = $_POST['id'] ?? null;
        $content = $_POST['content'] ?? null;
        if ($id && $content) {
            $publicationModel = new Publication();
            $publicationModel->update((int)$id, ['content' => $content]);
        }

        $this->redirect('dashboard');
    }
}
