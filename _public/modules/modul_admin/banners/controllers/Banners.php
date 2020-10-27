<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Banners extends BackendController {
	public function __construct()
	{
    	parent::__construct();
    	$this->set_Tbl_Master(_TBL_BANNER);

		$this->set_Open_Tab(lang('msg_tab_1'),'home2');
			$this->addField(['field'=>'id', 'type'=>'int', 'show'=>false, 'help'=>false, 'size'=>4]);
			$this->addField(['field'=>'banner_logo', 'input'=>'upload', 'path'=>'staft', 'file_thumb'=>true]);
			$this->addField(['field'=>'banner_name', 'required'=>true, 'search'=>true]);
			$this->addField(['field'=>'banner_detail', 'input'=>'multitext', 'size'=>50]);
		$this->set_Close_Tab();

		$this->set_Field_Primary('id');
		$this->set_Join_Table(['pk'=>$this->tbl_master]);

		/* table view */
		$this->set_Table_List($this->tbl_master,'banner_logo','Banner',20);
		$this->set_Table_List($this->tbl_master,'banner_name');

		$this->set_Close_Setting();
	}
	
	function listBox_BANNER_LOGO($row, $value){
		return show_image($value,60, 0, 'staft', $row['l_id'], '', 'pl-2');
	}
}
/* End of file My_Account.php */