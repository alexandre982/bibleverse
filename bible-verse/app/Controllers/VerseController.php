<?php

namespace App\Controllers;

use App\Services\BibleApi;

class VerseController
{
    private BibleApi $bibleApi;

    public function __construct()
    {
        $this->bibleApi = new BibleApi('dbb510c4a740396e73c4340d063dd91f');
    }

    public function show(): void
    {
        $verseData = $this->bibleApi->getVerseOfTheDayByWeek();
        $verseText = $verseData['content'] ?? 'Aucun verset trouvé.';
        $verseRef = $verseData['reference'] ?? '';
        $pageTitle = "Verset du jour";

        $view = __DIR__ . '/../Views/verses/show.php';
        require __DIR__ . '/../Views/layout.php';
    }
}
