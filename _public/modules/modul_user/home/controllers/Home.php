<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends FrontendController {
	public function __construct() {
    	parent::__construct();
	}

	public function index() {
		$this->template->build('home', $data);
	}
	
}
