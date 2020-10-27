<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends MX_Model {

	private $user_table;
	private $identifier_field;
	private $username_field;
	private $password_field;
	
	public function __construct()
    {
        parent::__construct();
	}
	
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */