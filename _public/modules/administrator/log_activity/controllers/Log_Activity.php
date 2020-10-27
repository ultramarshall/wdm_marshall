<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Log_Activity extends BackendController {
	public function __construct()
	{
        parent::__construct();
		
		$this->set_Tbl_Master(_TBL_LOG);
		
		$this->addField(array('field'=>'id', 'show'=>false));
		$this->addField(array('field'=>'modul', 'size'=>20));
		$this->addField(array('field'=>'type', 'size'=>20));
		$this->addField(array('field'=>'http_referer', 'size'=>20));
		$this->addField(array('field'=>'http_user_agent', 'input'=>"multitext", 'size'=>20));
		$this->addField(array('field'=>'remote_addr', 'size'=>20));
		$this->addField(array('field'=>'request_uri', 'size'=>20));
		$this->addField(array('field'=>'user', 'size'=>20));
		$this->addField(array('field'=>'tgl_proses', 'size'=>20));
		$this->addField(array('field'=>'db_dump', 'input'=>"multitext", 'search'=>true, 'size'=>20));
		$this->addField(array('field'=>'new_data', 'input'=>"multitext", 'search'=>true, 'size'=>20));
		$this->addField(array('field'=>'old_data', 'input'=>"multitext", 'search'=>true, 'size'=>20));
		
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		$this->tmp_data['sort'][]=array('tbl'=>$this->tbl_master,'id'=>'tgl_proses', 'desc');
		
		$this->set_Table_List($this->tbl_master,'modul');
		$this->set_Table_List($this->tbl_master,'type');
		$this->set_Table_List($this->tbl_master,'request_uri',null,'30px');
		$this->set_Table_List($this->tbl_master,'user');
		$this->set_Table_List($this->tbl_master,'tgl_proses');
				
		$this->set_Close_Setting();
	}


}