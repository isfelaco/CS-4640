<?php

class ConnectionsController
{
    private $categories = [];


    // an error message to display on the welcome page
    private $errorMessage = "";

    /**
     * Constructor
     */
    public function __construct($input)
    {
        // start session
        session_start();

        // set input
        $this->input = $input;

        // not needed if in the database
        $this->loadCategories();
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
        // get the command
        $command = "example";
        if (isset($this->input["command"]))
            $command = $this->input["command"];

        // if there is no user, redirect to the welcome page
        if (!isset($_SESSION["name"]) && $command !== "login")
            $command = "welcome";

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
            case "newGame":
                $this->restartGame();
                break;
            case "login":
                $this->login();
                break;
            case "logout":
                $this->logout();
            default:
                $this->showWelcome();
                break;
        }
    }

    /**
     * Load categories from url, store them as an array
     * in the current object.
     */
    public function loadCategories()
    {
        $jsonData = file_get_contents("/opt/src/connections/data/connections.json", true);
        // $jsonData = file_get_contents("/var/www/html/homework/connections.json");

        if ($jsonData === false) {
            echo "Error fetching data from URL.";
        } else {
            $categoryList = json_decode($jsonData, true);

            if ($categoryList === null)
                echo "Error decoding JSON data.";
            else
                $this->categories = $categoryList;
        }
    }

    /**
     * Login Function
     *
     * This function checks that the user submitted the form and did not
     * leave the name and email inputs empty.  If all is well, we set
     * their information into the session and then send them to the 
     * question page.  If all didn't go well, we set the class field
     * errorMessage and show the welcome page again with that message.
     */
    public function login()
    {
        if (
            isset($_POST["fullname"]) && isset($_POST["email"]) &&
            !empty($_POST["fullname"]) && !empty($_POST["email"])
        ) {
            $_SESSION["name"] = $_POST["fullname"];
            $_SESSION["email"] = $_POST["email"];
            $_SESSION["guesses"] = [];
            header("Location: ?command=game");
            return;
        }
        $this->errorMessage = "Error logging in - Name and email is required";
        $this->showWelcome();
    }

    /**
     * Logout
     *
     * Destroys the session, essentially logging the user out.  It will then start
     * a new session so that we have $_SESSION if we need it.
     */
    public function logout()
    {
        session_destroy();
        session_start();
    }


    /**
     * If $_SESSION["curGame"] is null, create a game
     * return $_SESSION["curGame"]
     */
    public function getGame()
    {
        // create a new game
        if (!isset($_SESSION["curGame"])) {
            // choose 4 random categories
            $categoryKeys = array_keys($this->categories);
            shuffle($categoryKeys);
            $selectedCategoryNames = array_slice($categoryKeys, 0, 4);

            // choose 4 random words from each category
            $selectedCategories = [];
            $selectedWords = [];
            foreach ($selectedCategoryNames as $categoryName) {
                $words = $this->categories[$categoryName];
                shuffle($words);
                $selectedCategories[$categoryName] = array_slice($words, 0, 4);
                $selectedWords = array_merge($selectedWords, array_slice($words, 0, 4));
            }
            shuffle($selectedWords);

            $_SESSION["curGame"] = ["categories" => $selectedCategories, "words" => $selectedWords];
        }
        return $_SESSION["curGame"];
    }

    /**
     * Show a game to the user.  This function loads a
     * template PHP file and displays it to the user based on
     * properties of this object.
     */
    public function showGame($message = "")
    {
        // get user data
        $name = $_SESSION["name"];
        $email = $_SESSION["email"];

        // get the current game or a new game
        $game = $this->getGame();

        include ("/opt/src/connections/templates/game.php");
        // include ("./src/templates/game.php");
    }

    /**
     * Logic for restarting a game
     */
    public function restartGame()
    {
        unset($_SESSION["curGame"]);
        unset($_SESSION["guesses"]);
        header("Location: ?command=game");
    }

    /**
     * Show the welcome page to the user.
     */
    public function showWelcome()
    {
        $message = "";
        if (!empty($this->errorMessage)) {
            $message = "<div class='alert alert-danger'>{$this->errorMessage}</div>";
        }

        include ("/opt/src/connections/templates/welcome.php");
        // include ("./src/templates/welcome.php");
    }

    /**
     * Show the game over page to the user.
     */
    public function showGameOver()
    {
        $game = $this->getGame();
        include ("/opt/src/connections/templates/gameOver.php");
        // include ("./src/templates/gameOver.php");
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
        [$guessWords, $message] = $this->validateGuess($game, $guess);

        // guess is valid, check the guess and update message
        if ($guessWords !== false) {
            $categoryMatched = "";
            $maxWords = 0;
            foreach ($game["categories"] as $categoryName => $categoryWords) {
                $matchedWords = array_intersect($categoryWords, $guessWords);
                $matchedWordsCount = count($matchedWords);

                // if all 4 words match, a category is found
                if ($matchedWordsCount === 4) {
                    $maxWords = 4;
                    $categoryMatched = $categoryName;
                    $message = "<div class=\"alert alert-success\" role=\"alert\">
                    Correct! The category is {$categoryMatched}</div>";

                    // remove the found words from the list of words
                    $_SESSION["curGame"]["words"] = array_diff($_SESSION["curGame"]["words"], $guessWords);
                    break;
                }

                // update maxWords
                if ($matchedWordsCount > $maxWords && $matchedWordsCount >= 2)
                    $maxWords = $matchedWordsCount;


            }
            // if some words match
            if ($maxWords >= 2 && $maxWords < 4) {
                $message = "<div class=\"alert alert-danger\" role=\"alert\">Incorrect!";
                if ($maxWords !== 0)
                    $message .= " Your guess is off by " . (4 - $maxWords) . " word(s).";
                $message .= "</div>";
            }

            // add guess to list of guesses and the number of words correct
            $_SESSION["guesses"][] = ["words" => $guessWords, "numIncorrect" => (4 - $maxWords)];
        }
        $this->showGame($message);
    }
}
