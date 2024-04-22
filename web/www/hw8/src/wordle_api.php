<?php

// returns a random word from word list & returns as JSON file
// modify the HTTP header and echo out JSON

$filePath = "./cs4640-wordlist.txt";

$file = file($filePath, FILE_IGNORE_NEW_LINES);

foreach ($file as $line) {
    echo $line . "<br>";
}