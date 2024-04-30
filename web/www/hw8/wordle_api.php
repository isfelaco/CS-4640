<?php

// returns a random word from word list & returns as JSON file

$filePath = "./cs4640-wordlist.txt";
// $filePath = "/var/www/html/homework/cs4640-wordlist.txt";

$words = file($filePath, FILE_IGNORE_NEW_LINES);

$randomWord = $words[array_rand($words)];

header("Content-Type: application/json");
$res = json_encode(['word' => $randomWord]);
echo $res;