<?php

namespace App\Traits;

trait FiltersProfanity
{
    protected array $bannedWords = [
        // ── Tagalog / Bisaya insults & profanity ──
        'anak ng puta',
        'anak ng tokwa',
        'bastos',
        'bayag',
        'bilat',
        'bobo',
        'bobong',
        'buang',
        'bwiset',
        'bwisit',
        'burat',
        'buli',
        'chupa',
        'chupain',
        'dede',
        'engot',
        'gago',
        'gagong',
        'gunggong',
        'hayop',
        'hinayupak',
        'inutil',
        'iyot',
        'itot',
        'kalibugan',
        'kantot',
        'kantutan',
        'kinupal',
        'kupal',
        'kupalan',
        'leche',
        'lintik',
        'malandi',
        'manyak',
        'monay',
        'munay',
        'muri',
        'pakshet',
        'pakyu',
        'pekpek',
        'peste',
        'petoy',
        'pota',
        'potangina',
        'potay',
        'pucha',
        'puta',
        'putang ina',
        'putangina',
        'putanginang',
        'putay',
        'suso',
        'tamod',
        'tanga',
        'tangang',
        'tangina',
        'tanginang',
        'tarantado',
        'tarantadong',
        'tite',
        'titi',
        'ulol',
        'utot',
        'yawa',

        // ── English profanity / insults ──
        'asshole',
        'asshat',
        'bastard',
        'bitch',
        'bullshit',
        'cocksucker',
        'cunt',
        'dickhead',
        'douchebag',
        'dumbass',
        'fuck',
        'motherfucker',
        'prick',
        'shit',
        'twat',
        'wanker',

        // ── Sexual / explicit terms ──
        'anal',
        'bestiality',
        'blowjob',
        'bukkake',
        'creampie',
        'dildo',
        'ejaculate',
        'footjob',
        'gangbang',
        'handjob',
        'hentai',
        'incest',
        'masturbat',
        'orgy',
        'porn',
        'rimjob',
        'sodomy',
        'titjob',
        'vibrator',
        'xxx',

        // ── Real slurs (ethnic / racial / homophobic) ──
        'beaner',
        'chink',
        'coon',
        'gook',
        'gringo',
        'jigaboo',
        'kike',
        'nigga',
        'nigger',
        'nip',
        'paki',
        'raghead',
        'redskin',
        'sandnigger',
        'spic',
        'towelhead',
        'wetback',
        'wop',
        'yid',
        'zipperhead',
    ];

    /**
     * Check if text contains profanity.
     * Handles: leet speak, repeated chars, spacing tricks, mixed case
     */
    protected function containsProfanity(string $message): bool
    {
        // Normalize: lowercase
        $normalized = mb_strtolower($message);

        // Decode leet speak BEFORE stripping separators
        $leetMap = [
            '0' => 'o', '1' => 'i|l', '3' => 'e', '4' => 'a', '5' => 's',
            '7' => 't', '@' => 'a', '$' => 's', '8' => 'b', '9' => 'g',
            '!' => 'i', '+' => 't', '€' => 'e', '£' => 'l', '(_)' => 'o',
            'ph' => 'f', 'ck' => 'k', 'xz' => 'x',
        ];

        // Replace leet chars
        foreach ($leetMap as $leet => $real) {
            $normalized = str_replace($leet, $real, $normalized);
        }

        // Collapse repeated chars (booboooo -> boobo)
        $normalized = preg_replace('/(.){2,}/', '$1$1', $normalized);

        // Check original normalized text first (for multi-word phrases like "putang ina")
        foreach ($this->bannedWords as $word) {
            if (str_contains($normalized, $word)) {
                return true;
            }
        }

        // Strip ALL non-letter chars for spaced-out bypasses (p.u.t.a, p-u-t-a, p u t a)
        $stripped = preg_replace('/[^a-z]/', '', $normalized);

        foreach ($this->bannedWords as $word) {
            // Skip multi-word phrases for stripped check (they won't match without spaces)
            if (str_contains($word, ' ')) {
                continue;
            }
            if (str_contains($stripped, $word)) {
                return true;
            }
        }

        // Check for common separator bypasses: p*uta, p@uta, p.uta, etc.
        $loose = preg_replace('/[^a-z]/', '', $normalized);
        foreach ($this->bannedWords as $word) {
            if (str_contains($word, ' ')) {
                continue;
            }
            // Check with wildcard-like matching for embedded words
            if (strlen($word) >= 3 && str_contains($loose, $word)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get which banned words were found (useful for debugging/logging)
     */
    protected function getProfanityMatches(string $message): array
    {
        $found = [];
        $normalized = mb_strtolower($message);

        $leetMap = [
            '0' => 'o', '1' => 'i|l', '3' => 'e', '4' => 'a', '5' => 's',
            '7' => 't', '@' => 'a', '$' => 's', '8' => 'b', '9' => 'g',
            '!' => 'i', '+' => 't',
        ];

        foreach ($leetMap as $leet => $real) {
            $normalized = str_replace($leet, $real, $normalized);
        }

        $normalized = preg_replace('/(.){2,}/', '$1$1', $normalized);
        $stripped = preg_replace('/[^a-z]/', '', $normalized);

        foreach ($this->bannedWords as $word) {
            if (str_contains($normalized, $word) || (!str_contains($word, ' ') && str_contains($stripped, $word))) {
                $found[] = $word;
            }
        }

        return $found;
    }
}