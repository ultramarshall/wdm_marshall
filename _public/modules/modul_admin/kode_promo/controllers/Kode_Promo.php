<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kode_Promo extends BackendController {
	public function __construct()
	{
    	parent::__construct();
    	$this->set_Tbl_Master(_TBL_COUPON);

    	

		$this->addField(['field'=>'id', 'type'=>'int', 'show'=>false, 'help'=>false, 'size'=>4]);
		$this->addField(['field'=>'coupon', 'required'=>true, 'search'=>true]);
		$this->addField(['field'=>'cash_back', 'input'=>'float', 'type'=>'float', 'size'=>50]);

		$this->set_Field_Primary('id');
		$this->set_Join_Table(['pk'=>$this->tbl_master]);
		$this->set_Sort_Table($this->tbl_master, 'id', 'desc');

		$this->set_Bid(['nmtbl'=>$this->tbl_master,'field'=>'cash_back', 'span_right_addon'=>' Rp ', 'align'=>'left']);

		$this->set_Table_List($this->tbl_master,'coupon');
		$this->set_Table_List($this->tbl_master,'cash_back');


		$this->set_Close_Setting();

		
	}
	
}
/* End of file My_Account.php */