<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	
	public function __construct()
    {
        parent::__construct();
	
	}

	public function GetAllInfo($data) {
		return $this->db->where('email', $data['email'])->get(_TBL_USERS)->row();
	}
	
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */