<?php
namespace App\Models;

use PDO;

class Publication extends AbstractModel
{
    protected string $table = 'publications';

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (user_id, type, content, color) VALUES (:user_id, :type, :content, :color)");
        return $stmt->execute([
            'user_id' => $data['user_id'],
            'type' => $data['type'],
            'content' => $data['content'],
            'color' => $data['color']
        ]);
    }

    public function getValidated(): array
    {
        $stmt = $this->db->prepare("
            SELECT p.*, u.name AS user_name
            FROM {$this->table} p
            JOIN users u ON p.user_id = u.id
            WHERE p.is_validated = 1
            ORDER BY p.created_at DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getPending(): array
    {
        $stmt = $this->db->query("
            SELECT p.*, u.name AS user_name
            FROM {$this->table} p
            JOIN users u ON p.user_id = u.id
            WHERE is_validated = 0
            ORDER BY created_at DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function validate(int $id): bool
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET is_validated = 1 WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET content = :content, color = :color WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'content' => $data['content'],
            'color' => $data['color']
        ]);
    }

    public function countAll(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM {$this->table}")->fetchColumn();
    }
}
