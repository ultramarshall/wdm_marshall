<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	public function __construct()
	{
		parent::__construct();
	}

	function get_product_comments($id) {
		$this->db->select('b.photo,
						   a.create_user as username, 
						   b.nama_lengkap as nama, 
						   a.comment, 
						   a.create_date');
	    $this->db->from(_TBL_COMMENT . ' a'); 
	    $this->db->join(_TBL_USERS . ' b', 'b.username=a.create_user');
	    $this->db->where('a.product_id',$id);
	    $this->db->order_by('a.create_date','asc');         
	    return $this->db->get()->result(); 
	}

	function post_comments($data) {
		$field = [
			'product_id' => $data['id'],
			'comment' => $data['komentar'],
			'create_user' => $this->authentication->get_Info_User('username'),
		];
		return $this->crud->crud_data([
			'table'=>_TBL_COMMENT,
			'field'=>$field,
			'type'=>'add'
		]);
	}
}

/* End of file */