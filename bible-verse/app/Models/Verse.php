<?php
namespace App\Models;

use Core\Database;
use PDO;

class Verse
{
    public function getById(int $id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM verses WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
