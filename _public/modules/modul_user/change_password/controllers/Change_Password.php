<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Change_Password extends FrontendController {
	public function __construct()
	{
    	parent::__construct();
	}

	public function index()
	{
		// if (!$this->authentication->is_loggedin())
			// die('Nahloh');
		$this->template->build('index');
	}

	public function forgot(){
		$input = $this->input->post();
		// if ($this->authentication->is_loggedin())
		// {
			$ci =& get_instance();
			$id = $ci->session->userdata('user_info')['id'];
			
			$password = $this->input->post('password');
			doi::dump($_POST, true);
			$c_password = $this->input->post('re_password');
			$change_password = $this->crud->crud_data([
				'table' => _TBL_USERS, 
				'field' => ['password'=>$password], 
				'where' => ['id' => $id],
				'type' => 'update', 
				'pesan' => false
			]);
			// header('Location: ' . base_url('change-password'));
		// } else {
		// 	die('Nahloh');		
		// }
	}
}
