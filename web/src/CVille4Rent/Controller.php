<?php

class Controller
{

    private $db;

    /**
     * Constructor
     */
    public function __construct($input)
    {
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
        include ("/opt/src/CVille4Rent/templates/home.php");
    }

    public function showNotFound()
    {
        // You can customize this as needed
        echo "404 Not Found";
    }

    public function showApartment()
    {
        $apartmentName = isset($this->input["name"]) ? $this->input["name"] : "";
        $apartment = $this->db->getApartment($apartmentName)[0];
        $ratings = $this->db->getRatings($apartmentName);
        include "/opt/src/CVille4Rent/templates/apartment.php";
    }
}
