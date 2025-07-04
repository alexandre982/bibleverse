<?php
namespace App\Models;

use Core\Database;
use PDO;

class Verse
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Récupère un verset complet par son ID numérique.
     */
    public function getById(int $id): ?object
    {
        $stmt = $this->db->prepare("SELECT * FROM verses WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ) ?: null;
    }

    /**
     * Récupère l'ID d'un verset à partir du code format "BOOKCODE.chapter.verse"
     * Ex : "DAN.6.27"
     */
    public function getIdByCode(string $code): ?int
    {
        $parts = explode('.', $code);
        if (count($parts) !== 3) {
            return null;
        }
        [$bookCode, $chapter, $verseNumber] = $parts;

        // Map des codes aux book_id dans ta table "books"
        $bookCodes = [
            'GEN' => 1, 'EXO' => 2, 'LEV' => 3, 'NUM' => 4, 'DEU' => 5,
            'JOS' => 6, 'JDG' => 7, 'RUT' => 8, '1SA' => 9, '2SA' => 10,
            '1KI' => 11,'2KI' => 12,'1CH' => 13,'2CH' => 14,'EZR' => 15,
            'NEH' => 16,'EST' => 17,'JOB' => 18,'PSA' => 19,'PRO' => 20,
            'ECC' => 21,'SNG' => 22,'ISA' => 23,'JER' => 24,'LAM' => 25,
            'EZK' => 26,'DAN' => 27,'HOS' => 28,'JOE' => 29,'AMO' => 30,
            'OBA' => 31,'JON' => 32,'MIC' => 33,'NAH' => 34,'HAB' => 35,
            // etc. complète jusqu’à tout le canon si besoin
        ];
        if (!isset($bookCodes[$bookCode])) {
            return null;
        }
        $bookId = $bookCodes[$bookCode];

        // Requête corrigée : pas de colonne `code`, on filtre sur book_id, chapter, verse_number
        $stmt = $this->db->prepare("
            SELECT id
            FROM verses
            WHERE book_id      = :book_id
              AND chapter      = :chapter
              AND verse_number = :verse_number
            LIMIT 1
        ");
        $stmt->execute([
            'book_id'     => $bookId,
            'chapter'     => (int) $chapter,
            'verse_number'=> (int) $verseNumber,
        ]);

        $row = $stmt->fetch(PDO::FETCH_OBJ);
        return $row ? (int)$row->id : null;
    }
}
