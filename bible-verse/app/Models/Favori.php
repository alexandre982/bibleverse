<?php
namespace App\Models;

use PDO;
use Core\Database;

class Favori extends AbstractModel
{
    public function findByUserIdWithVerse(int $userId): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT f.id as favorite_id, v.id as verse_id, b.name as book_name, v.chapter, v.verse_number, v.text
            FROM favorites f
            JOIN verses v ON f.verse_id = v.id
            JOIN books b ON v.book_id = b.id
            WHERE f.user_id = :userId
            ORDER BY f.added_at DESC
        ");
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function exists(int $userId, int $verseId): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM favorites WHERE user_id = :userId AND verse_id = :verseId");
        $stmt->execute(['userId' => $userId, 'verseId' => $verseId]);
        return $stmt->fetchColumn() > 0;
    }

    public function add(int $userId, int $verseId): void
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO favorites (user_id, verse_id) VALUES (:userId, :verseId)");
        $stmt->execute(['userId' => $userId, 'verseId' => $verseId]);
    }
}
