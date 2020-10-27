<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Groups extends BackendController {
	var $table="";
	var $post=array();
	var $sts_cetak=false;
	public function __construct()
	{
        parent::__construct();
		$this->cbo_dashboard=$this->get_combo('dashboard');
		$this->privilege_owner=$this->get_combo('privilege-owner');
		$this->set_Tbl_Master('groups');
		
		$this->set_Open_Tab('Data Petugas');
			$this->addField(array('field'=>'id', 'show'=>false));
			$this->addField(array('field'=>'group_name', 'size'=>30, 'required'=>true, 'search'=>true));
			// $this->addField(array('field'=>'dashboard', 'type'=>'int', 'input'=>'combo', 'combo'=>$this->cbo_dashboard, 'size'=>0, 'show'=>true));
			// $this->addField(array('field'=>'privilege_owner', 'type'=>'int', 'input'=>'combo', 'combo'=>$this->privilege_owner, 'size'=>0, 'required'=>true, 'search'=>true));
			// $this->addField(array('field'=>'note', 'input'=>'multitext', 'size'=>500));
			$this->addField(array('field'=>'aktif', 'input'=>'boolean', 'size'=>40, 'required'=>true));
			$this->addField(array('field'=>'privilege', 'type'=>'free', 'input'=>'free', 'mode'=>'o', 'size'=>100));
		$this->set_Close_Tab();
			
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		
		$this->set_Sort_Table($this->tbl_master,'group_name');
		
		$this->set_Table_List($this->tbl_master,'group_name');
		// $this->set_Table_List($this->tbl_master,'dashboard','',20,'center');
		$this->set_Table_List($this->tbl_master,'aktif','',8,'center');
		
		$this->set_Close_Setting();
	}
	
	function listBox_AKTIF($row, $value){
		if ($value=='1')
			$result='<span class="label label-primary"> '.lang('msg_cbo_yes').'</span>';
		else
			$result='<span class="label label-danger"> '.lang('msg_cbo_no').'</span>';
		
		return $result;
	}
	
	function listBox_DASHBOARD($rows, $value){
		if (array_key_exists($value, $this->cbo_dashboard))
			$value = $this->cbo_dashboard[$value];
		return $value;
	}
	
	function get_param(){
		$_GET['id']=intval($this->uri->segment(3));
		$data=$this->data->get_param($_GET['id']);
		$result=$this->load->view('groups/param',$data,true);
		return $result;
	}
	
	function insertBox_PRIVILEGE($field){
		$return = $this->previlege();
		return $return;
	}
	
	function updateBox_PRIVILEGE($field, $rows, $value){
		$return = $this->previlege();
		return $return;
	}
	
	function previlege()
	{
		$_GET['id']=$this->uri->segment(3);
		$data=$this->data->get_modul($_GET['id']);
		$result=$this->load->view('groups/previlege',$data,true);
		return $result;
	}
	
	function POST_INSERT_PROCESSOR($id , $new_data){
		$result = $this->data->save_privilege($id , $new_data);
		if (!$result)
			return $result;
		
		return $result;
	}
	
	function POST_UPDATE_PROCESSOR($id , $new_data, $old_data){
		$result = $this->data->save_privilege($id , $new_data, $old_data);
		if (!$result)
			return $result;
		
		return $result;
	}
}