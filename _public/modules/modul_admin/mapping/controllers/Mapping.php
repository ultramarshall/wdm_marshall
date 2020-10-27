<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mapping extends BackendController {
	public function __construct()
	{
    	parent::__construct();
    	$this->set_Tbl_Master(_TBL_CUSTOMERS);

		$this->set_Open_Tab(lang('msg_tab_1'),'home2');
			$this->addField(['field'=>'id', 'type'=>'int', 'show'=>false, 'help'=>false, 'size'=>4]);
			$this->addField(['field'=>'customer_no', 'input'=>'text']);
			$this->addField(['field'=>'customer_name', 'input'=>'text']);
			$this->addField(['field'=>'create_date', 'input'=>'text']);
		$this->set_Close_Tab();

		$this->set_Field_Primary('id');
		$this->set_Join_Table(['pk'=>$this->tbl_master]);

		/* table view */
		// $this->set_Table_List($this->tbl_master,'create_date','Date',14);
		$this->set_Table_List($this->tbl_master,'customer_name', 'Customer');
		$this->set_Table_List($this->tbl_master,'customer_name', 'Name');
		$this->set_Table_List($this->tbl_master,'npwp', 'NPWP');

		$this->set_Close_Setting();
	}
	
	function listBox_NPWP($row, $value){
		return '<div class="text-center">'.
					'<button class="btn bg-danger btn-sm text-white">'.
						'<i class="fa fa-upload fa-fw"></i>&nbsp;'.
						'upload'.
					'</button>'.
				'</div>';
	}

}
