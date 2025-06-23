<?php
namespace App\Controllers;

use App\Models\User;

class AuthController extends AbstractController
{
    public function register(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (!$name || !$email || !$password || !$confirmPassword) {
                $errors[] = 'Tous les champs sont obligatoires.';
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email invalide.';
            }

            if ($password !== $confirmPassword) {
                $errors[] = 'Les mots de passe ne correspondent pas.';
            }

            if (User::findByEmail($email)) {
                $errors[] = 'Email déjà utilisé.';
            }

            if (empty($errors)) {
                $hashed = password_hash($password, PASSWORD_BCRYPT);
                User::create($name, $email, $hashed);
                $this->redirect('connexion');
                return;
            }
        }

        $this->render('auth/register.php', [
            'pageTitle' => 'Inscription',
            'errors' => $errors,
            // pour pré-remplissage des champs
            'old' => $_POST ?? []
        ]);
    }

    public function login(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $user = User::findByEmail($email);

            if (!$user || !password_verify($password, $user->password)) {
                $errors[] = 'Identifiants incorrects.';
            }

            if (empty($errors)) {
                session_regenerate_id(true);
                $_SESSION['user'] = ['id' => $user->id, 'name' => $user->name];
                $this->redirect('verset-du-jour');
                return;
            }
        }

        $this->render('auth/login.php', [
            'pageTitle' => 'Connexion',
            'errors' => $errors,
            'old' => $_POST ?? []
        ]);
    }

    public function loueTemoigne(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            $this->redirect('connexion');
            return;
        }

        $this->render('verses/show.php', [
            'pageTitle' => 'Loue/Témoigne',
            'verseText' => 'Espace pour publier un témoignage ou une louange.',
            'verseRef' => ''
        ]);
    }
}
