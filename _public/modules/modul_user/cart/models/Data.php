<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	public function __construct()
	{
		parent::__construct();
	}

	function get_product_detail($id) {
		return $this->db->where('id',$id)->get(_TBL_PRODUK)->result();
	}

	function get_status_promotion($code) {
		return $this->db->where('coupon',$code)
						->where('aktif', 1)
						->get(_TBL_COUPON)->result_array();
	}
}

/* End of file */