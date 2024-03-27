<?php
    include("homework4.php");

    // Hint: include error printing!
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
?><!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">  
    
  <title>Homework 4 Test File</title>
</head>
<body>
<h1>Homework 4 Test File</h1>

<h2>Problem 1</h2>
<?php
    echo '<h3>Test 1:</h3>';
    $test1 = [ [ "score" => 55, "max_points" => 100 ], [ "score" => 55, "max_points" => 100 ] ];
    echo calculateGrade($test1, false); // should be 55  

    echo '<h3>Test 2: total_points = 0</h3>';
    $test2 = [ [ "score" => 55, "max_points" => 0 ], [ "score" => 55, "max_points" => 0 ] ];
    echo calculateGrade($test2, false); // shouldn't throw error

    echo '<h3>Test 3: drop score</h3>';
    $test3 = [ [ "score" => 55, "max_points" => 100 ], [ "score" => 75, "max_points" => 100 ] ];
    echo calculateGrade($test3, true); // should be 75

    echo '<h3>Test 4: empty list, no drop</h3>';
    $test4 = [ ];
    echo calculateGrade($test4, false); // should be 0

    echo '<h3>Test 5: empty list, drop</h3>';
    echo calculateGrade($test4, true); // should be 0

    echo '<h3>Test 6: single score, no drop</h3>';
    $test6 = [ [ "score" => 55, "max_points" => 100 ] ];
    echo calculateGrade($test6, false); // should be 55

    echo '<h3>Test 7: single score, drop</h3>';
    $test7 = [ [ "score" => 55, "max_points" => 100 ] ];
    echo calculateGrade($test7, true); // should be 0
?>

<h2>Problem 2: Grid Cubbies</h2>
<?php
    echo '<h3>Test 1: (3, 4)</h3>';
    echo (gridCubbies(3, 4)); // [1,2,3,4,5,6,7,8,9,10,11,12]
    
    echo '<h3>Test 2: (5, 5)</h3>';
    echo (gridCubbies(5, 5)); // [1,2,4,5,6,7,9,10,16,17,19,20,21,22,24,25]

    echo '<h3>Test 3: (2, 2)</h3>';
    echo (gridCubbies(2, 2)); // [1,2,3,4]

    echo '<h3>Test 4: (2, 1)</h3>';
    echo (gridCubbies(2, 1)); // [1,2]

    echo '<h3>Test 4: (1, 5)</h3>';
    echo (gridCubbies(1, 5)); 
    
    echo '<h3>Test 5: (1591, 1226)</h3>';
    echo (gridCubbies(1591, 1226));

    echo '<h3>Test 5: (5, 2)</h3>';
    echo (gridCubbies(5, 2));
?>

<h2>Problem 3: Address Books</h2>
<?php
    echo '<h3>Test 1: two inputs</h3>';
    $test1a = ['Happy' => '111-111-1111', 'Sneezy' => '222-222-2222',
                'Doc' => '333-333-3333', 'Grumpy' => '444-444-4444', 'Bashful' => '555-555-5555',
                'Sleepy' => 'sleepy@uva.edu'];
    $test1b = ['Sneezy' => 'sneezy@uva.edu', 'Doc' => 'doc@uva.edu', 'Happy' => 'happy@uva.edu', 'Bashful' => 'bashful@uva.edu', 'Sleepy' => 'sleepy@uva.edu'];
    echo json_encode(combineAddressBooks($test1a, $test1b));

    echo '<h3>Test 2: single input</h3>';
    echo json_encode(combineAddressBooks($test1a));

    echo '<h3>Test 3: three inputs</h3>';
    $test3 = ['Grumpy' => 'grumpy@uva.edu'];
    echo json_encode(combineAddressBooks($test1a, $test1b, $test3));

    echo '<h3>Test 4: zero inputs</h3>';
    echo json_encode(combineAddressBooks());
?>

<h2>Problem 4: Acronyms</h2>
<?php
    echo '<h3>Test 1:</h3>';
    $acronyms = "rofl lol afk";
    $searchString = "Rabbits on freezing lakes only like really old fleece leggings.";
    echo json_encode(acronymSummary($acronyms, $searchString));

    echo '<h3>Test 2: case sensitivity</h3>';
    $acronyms = "r R rR RrR rrr";
    $searchString = "Rabbits. Really Run in the snow";
    echo json_encode(acronymSummary($acronyms, $searchString));

    echo '<h3>Test 3: null inputs</h3>';
    $acronyms = null;
    $searchString = null;
    echo json_encode(acronymSummary($acronyms, $searchString));
?>

</body>
</html>
