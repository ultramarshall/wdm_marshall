<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	public function __construct()
	{
		parent::__construct();
	}

	function get_order() {
		return $this->db->where('create_user',$this->authentication->get_Info_User('username'))->get(_TBL_ORDER)->result();
	}

	function set_order($data) {
		$data['create_user'] = $this->authentication->get_Info_User('username');
		$results = $this->crud->crud_data([
			'table'=>_TBL_ORDER, 
			'field'=> $data, 
			'type'=>'add'
		]);
		return $results;
	}
}

/* End of file */