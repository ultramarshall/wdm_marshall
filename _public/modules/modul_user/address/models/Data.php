<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	public function __construct()
	{
		parent::__construct();
	}

	function get_address() {
		return $this->db->where('create_user',$this->authentication->get_Info_User('username'))->get(_TBL_ADDRESS_BOOK)->result();
	}

	function set_address($data) {
		$data['create_user'] = $this->authentication->get_Info_User('username');
		$results = $this->crud->crud_data([
			'table'=>_TBL_ADDRESS_BOOK, 
			'field'=> $data, 
			'type'=>'add'
		]);
		return $results;
	}

	function set_default($id) {
		$sql = "UPDATE tbl_address_book as a 
				SET a.`default` = CASE
					WHEN a.id != ".$id." THEN 0
					WHEN a.id = ".$id." THEN 1
				END
				WHERE a.create_user = '".$this->authentication->get_Info_User('username')."'";


		$result = $this->db->query($sql);
		return $result;
	}
}

/* End of file */