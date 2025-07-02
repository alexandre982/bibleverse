<?php
namespace Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO(
                    'mysql:host=db.3wa.io;dbname=alexandremoraisdesousa_BibleVerse+;charset=utf8',
                    'alexandremoraisdesousa',
                    '46719b2ed5de45d7b812753b1a8e7d4c',
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    ]
                );
            } catch (PDOException $e) {
                die('Erreur de connexion : ' . $e->getMessage());
            }
        }
        return self::$instance;
    }

    public static function getConnection(): PDO
    {
        return self::getInstance();
    }
}
