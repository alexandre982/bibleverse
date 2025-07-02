<?php
namespace App\Controllers;

use App\Models\User;
use App\Models\Favorites;
use App\Models\Publication;

class AdminDashboardController extends AbstractController
{
    public function index(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $this->redirect('connexion');
        }

        $userCount = (new User())->countAll();
        $favoriCount = (new Favorites())->countAll();
        $publicationCount = (new Publication())->countAll();
        $pending = (new Publication())->getPending();

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
        $id = (int) ($_GET['id'] ?? 0);
        if ($id) {
            (new Publication())->validate($id);
        }
        $this->redirect('dashboard');
    }

    public function deletePublication(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        if ($id) {
            (new Publication())->delete($id);
        }
        $this->redirect('dashboard');
    }

    public function updatePublication(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $data = [
            'content' => $_POST['content'],
            'color' => $_POST['color']
        ];
        (new Publication())->update($id, $data);
        $this->redirect('dashboard');
    }
}
