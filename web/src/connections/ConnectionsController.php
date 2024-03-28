<?php

class ConnectionsController
{
    private $categories = [];

    private $db;

    /**
     * Constructor
     */
    public function __construct($input)
    {
        $this->db = new Database();
        $this->input = $input;
        $this->loadCategories();

        // start session
        session_start();
    }

    /**
     * Run the server
     * 
     * Given the input (usually $_GET), then it will determine
     * which command to execute based on the given "command"
     * parameter.  Default is the welcome page.
     */
    public function run()
    {
        // Get the command
        $command = "example";
        if (isset($this->input["command"]))
            $command = $this->input["command"];

        switch ($command) {
            case "game":
                $this->showGame();
                break;
            case "guess":
                $this->guess();
                break;
            case "endGame":
                $this->showGameOver();
                break;
            default:
                $this->showWelcome();
                break;
        }
    }

    /**
     * Load game from a file, store them as an array
     * in the current object.
     */
    public function loadCategories()
    {
        $url = "https://cs4640.cs.virginia.edu/homework/connections.json";
        $options = [
            "ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false,
            ],
        ];
        $context = stream_context_create($options);
        $jsonData = file_get_contents($url, false, $context);

        if ($jsonData === false) {
            echo "Error fetching data from URL.";
        } else {
            $categoryList = json_decode($jsonData, true);

            if ($categoryList === null) {
                echo "Error decoding JSON data.";
            } else {
                $this->categories = $categoryList;
                // foreach ($categoryList as $categoryName => $categoryWords) {
                //     echo "Category: $categoryName <br>";
                //     echo "Words: " . implode(", ", $categoryWords) . "<br><br>";
                // }
            }
        }
    }

    /**
     * Our getQuestion function, now as a method!
     */
    public function getGame()
    {
        if (isset($_SESSION['curGame'])) {
            // return current game from session
            return $_SESSION['curGame'];
        }

        // generate a random id
        $id = uniqid();
        $id = hexdec(substr(sha1($id), 0, 8));

        // choose four categories
        $categoryNames = array_keys($this->categories);
        shuffle($categoryNames);
        $selectedCategories = array_slice($categoryNames, 0, 4);

        // choose 4 words from each category
        $selectedWords = [];
        foreach ($selectedCategories as $categoryName) {
            $words = $this->categories[$categoryName];
            shuffle($words);
            $selectedWords = array_merge($selectedWords, array_slice($words, 0, 4));
        }
        shuffle($selectedWords);

        // return list of words
        $curGame = ["id" => $id, "words" => $selectedWords, "categories" => $selectedCategories];
        $_SESSION["curGame"] = $curGame;
        return $curGame;
    }

    /**
     * Show a game to the user.  This function loads a
     * template PHP file and displays it to the user based on
     * properties of this object.
     */
    public function showGame($message = "")
    {
        // get a new game
        $game = $this->getGame();

        include ("/opt/src/connections/templates/game.php");
    }

    /**
     * Show the welcome page to the user.
     */
    public function showWelcome()
    {
        include ("/opt/src/connections/templates/welcome.php");
    }

    /**
     * Show the game over page to the user.
     */
    public function showGameOver()
    {
        session_destroy();
        include ("/opt/src/connections/templates/gameOver.php");
    }

    /**
     * Validate the user's guess.
     */
    public function validateGuess($game, $guess)
    {
        $message = "";
        if (count($guess) === 4) {
            // check if all elements in the guess array are numeric
            if (
                array_reduce($guess, function ($carry, $item) {
                    return $carry && is_numeric($item);
                }, true)
            ) {
                // check if all indices are within the range of the current list of words
                $validIndices = array_filter($guess, function ($index) use ($game) {
                    return isset ($game["words"][$index]);
                });

                // if the number of valid indices is 4, proceed
                if (count($validIndices) === 4) {
                    // map the valid indices to words in the game words
                    $guessWords = array_map(function ($index) use ($game) {
                        return $game["words"][$index];
                    }, $validIndices);
                    return [$guessWords, $message];
                } else {
                    // not all indices are valid
                    $message = "<div class=\"alert alert-danger\" role=\"alert\">
                    Invalid indices. Please enter valid numbers.
                    </div>";
                }
            } else {
                // not all elements in the guess are numeric
                $message = "<div class=\"alert alert-danger\" role=\"alert\">
                    Invalid input. Please enter numeric values.
                    </div>";
            }
        } else {
            // input does not contain exactly 4 numbers
            $message = "<div class=\"alert alert-danger\" role=\"alert\">
                    Invalid input length. Please enter exactly 4 numbers.
                    </div>";
        }
        return [false, $message];
    }

    /**
     * Check the user's guess.
     */
    public function guess()
    {
        $message = "";

        $game = $this->getGame();

        $guess = explode(" ", trim($_POST["guess"]));

        // check to make sure the input is only 4 numbers
        // check to make sure the indices are in the current list of words
        // map the numbers to words in the game words
        [$guessWords, $message] = $this->validateGuess($game, $guess);

        if ($guessWords !== false) {
            // add guess to list of guesses to display
            $_SESSION["guesses"][] = $guessWords;

            // for category in $game["categories"]
            // count the number of words found in the category
            // if all words are in the list, return correct
            // else, return incorrect
            $categoryMatched = "";
            foreach ($game['categories'] as $categoryName) {
                $wordsFound = 0;
                foreach ($guessWords as $word) {
                    if (in_array($word, $this->categories[$categoryName])) {
                        $wordsFound++;
                    }
                }

                if ($wordsFound === 4) {
                    $categoryMatched = $categoryName;
                    break;
                }
            }

            if ($categoryMatched !== "") {
                $message = "<div class=\"alert alert-success\" role=\"alert\">
                    Correct! The category is {$categoryMatched}</div>";

                // remove the found words from the list of words
                $_SESSION['curGame']['words'] = array_diff($_SESSION['curGame']["words"], $guessWords);
            } else {
                $message = "<div class=\"alert alert-danger\" role=\"alert\">Incorrect!";
                if ($wordsFound > 1)
                    $message .= " Your guess is off by " . (4 - $wordsFound) . " word(s).";
                $message .= "</div>";
            }
        }
        $this->showGame($message);
    }
}
