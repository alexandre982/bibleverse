<?php
namespace App\Models;

use Core\Database;

class Verse
{
    public static function getRandom()
    {
        $db = Database::getConnection();
        $sql = "SELECT v.*, b.name AS book_name
                FROM verses v
                JOIN books b ON v.book_id = b.id
                ORDER BY RAND()
                LIMIT 1";
        $stmt = $db->query($sql);
        return $stmt->fetch();
    }

    public static function findById(int $id)
    {
        $db = Database::getConnection();
        $sql = "SELECT v.*, b.name AS book_name
                FROM verses v
                JOIN books b ON v.book_id = b.id
                WHERE v.id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
