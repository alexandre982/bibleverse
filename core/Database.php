<?php
namespace Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $pdo = null;

    public static function getConnection(): PDO
    {
        if (self::$pdo === null) {
            try {
                self::$pdo = new PDO(
                    'mysql:host=db.3wa.io;dbname=alexandremoraisdesousa_BibleVerse+;charset=utf8mb4',
                    'alexandremoraisdesousa',
                    '46719b2ed5de45d7b812753b1a8e7d4c',
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    ]
                );
            } catch (PDOException $e) {
                die('Connexion échouée : ' . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
