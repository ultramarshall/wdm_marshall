<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	public function __construct()
	{
		parent::__construct();
		$this->midtrans->config([
    		'server_key' => $this->authentication->get_Preference('server_key'), 
    		'production' => (bool)$this->authentication->get_Preference('production')
    	]);
	}

	function get_address() {
		return $this->db->get(_TBL_ADDRESS_BOOK)->result();
	}

	function get_order() {
		$orders = $this->db->where('create_user', $this->authentication->get_Info_User('username'))
						   ->order_by('create_date', 'desc')
						   ->get(_TBL_ORDER, 5)
						   ->result();
		foreach ($orders as $i => $row) {
			$orders[$i]->midtrans = $this->midtrans->status($row->order_id);
		}
		return (object)$orders;
	}
 
	function count_order(){
		return $this->db->where('create_user', $this->authentication->get_Info_User('username'))
					    ->order_by('create_date', 'desc')	
						->get(_TBL_ORDER)
						->num_rows();
	}
}

/* End of file */