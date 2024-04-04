<?php

class Controller
{

    private $db;

    /**
     * Constructor
     */
    public function __construct($input)
    {
        session_start();
        $this->db = new Database();
        $this->input = $input;

        // run file to setup the database and populate data
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
        $command = isset($this->input["command"]) ? $this->input["command"] : "home";
        switch ($command) {
            case "home":
                $this->showHome();
                break;
            case "apartment":
                $this->showApartment();
                break;
            case "login":
                $this->loginDatabase();
                break;
            case "logout":
                $this->logout();
                break;
            case "profile":
                $this->showProfile();
                break;
            case "favorites":
                $this->showFavorites();
                break;
            case "ratings":
                $this->showRatings();
                break;
            case "search":
                $this->search();
                break;
            case "favorite":
                $this->favorite();
                break;
            default:
                $this->showNotFound();
                break;
        }
    }


    /**
     * Show the home page to the user
     */
    public function showHome()
    {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $apartments = $this->db->getApartmentsPaginated($page);
        $aptCount = count($this->db->getApartments());
        include ("/opt/src/CVille4Rent/templates/home.php");
    }


    /**
     * Show the apartment by the apartment name
     */
    public function showApartment()
    {
        $apartmentName = isset($this->input["name"]) ? $this->input["name"] : "";
        $apartment = $this->db->getApartment($apartmentName)[0];
        $ratings = $this->db->getRatings($apartmentName);
        include "/opt/src/CVille4Rent/templates/apartment.php";
    }

    /**
     * Show the user's profile
     */
    public function showProfile()
    {
        $user = isset($_SESSION["user"]) ? $_SESSION["user"] : "";
        include "/opt/src/CVille4Rent/templates/profile.php";
    }

    /**
     * Page not found
     */
    public function showNotFound()
    {
        echo "404 Not Found";
    }

    public function loginDatabase()
    {
        // non-empty fields handled before form submit
        // Check if user is in database, by email
        $res = $this->db->query("SELECT * from users where email = $1;", $_POST["email"]);
        if (empty($res)) {
            // User was not there (empty result), so insert them
            // $this->db->query(
            //     "INSERT INTO users (name, email, password, score) values ($1, $2);",
            //     $_POST["email"],
            //     // Use the hashed password!
            //     password_hash($_POST["password"], PASSWORD_DEFAULT)
            // );
            // $_SESSION["user"] = $_POST["email"];
            // $message = "New user created";
            // header("Location: ?command=profile&message=" . urlencode($message));
            // header("Location: ?command=profile");

            echo "No user with email found";
        } else {
            // User was in the database, verify password is correct
            // Note: Since we used a 1-way hash, we must use password_verify()
            // to check that the passwords match.
            if (password_verify($_POST["password"], $res[0]["password"])) {
                // Password was correct, save their information to the
                // session and send them to the question page
                $_SESSION["user"] = $res[0]["email"];
                echo "success";
            } else {
                // Password was incorrect
                $_SESSION['message'] = "Incorrect password.";
                echo "Incorrect password";
                // header("Location: ?command=home");
            }
        }
    }

    public function logout()
    {
        session_destroy();
        session_start();
        header("Location: ?command=home");
    }

    /**
     * Show the apartments favorited by the user
     */
    public function showFavorites()
    {
        $apartments = $this->db->getFavoritedApartments($_SESSION["user"]);
        include "/opt/src/CVille4Rent/templates/favorites.php";
    }

    /**
     * Show ratings posted by the user
     */
    public function showRatings()
    {
        $ratings = $this->db->getUserRatings($_SESSION["user"]);
        include "/opt/src/CVille4Rent/templates/ratings.php";
    }

    /**
     * Search for an apartment
     */
    public function search()
    {
        if (isset($_POST['search']) && !empty($_POST['search'])) {
            $apartments = $this->db->getApartment($_POST['search']);
            include ("/opt/src/CVille4Rent/templates/home.php");
        } else
            header("Location: ?command=home");
    }

    public function favorite()
    {
        $favorite = $_POST['favorite'];
        $apartment_name = $_POST['apartment_name'];
        if ($favorite)
            $this->db->unfavoriteApartment($_SESSION['user'], $apartment_name);
        else
            $this->db->favoriteApartment($_SESSION['user'], $apartment_name);
        $prevUrl = $_SERVER['HTTP_REFERER'];
        header("Location: $prevUrl");
    }

}
