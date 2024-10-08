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
            case "signup":
                $this->createUser();
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
            case "rate":
                $this->submitRating();
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
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $apartments = $this->db->getApartmentsPaginated($page);
        $aptCount = count($this->db->getApartments());

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode($apartments);
            exit;
        }

        // include ("/opt/src/CVille4Rent/templates/home.php");
        include ("/students/isf4rjk/students/isf4rjk/private_html/CVille4Rent/templates/home.php");

    }


    /**
     * Show the apartment by the apartment name
     */
    public function showApartment()
    {
        $apartmentName = isset($this->input["name"]) ? $this->input["name"] : "";
        $apartment = $this->db->getApartment($apartmentName)[0];
        $ratings = $this->db->getRatings($apartmentName);

        // include "/opt/src/CVille4Rent/templates/apartment.php";
        include ("/students/isf4rjk/students/isf4rjk/private_html/CVille4Rent/templates/apartment.php");
    }

    /**
     * Show the user's profile
     */
    public function showProfile()
    {
        $user = isset($_SESSION["user"]) ? $_SESSION["user"] : "";

        // include "/opt/src/CVille4Rent/templates/profile.php";
        include ("/students/isf4rjk/students/isf4rjk/private_html/CVille4Rent/templates/profile.php");
    }

    /**
     * Page not found
     */
    public function showNotFound()
    {
        echo "404 Not Found";
    }

    /**
     * Login my checking for user in database and comparing password
     */
    public function loginDatabase()
    {
        $res = $this->db->query("SELECT * from users where email = $1;", $_POST["user"]["email"]);

        $message = '';
        if (empty($res))
            $message = "No user with email found";
        else {
            // User was in the database, verify password is correct
            if (password_verify($_POST["user"]["password"], $res[0]["password"])) {
                // Password was correct, save their information to the
                $_SESSION["user"] = $res[0]["email"];
                $message = "success";
            } else {
                // password was incorrect
                $message = "Incorrect Password";
            }
        }
        header("Content-Type: application/json");
        echo json_encode(array("message" => $message));
    }

    /**
     * Create a user in the database
     */
    public function createUser()
    {
        $this->db->query(
            "INSERT INTO users (email, password) values ($1, $2);",
            $_POST["email"],
            password_hash($_POST["password"], PASSWORD_DEFAULT)
        );
        $_SESSION["user"] = $_POST["email"];
        $message = "New user created";
        header("Content-Type: application/json");
        echo json_encode(array("message" => $message));
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

        // include "/opt/src/CVille4Rent/templates/favorites.php";
        include ("/students/isf4rjk/students/isf4rjk/private_html/CVille4Rent/templates/favorites.php");

    }

    /**
     * Show ratings posted by the user
     */
    public function showRatings()
    {
        $ratings = $this->db->getUserRatings($_SESSION["user"]);

        // include "/opt/src/CVille4Rent/templates/ratings.php";
        include ("/students/isf4rjk/students/isf4rjk/private_html/CVille4Rent/templates/ratings.php");
    }

    /**
     * Search for an apartment
     */
    public function search()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            $apartments = $this->db->getApartment($_GET['search']);
            header('Content-Type: application/json');
            echo json_encode($apartments);
            exit;
        }

        // include ("/opt/src/CVille4Rent/templates/home.php");
        include ("/students/isf4rjk/students/isf4rjk/private_html/CVille4Rent/templates/home.php");

    }

    public function favorite()
    {
        $apartment_name = $_POST['apartment_name'];

        $action = "favorite";
        $favoritedApartments = $this->db->getFavoritedApartments($_SESSION['user']);
        foreach ($favoritedApartments as $favApartment) {
            if ($favApartment['name'] == $apartment_name) {
                $action = "un-favorite";
                break;
            }
        }

        if ($action !== "favorite")
            $this->db->unfavoriteApartment($_SESSION['user'], $apartment_name);
        else
            $this->db->favoriteApartment($_SESSION['user'], $apartment_name);
        header('Content-Type: application/json');
        echo json_encode($action);
    }

    /**
     * Insert a rating into the database
     */
    public function submitRating()
    {
        $rating = $_POST["rating"];
        $res = $this->db->insertRating($rating);

        header('Content-Type: application/json');
        echo json_encode($res);
    }
}
