<?php
// src/Service/ProfanityChecker.php

namespace App\Service;

class ProfanityChecker
{
private array $offensiveWords;

public function __construct(array $offensiveWords)
{
$this->offensiveWords = $offensiveWords;
}

public function containsProfanity(string $content): bool
{
$content = strtolower($content);
foreach ($this->offensiveWords as $word) {
if (str_contains($content, $word)) {
return true;
}
}
return false;
}
}
