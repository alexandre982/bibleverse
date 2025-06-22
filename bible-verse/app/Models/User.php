<?php
namespace App\Models;

use PDO;
use Core\Database;

class User extends AbstractModel
{
    public int $id;
    public string $name;
    public string $email;
    public string $password;
    public string $role;

    public static function findByEmail(string $email): ?self
    {
        $stmt = self::db()->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        return $stmt->fetch() ?: null;
    }

    public static function create(string $name, string $email, string $hashedPassword): void
    {
        $stmt = self::db()->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $hashedPassword]);
    }
}
