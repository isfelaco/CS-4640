<?php
// url: https://cs4640.cs.virginia.edu/isf4rjk/CVille4Rent/

// DEBUGGING ONLY! Show all errors.
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Class autoloading by name.  All our classes will be in a directory
// that Apache does not serve publicly.  They will be in /opt/src/, which
// is our src/ directory in Docker.
spl_autoload_register(function ($classname) {
  // include "/opt/src/CVille4Rent/$classname.php";
  include "/students/isf4rjk/students/isf4rjk/private_html/CVille4Rent/$classname.php";
});

// Other global things that we need to do
// (such as starting a session, coming soon!)

// Instantiate the front controller
$app = new Controller($_GET);

// Run the controller
$app->run();