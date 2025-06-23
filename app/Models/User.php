<?php
namespace App\Models;

use Core\Database;

class User
{
    public static function findByEmail(string $email)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public static function create(string $name, string $email, string $hashedPassword): void
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $hashedPassword]);
    }
}
