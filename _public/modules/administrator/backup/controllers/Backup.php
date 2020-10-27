<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Backup extends BackendController {
	var $jml_pemakai=array();
	public function __construct()
	{
        parent::__construct();
		$this->set_Tbl_Master('backup');
		
		$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
		$this->addField(array('field'=>'bank', 'required'=>true, 'search'=>true, 'size'=>30));
		$this->addField(array('field'=>'no_rek', 'search'=>true, 'size'=>30));
		$this->addField(array('field'=>'atas_nama', 'search'=>true, 'size'=>30));
		$this->addField(array('field'=>'keterangan', 'input'=>'multitext', 'search'=>true, 'size'=>60));
		$this->addField(array('field'=>'aktif', 'type'=>'int', 'input'=>'boolean', 'search'=>true, 'size'=>20));
		
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		$this->set_Sort_Table($this->tbl_master,'bank', 'desc');
		$this->set_Table_List($this->tbl_master,'bank');
		$this->set_Table_List($this->tbl_master,'no_rek');
		$this->set_Table_List($this->tbl_master,'atas_nama');
		$this->set_Table_List($this->tbl_master,'aktif','',10);
		
		$this->set_Close_Setting();
	}
	
	function MASTER_DATA_LIST($id){
		$this->jml_pemakai=$this->data->get_data_pemakai($id);
	}
	
	function list_MANIPULATE_PERSONAL_ACTION($tombol, $row){	
		$jml=0;
		if (array_key_exists($row['l_id'], $this->jml_pemakai)){
			$jml=$this->jml_pemakai[$row['l_id']];
		}
		if ($jml>0){$tombol['delete']=array();}
		return $tombol;
	}
}