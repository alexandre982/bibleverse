<?php

namespace App\Controllers;

use App\Models\User;

class AuthController extends AbstractController
{
    public function register(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $errors = [];
        $old = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            $old = compact('name', 'email');

            if (empty($name)) {
                $errors[] = 'Le nom est obligatoire.';
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email invalide.';
            }

            if (strlen($password) < 6) {
                $errors[] = 'Le mot de passe doit contenir au moins 6 caractères.';
            }

            if ($password !== $confirmPassword) {
                $errors[] = 'Les mots de passe ne correspondent pas.';
            }

            if (empty($errors)) {
                $userModel = new User();
                $existingUser = $userModel->findByEmail($email);

                if ($existingUser) {
                    $errors[] = 'Cet email est déjà utilisé.';
                } else {
                    $userId = $userModel->create([
                        'name' => $name,
                        'email' => $email,
                        'password' => password_hash($password, PASSWORD_DEFAULT),
                    ]);

                    $_SESSION['user'] = [
                        'id' => $userId,
                        'name' => $name,
                        'email' => $email,
                        'role' => 'user',
                    ];

                    $_SESSION['flash'] = "Inscription réussie. Bienvenue !";
                    $this->redirect('verset-du-jour');
                    return;
                }
            }
        }

        $this->render('auth/register.php', [
            'pageTitle' => 'Inscription',
            'errors' => $errors,
            'old' => $old
        ]);
    }

    public function login(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $errors = [];
        $old = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $old = compact('email');

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email invalide.';
            }

            if (empty($password)) {
                $errors[] = 'Le mot de passe est requis.';
            }

            if (empty($errors)) {
                $userModel = new User();
                $user = $userModel->findByEmail($email);

                if (!$user || !password_verify($password, $user['password'])) {
                    $errors[] = 'Identifiants incorrects.';
                } else {
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'role' => $user['role'],
                    ];

                    $_SESSION['flash'] = "Connexion réussie. Bienvenue !";
                    $this->redirect('verset-du-jour');
                    return;
                }
            }
        }

        $this->render('auth/login.php', [
            'pageTitle' => 'Connexion',
            'errors' => $errors,
            'old' => $old
        ]);
    }
}
