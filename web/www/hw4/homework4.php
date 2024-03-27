<?php
    /**
     * Homework 4 - PHP Introduction
     *
     * Computing ID:isf4rjk
     * Resources used:
     *  https://www.php.net/manual/en/language.types.string.php
     *  https://www.php.net/manual/en/ref.array.php
     */

    function calculatePercentage($score) {
        if ($score['max_points'] > 0) return ($score['score'] / $score['max_points']) * 100;
        return 0;
    } 
    function calculateGrade($scores, $drop) { 
        if (count($scores) == 0) return 0;
        if (count($scores) == 1 and $drop == true) return 0;

        // sort grades by percentage
        usort($scores, function($a, $b) {
            return calculatePercentage($a) <=> calculatePercentage($b);
        });

        // drop lowest grade once sorted
        if ($drop && count($scores) > 1) array_shift($scores);


        $totalScoredPoints = array_sum(array_column($scores, 'score'));
        $totalAvailablePoints = array_sum(array_column($scores, 'max_points'));
        $averagePercentage = ($totalAvailablePoints > 0) ? ($totalScoredPoints / $totalAvailablePoints) * 100 : 0;
        $averagePercentage = round($averagePercentage, 3); // round to 3 decimals

        return $averagePercentage;
    }

    function gridCubbies($width, $height) {
        $output = [];

        if ($width < 2 || $height < 2) {
            // return the ordered tiles of all the edges
            for ($i = 1; $i <= $width * $height; $i++) {
                if ($i <= $width || $i % $width == 1 || $i % $width == 0 || $i > ($width * $height - $width)) {
                    $output[] = $i;
                }
            }

        } else {
            // bottom left
            $output[] = 1;
            $output[] = 2;
            $output[] = 1 + $height;
            $output[] = 2 + $height;

            // top lefct
            $output[] = $height;
            $output[] = $height - 1;
            $output[] = $height + $height;
            $output[] = $height + $height - 1;

            // bottom right
            $output[] = $height * ($width - 1) + 1;
            $output[] = $height * ($width - 1) + 2;
            $output[] = $height * ($width - 2) + 1;
            $output[] = $height * ($width - 2) + 2;

            // top right
            $output[] = $height * $width;
            $output[] = ($height * $width) - 1;
            $output[] = $height * ($width - 1);
            $output[] = ($height * ($width - 1)) - 1;
            
        }

        $output = array_unique($output);
        sort($output);

        return implode(', ', array_unique($output));
    }

    function combineAddressBooks() {
        $args = func_get_args();
        if (count($args) == 0) return [];
        $merged_book = [];

        foreach ($args as $address_book) {
            foreach ($address_book as $name => $contact) {
                if (!isset($merged_book[$name])) {
                    $merged_book[$name] = [];
                }
                if (!in_array($contact, $merged_book[$name])) {
                    $merged_book[$name][] = $contact;
                }
            }
        }
        return $merged_book;
    }

    function count_overlapping($letters, $acronym) {
        $count = 0;
        $pos = 0;
        while (($pos = strpos($letters, $acronym, $pos)) !== false) {
            $count++;
            $pos++;
            if ($pos >= strlen($letters)) {
                break;
            }
        }
        return $count;
    }   
    function acronymSummary($acronyms, $searchString) {
        if ($acronyms === null || $searchString === null) return [];
        if (!is_string($acronyms) || !is_string($searchString)) return [];
        if (empty($acronyms) || empty($searchString)) return [];

        $searchWords = explode(" ", $searchString);
        $letters = "";
        foreach ($searchWords as $word) {
            if (!empty($word)) {
                $letters .= $word[0];
            }
        }
        $letters = strtolower($letters);

        $acronyms_arr = explode(" ", $acronyms);

        $counts = [];
        foreach ($acronyms_arr as $acronym) {
            $counts[$acronym] = count_overlapping($letters, strtolower($acronym));
        }
        return $counts;
    }

    // No closing php tag needed since there is only PHP in this file
