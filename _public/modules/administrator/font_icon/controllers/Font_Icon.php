<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Font_Icon extends BackendController {
	public function __construct()
	{
         parent::__construct();
		$this->set_Tbl_Master(_TBL_FONT_ICON);
		
		$this->set_Open_Tab('Font Icon');
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			$this->addField(array('field'=>'title', 'size'=>50, 'search'=>true));
			$this->addField(array('field'=>'font', 'size'=>50, 'search'=>true));
		$this->set_Close_Tab();
			
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		
		$this->set_Sort_Table($this->tbl_master,'id');
		
		$this->set_Table_List($this->tbl_master,'font', '', 2);
		$this->set_Table_List($this->tbl_master,'title', 'class name');
		
		$this->set_Close_Setting();
		
	}

	function listBox_FONT($row, $value)
	{
		$value = '<i class="icon '.$value.' red-text" style="font-size: 2.5em"></i>';
		return $value;
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */