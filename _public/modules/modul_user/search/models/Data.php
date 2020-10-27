<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	public function __construct()
	{
		parent::__construct();
	}

	function filter($data){
		$query = $this->db->select('a.*, b.brand_name, c.category_name')
				 ->from(_TBL_PRODUK.' as a')
				 ->join(_TBL_BRAND.' as b', 'a.brand_id=b.id', 'left')
				 ->join(_TBL_CATEGORY.' as c', 'a.category_id=c.id', 'left');

		/* filter by range price */				 
		if (array_key_exists('from', $data) && array_key_exists('to', $data))
			$query = $query->where('( ((a.harga-(a.harga*(a.diskon/100))) >='.(int)$data['from'].') AND ((a.harga-(a.harga*(a.diskon/100))) <= '.(int)$data['to'].'))');

		/* filter by keyword */	
		if ($this->session->userdata('keyword') != NULL || $this->session->userdata('keyword') != "") {
			$keyword = $this->session->userdata('keyword');
			$query = $query->where('(a.product_name LIKE "%'.$keyword.'%" OR a.varian LIKE "%'.$keyword.'%" OR b.brand_name LIKE "%'.$keyword.'%" OR c.category_name LIKE "%'.$keyword.'%")');
		}
		$query = $query->get()->result();
	 	return $query;
	}
}

/* End of file */