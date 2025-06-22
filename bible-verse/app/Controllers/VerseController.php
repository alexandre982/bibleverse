<?php
namespace App\Controllers;

use App\Models\Verse;

class VerseController extends AbstractController
{
    public function show(): void
    {
        $verse = Verse::getRandom();

        $this->render('verses/show.php', [
            'pageTitle' => 'Verset du jour',
            'verseText' => $verse->text,
            'verseRef' => $verse->book_name . ' ' . $verse->chapter . ':' . $verse->verse_number,
            'verseId' => $verse->id,
        ]);
    }
}
