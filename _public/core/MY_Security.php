<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Security extends CI_Security {


    public function __construct()
    {
        parent::__construct();

    }

    public function csrf_show_error()
    {
        // comment out the default action
		 header('Location: ' . htmlspecialchars($_SERVER['REQUEST_URI']), TRUE, 200);
		// die("CRSL Errooorrrrr");
        // show_error('The action you have requested is not allowed.');

        // add redirect actions here
        // I'd like to use some helper function here like redirect()
    }
} 