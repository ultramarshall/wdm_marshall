<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Profiles_Admin extends BackendController {
	var $table="";
	var $post=array();
	var $sts_cetak=false;
	public function __construct()
	{
        parent::__construct();
		$this->cbo_kelamin=$this->get_combo('kelamin');
		$this->load->helper('file');
		$this->set_Tbl_Master('users');
		$this->set_Table('karyawan');
		
		$this->addField(array('field'=>'id', 'show'=>false));
		if ($this->_Preference_['list_photo']==1)
				$this->addField(array('field'=>'photo', 'input'=>'upload', 'path'=>'staft', 'file_thumb'=>true));
		$this->addField(array('field'=>'nip', 'required'=>false, 'search'=>true, 'size'=>20));
		$this->addField(array('field'=>'nama_lengkap', 'required'=>true, 'search'=>true, 'size'=>40));
		$this->addField(array('field'=>'gender', 'type'=>'int', 'input'=>'combo', 'combo'=>$this->cbo_kelamin, 'size'=>100, 'search'=>true));
		$this->addField(array('field'=>'hp', 'size'=>30));
		$this->addField(array('field'=>'email', 'size'=>30));
	
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		$this->tmp_data['sort'][]=array('tbl'=>$this->tbl_master,'id'=>'nama_lengkap');
		
		$this->set_Table_List($this->tbl_master,'nik');
		$this->set_Table_List($this->tbl_master,'nama_lengkap');
		$this->set_Close_Setting();
		
		$this->_set_ACTION('edit');
		$this->_SET_PRIVILEGE('tombol_quit', false);
		$this->_SET_PRIVILEGE('tombol_save_quit', false);
	}
	
	public function index()
	{	
		$this->__edit($this->authentication->get_Info_User('identifier'));
	}
	
	function POST_UPDATE_REDIRECT_URL($url){
		$url = base_url($this->_Snippets_['modul']);
		return $url;
	}
	
}