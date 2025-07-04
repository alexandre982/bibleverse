<?php
namespace App\Models;
require_once __DIR__.'/AbstractModel.php';

class Favorites extends AbstractModel
{
    public function add(int $userId, int $verseId): bool
    {
        $sql = "INSERT INTO favorites (user_id, verse_id) VALUES (:user_id,:verse_id)";
        $stmt= $this->getDb()->prepare($sql);
        return $stmt->execute(['user_id'=>$userId,'verse_id'=>$verseId]);
    }

    public function exists(int $userId, int $verseId): bool
    {
        $sql = "SELECT COUNT(*) AS cnt 
                FROM favorites 
                WHERE user_id=:u AND verse_id=:v";
        $stmt = $this->getDb()->prepare($sql);
        $stmt->execute(['u'=>$userId,'v'=>$verseId]);
        return (bool)$stmt->fetch()['cnt'];
    }

    public function getByUserId(int $userId): array
    {
        $sql= "SELECT f.id AS favorite_id,
                      b.name    AS book_name,
                      v.chapter, v.verse_number, v.text
               FROM favorites f
               JOIN verses v ON f.verse_id=v.id
               JOIN books b  ON v.book_id=b.id
               WHERE f.user_id=:user_id
               ORDER BY f.added_at DESC";
        $stmt = $this->getDb()->prepare($sql);
        $stmt->execute(['user_id'=>$userId]);
        return $stmt->fetchAll();
    }

    public function remove(int $favoriteId): bool
    {
        $sql="DELETE FROM favorites WHERE id=:id";
        $stmt=$this->getDb()->prepare($sql);
        return $stmt->execute(['id'=>$favoriteId]);
    }

    public function countAll(): int
    {
        $row = $this->getDb()
                    ->query("SELECT COUNT(*) AS total FROM favorites")
                    ->fetch();
        return (int)$row['total'];
    }
}
