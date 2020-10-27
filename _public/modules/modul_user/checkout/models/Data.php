<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	public function __construct()
	{
		parent::__construct();
	}

	function get_product_detail($id) {
		return $this->db->where('id',$id)->get(_TBL_PRODUK)->row();
	}

	public function default_address()
	{
		return $this->db->where('create_user', $this->authentication->get_Info_User('username'))
						->where('default', 1)
						->get(_TBL_ADDRESS_BOOK)->row();
	}
}

/* End of file */