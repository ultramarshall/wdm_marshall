<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	public function __construct()
	{
		parent::__construct();
	}

	function get_product_detail($id) {
		return $this->db->where('id',$id)->get(_TBL_PRODUK)->row_array();
	}

	
}

/* End of file */