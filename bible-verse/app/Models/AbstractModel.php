<?php
namespace App\Models;

use Core\Database;
use PDO;

abstract class AbstractModel
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    protected function getDb(): PDO
    {
        return $this->db;
    }
}
