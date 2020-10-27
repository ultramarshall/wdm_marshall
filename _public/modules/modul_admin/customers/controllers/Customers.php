<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customers extends BackendController {
	public function __construct()
	{
    	parent::__construct();
    	$this->set_Tbl_Master(_TBL_TEST_CUSTOMERS);

		$this->set_Open_Tab(lang('msg_tab_1'),'home2');
			$this->addField(['field'=>'id', 'type'=>'int', 'show'=>false, 'help'=>false, 'size'=>4]);
			$this->addField(['field'=>'customer_no', 'input'=>'text', 'search'=> true]);
			$this->addField(['field'=>'customer_name', 'input'=>'text']);
			$this->addField(['field'=>'create_date', 'input'=>'datetime']);
			$this->set_Close_Tab();

		$this->set_Field_Primary('id');
		$this->set_Join_Table(['pk'=>$this->tbl_master]);

		$this->set_Table_List($this->tbl_master,'customer_no','Customer No',14);
		$this->set_Table_List($this->tbl_master,'customer_name', 'Customer Name');
		$this->set_Table_List($this->tbl_master,'create_date','Date',14);
		// $this->set_Table_List($this->tbl_master,'invoice_no', 'Invoive No');
		// $this->set_Table_List($this->tbl_master,'settlement_no', 'Settlement No');
		// $this->set_Table_List($this->tbl_master,'pdf', 'File Faktur');

		// $this->_SET_PRIVILEGE('add', false);
		// $this->_SET_PRIVILEGE('edit', false);
		// $this->_SET_PRIVILEGE('cetak', false);
		// $this->_SET_PRIVILEGE('delete', true);

		$this->set_Close_Setting();

	}

	// public function upload_excel() {
	// 	$post = $this->input->post();
	// 	$data = $post['Sheets1'];
	// 	unset($data[0]);
	// 	if ($data) {
	// 		$dataDb = [];
	// 		foreach ($data as $item) {
	// 			array_push($dataDb, [
	// 				'settlement_no' => $item[0],
	// 				'invoice_no' => $item[1],
	// 				'customer_no' => $item[2],
	// 				'customer_name' => $item[3],
	// 			]);
	// 		}
	// 		if ($this->db->insert_batch('bangga_customers', $dataDb)) {
	// 			echo json_encode(true);
	// 		} else {
	// 			echo json_encode(false);
	// 		}
	// 	} else {
	// 		echo json_encode(false);
	// 	}
	// }

	function listBox_PDF($row, $value) {
		$result = '';
		if (isset($value)) {
			$result .= '<div class="col text-primary">'.
						'<a href="#z,3">'.
							'<i class="fa fa-file-pdf-o fa-fw text-danger"></i>&nbsp;'.
							'<span>'.$value.'</span>'.
						'</a>'.
					  '</div>';
		} else {
			$result .= '<div class="col text-danger">'.
						'<i class="fa fa-info-circle fa-fw"></i>'.
						'<span>Need to be upload</span>'.
					  '</div>';

		}
		return $result;
	}
	

}
