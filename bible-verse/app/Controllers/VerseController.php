<?php
namespace App\Controllers;

use App\Controllers\AbstractController;
use App\Models\Verse;
use App\Services\BibleApi;

class VerseController extends AbstractController
{
    private BibleApi $bibleApi;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->bibleApi = new BibleApi('dbb510c4a740396e73c4340d063dd91f');
    }

    public function show(): void
    {
        // 1) Récupérer le verset de la semaine depuis l'API
        $verseData = $this->bibleApi->getVerseOfTheDayByWeek();

        // 2) Préparer le texte et la référence pour la vue
        $verseText = $verseData['content']   ?? 'Aucun verset trouvé.';
        $verseRef  = $verseData['reference'] ?? '';

        // 3) Convertir le code (ex: "DAN.6.27") en ID numérique
        $verseCode = $verseData['id'] ?? null;
        $verseId   = null;
        if ($verseCode) {
            $model     = new Verse();
            $verseId   = $model->getIdByCode($verseCode);
        }

        // 4) Passer toutes les données à la vue via render()
        $this->render(
            'verses/show.php',
            [
                'pageTitle' => 'Verset du jour',
                'verseText' => $verseText,
                'verseRef'  => $verseRef,
                'verseId'   => $verseId,
            ]
        );
    }
}
