<?php
namespace Core;

use PDO;

class Database
{
    private static ?PDO $conn = null;

    public static function getConnection(): PDO
    {
        if (self::$conn === null) {
            $config = require __DIR__ . '/../config/config.php';
            $db   = $config['db'];
            self::$conn = new PDO(
                $db['dsn'],
                $db['user'],
                $db['pass'],
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        }
        return self::$conn;
    }

    private function __construct() {}
}
