<?php
namespace App\Models;

use PDO;
use Core\Database;

class Publication
{
    protected PDO $db;
    protected string $table = 'publications';

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function create(array $data): bool
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO {$this->table} (user_id, type, content, is_validated)
                VALUES (:user_id, :type, :content, 0)
            ");
            return $stmt->execute([
                'user_id' => $data['user_id'],
                'type' => $data['type'],
                'content' => $data['content']
            ]);
        } catch (\PDOException $e) {
            // Tu peux activer l'affichage de l'erreur pour débogage :
            error_log('Erreur insertion publication : ' . $e->getMessage());
            return false;
        }
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
        $stmt = $this->db->prepare("
            SELECT p.*, u.name AS user_name
            FROM {$this->table} p
            JOIN users u ON p.user_id = u.id
            WHERE p.is_validated = 0
            ORDER BY p.created_at DESC
        ");
        $stmt->execute();
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
        $stmt = $this->db->prepare("UPDATE {$this->table} SET content = :content WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'content' => $data['content']
        ]);
    }

    public function countAll(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM {$this->table}")->fetchColumn();
    }
}
