<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Router class */
// require APPPATH."third_party/MX/Controller.php";

class Form_Child
{
    public function __construct()
    {
       
    }
	
	function set_data($data){
		Doi::dump($data);
	}
}