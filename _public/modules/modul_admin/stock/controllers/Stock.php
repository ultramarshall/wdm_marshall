<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stock extends BackendController {
	public function __construct()
	{
    	parent::__construct();
    	$this->set_Tbl_Master(_TBL_TEST_STOCK);

		$this->set_Open_Tab(lang('msg_tab_1'),'home2');
			$this->addField(['field'=>'id', 'type'=>'int', 'show'=>false, 'help'=>false, 'size'=>4]);
			$this->addField(['field'=>'item_code', 'input'=>'text', 'search'=> true]);
			$this->addField(['field'=>'item_name', 'input'=>'text', 'search'=> true]);
			$this->addField(['field'=>'item_qty', 'input'=>'text']);
			$this->addField(['field'=>'item_price', 'input'=>'text']);
			$this->set_Close_Tab();

		$this->set_Field_Primary('id');
		$this->set_Join_Table(['pk'=>$this->tbl_master]);

		$this->set_Table_List($this->tbl_master,'sts', 'Status');
		$this->set_Table_List($this->tbl_master,'item_code');
		$this->set_Table_List($this->tbl_master,'item_name');
		$this->set_Table_List($this->tbl_master,'item_qty');
		$this->set_Table_List($this->tbl_master,'item_price');

		$this->set_Close_Setting();

	}

	function listBox_STS($row, $value) {
		// $result = ($row['l_item_qty']==0)?'NOT AVAILABLE':'AVAILABLE';
		

		$result = '';
		if ($row['l_item_qty']==0) {
			$result .= '<div class="col text-danger">'.
						'<i class="fa fa-info-circle fa-fw"></i>'.
						'<span>NOT AVAILABLE</span>'.
					  '</div>';
		} else {
			$result .= '<div class="col text-success">'.
						'<a href="#z,3">'.
							'<i class="fa fa-check fa-fw"></i>&nbsp;'.
							'<span>AVAILABLE</span>'.
						'</a>'.
					  '</div>';

		}
		return $result;
	}

}
