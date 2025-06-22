<?php
namespace App\Models;

use Core\Database;

abstract class AbstractModel
{
    protected static function db()
    {
        return Database::getConnection();
    }

    public static function getDb()
    {
        return static::db();
    }
}
