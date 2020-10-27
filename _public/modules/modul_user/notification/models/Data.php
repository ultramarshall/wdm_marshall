<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	public function __construct()
	{
		parent::__construct();
	}

	function get_notigl($id) {
		return $this->db->where('id',$id)->get(_TBL_PRODUK)->row();
	}
}

/* End of file */