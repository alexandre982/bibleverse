<?php
namespace App\Services;

class BibleApi
{
    private string $apiKey;
    private string $baseUrl = 'https://api.scripture.api.bible/v1';
    private string $bibleId = 'a93a92589195411f-01'; // Bible J.N. Darby

    private array $weeklyBooks = [
        'GEN.1.1',    // Semaine 1 : Genèse
        'EXO.3.14',   // Semaine 2 : Exode
        'LEV.19.2',   // Semaine 3 : Lévitique
        'NUM.6.24',   // Semaine 4 : Nombres
        'DEU.6.5',    // Semaine 5 : Deutéronome
        'JOS.1.9',    // Semaine 6 : Josué
        'JDG.6.12',   // Semaine 7 : Juges
        'RUT.1.16',   // Semaine 8 : Ruth
        '1SA.16.7',   // Semaine 9 : 1 Samuel
        '2SA.22.2',   // Semaine 10 : 2 Samuel
        '1KI.3.9',    // Semaine 11 : 1 Rois
        '2KI.2.9',    // Semaine 12 : 2 Rois
        '1CH.16.11',  // Semaine 13 : 1 Chroniques
        '2CH.7.14',   // Semaine 14 : 2 Chroniques
        'EZR.7.10',   // Semaine 15 : Esdras
        'NEH.8.10',   // Semaine 16 : Néhémie
        'EST.4.14',   // Semaine 17 : Esther
        'JOB.1.21',   // Semaine 18 : Job
        'PSA.23.1',   // Semaine 19 : Psaumes
        'PRO.3.5',    // Semaine 20 : Proverbes
        'ECC.3.1',    // Semaine 21 : Ecclésiaste
        'SNG.2.4',    // Semaine 22 : Cantique
        'ISA.40.31',  // Semaine 23 : Esaïe
        'JER.29.11',  // Semaine 24 : Jérémie
        'LAM.3.23',   // Semaine 25 : Lamentations
        'EZK.36.26',  // Semaine 26 : Ézéchiel
        'DAN.6.27',   // Semaine 27 : Daniel
        'HOS.6.6',    // Semaine 28 : Osée
        'JOE.2.28',   // Semaine 29 : Joël
        'AMO.5.24',   // Semaine 30 : Amos
        'OBA.1.15',   // Semaine 31 : Abdias
        'JON.2.2',    // Semaine 32 : Jonas
        'MIC.6.8',    // Semaine 33 : Michée
        'NAH.1.7',    // Semaine 34 : Nahum
        'HAB.2.4',    // Semaine 35 : Habacuc
    ];

    public function __construct(string $apiKey)
    {
        $this->apiKey = 'dbb510c4a740396e73c4340d063dd91f';
    }

    public function getVerseText(string $verseId): ?array
    {
        $url = $this->baseUrl . "/bibles/{$this->bibleId}/verses/{$verseId}?content-type=text";
        $response = $this->callApi($url);

        if (!isset($response['data'])) {
            return null;
        }

        return [
            'id' => $response['data']['id'] ?? null,           // <-- Ajout de l'id ici
            'reference' => $response['data']['reference'] ?? null,
            'content' => strip_tags($response['data']['content'] ?? '')
        ];
    }

    public function getVerseOfTheDayByWeek(): ?array
    {
        $currentWeek = (int)date('W'); // Numéro de semaine ISO (1 à 52)
        $index = ($currentWeek - 1) % count($this->weeklyBooks);

        return $this->getVerseText($this->weeklyBooks[$index]);
    }

    private function callApi(string $url): ?array
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'api-key: ' . $this->apiKey
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            return null;
        }

        curl_close($ch);
        $data = json_decode($result, true);

        return $data ?: null;
    }
}
