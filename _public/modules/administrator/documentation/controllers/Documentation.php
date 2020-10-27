<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Documentation extends BackendController {
	var $data=[];

	public function __construct()
	{
        parent::__construct();
	}
	
	public function index()
	{	
		$this->template->build('view',$data); 
	}
	
	
}