<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends BackendController {
	public function __construct()
	{
    	parent::__construct();
	}
	public function index(){
		$this->template->build('dash_admin');
	}
}
