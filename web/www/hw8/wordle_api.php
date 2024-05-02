<?php
header("Access-Control-Allow-Origin: http://cs4640.cs.virginia.edu/isf4rjk/hw8/");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT");

// returns a random word from word list & returns as JSON file

// $filePath = "./cs4640-wordlist.txt";
$filePath = "/var/www/html/homework/cs4640-wordlist.txt";

$words = file($filePath, FILE_IGNORE_NEW_LINES);

$randomWord = $words[array_rand($words)];

header("Content-Type: text/plain");
echo $randomWord;