<?php
namespace App\Models;

use PDO;

class Favorites extends AbstractModel
{
    protected string $table = 'favorites';

    public function add(int $userId, int $verseId): bool
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (user_id, verse_id) VALUES (:user_id, :verse_id)");
        return $stmt->execute([
            'user_id' => $userId,
            'verse_id' => $verseId
        ]);
    }

    public function getByUserId(int $userId): array
    {
        $sql = "
            SELECT f.id, v.book_id AS book, v.chapter, v.verse_number, v.text, u.name AS user_name
            FROM favorites f
            JOIN verses v ON f.verse_id = v.id
            JOIN users u ON f.user_id = u.id
            WHERE f.user_id = :user_id
            ORDER BY f.added_at DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function remove(int $userId, int $verseId): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE user_id = :user_id AND verse_id = :verse_id");
        return $stmt->execute([
            'user_id' => $userId,
            'verse_id' => $verseId
        ]);
    }

    public function removeById(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function update(int $id, int $verseId): bool
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET verse_id = :verse_id WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'verse_id' => $verseId
        ]);
    }

    public function countAll(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM {$this->table}")->fetchColumn();
    }
}
