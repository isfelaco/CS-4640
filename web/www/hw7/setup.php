<?php
/**
    accepts the number of rows and columns in the board as GET parameters (on the query string) and randomly select 10
    starting positions–the boxes in the board where the lights will be on at the start of the game. Each position should be
    defined by its position–or row-column coordinate–in the board. This script must return a JSON object with the list of
    the lights-on starting positions.
    
    If the board has less than 10 boxes, then your setup.php file should return a JSON object with the list of all positions
    (all lights are on).
*/
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_POST['size'])) {
    http_response_code(400); // Bad request
    die(json_encode(['error' => 'Size parameter is required.']));
}

$size = intval($_POST['size']);

if ($size <= 0) {
    http_response_code(400); // Bad request
    die(json_encode(['error' => 'Size must be a positive integer.']));
}

$total_cells = $size * $size;

$num_lights_on = min(10, $total_cells);

$lights_on_positions = [];
$all_positions = [];

for ($i = 0; $i < $size; $i++) {
    for ($j = 0; $j < $size; $j++) {
        $all_positions[] = [$i, $j];
    }
}

$random_indices = array_rand($all_positions, $num_lights_on);

foreach ($random_indices as $index) {
    $lights_on_positions[] = $all_positions[$index];
}

$response = ['lights_on_positions' => $lights_on_positions];

header("Content-Type: application/json");
echo json_encode($response);