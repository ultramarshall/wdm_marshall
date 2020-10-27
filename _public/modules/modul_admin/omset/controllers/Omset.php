<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Omset extends BackendController {
	public function __construct()
	{
    	parent::__construct();
	}

	function index() {
		$this->template->build('index');
	}

}
