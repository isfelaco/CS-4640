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
        $command = "example";
        if (isset($this->input["command"]))
            $command = $this->input["command"];

        switch ($command) {
            default:
                $this->showHome();
                break;
        }
    }

    /**
     * Show the example page to the user.
     */
    public function showExample()
    {
        $dataElement = print_r($this->input, true);
        include ("/opt/src/example/templates/example.php");
    }

    public function showHome()
    {
        include ("/opt/src/CVille4Rent/templates/home.php");
    }
}
