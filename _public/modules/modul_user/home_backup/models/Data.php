<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	public function __construct()
	{
		parent::__construct();
	}

	function get_banner() {
		return $this->db->get(_TBL_BANNER)->result();
	}

	function get_brand() {
		return $this->db->get(_TBL_BRAND)->result();
	}

	function get_product() {
		return $this->db->get(_TBL_PRODUK)->result();
	}

	function get_categories() {
		return $this->db->get(_TBL_CATEGORY)->result();
	}

	function get_highlight_product() {
		return $this->db->where('is_hightlight',1)->get(_TBL_PRODUK)->result();
	}

	function get_flashsale_product() {
		$flashsale = $this->db->query('SELECT * FROM tbl_flashsale WHERE start_period <= NOW() AND NOW() <= end_period')->row();
		if (!$flashsale) {
			$end_event = 0;
		} else {
			$end_event = strtotime($flashsale->end_period) - strtotime(doi::now('full'));
			$product_id = array_map('intval', explode(',', $flashsale->flashsale_product ));
			$product = $this->db->where_in('id', $product_id)->get(_TBL_PRODUK)->result();
		}
		
		return (object)[
			'end_event'=>$end_event, 
			'product_sale'=>$product
		];
	}
}

/* End of file */