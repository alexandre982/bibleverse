<?php
namespace App\Models;

use Core\Database;

class Verse extends AbstractModel
{
    protected static string $table = 'verses';

    // Récupérer un verset aléatoire avec le nom du livre (book_name)
    public static function getRandom()
    {
        $db = Database::getConnection();
        $sql = "SELECT v.*, b.name AS book_name
                FROM verses v
                JOIN books b ON v.book_id = b.id
                ORDER BY RAND()
                LIMIT 1";
        $stmt = $db->query($sql);
        return $stmt->fetchObject();
    }

    // Récupérer un verset par ID avec book_name
    public static function findById(int $id)
    {
        $db = Database::getConnection();
        $sql = "SELECT v.*, b.name AS book_name
                FROM verses v
                JOIN books b ON v.book_id = b.id
                WHERE v.id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchObject();
    }

    // Cette méthode peut rester si tu l'utilises ailleurs
    public function getBookName(): string
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT name FROM books WHERE id = ?");
        $stmt->execute([$this->book_id]);
        return $stmt->fetchColumn() ?: 'Livre inconnu';
    }
}
