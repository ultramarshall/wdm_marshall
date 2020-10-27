<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Operator extends BackendController {
	var $table="";
	var $post=array();
	var $sts_cetak=false;
	var $strmenu=array();
	public function __construct()
	{
        parent::__construct();
		$this->cbo_kelamin=$this->get_combo('kelamin');
		$this->cbo_kel=array(''=>' - pilih - ', '0'=>'Pusat', '1'=>'Provinsi', '2'=>'Kab/Kota', '3'=>'Kecamatan', '4'=>'Puskesmas', '5'=>'Rumah Sakit', '6'=>'Laboratorium', '7'=>'PHEOC');
		$this->cbo_kel_color=array('0'=>'#5557b6','1'=>'#cbc959','2'=>'#52a062','3'=>'#cb5561','4'=>'#f3a542','5'=>'#8fdad1','6'=>'#b47caf');
		$this->load->helper('file');
		$this->cbo_posisi = $this->get_combo('posisi');
		$this->set_Tbl_Master('users');
		$this->set_Table('modul');
		$this->set_Table('karyawan');
		
		$this->set_Open_Tab('Data Petugas');
			$this->addField(array('field'=>'id', 'show'=>false));
			if ($this->_Preference_['list_photo']==1)
				$this->addField(array('field'=>'photo', 'input'=>'upload', 'path'=>'staft', 'file_thumb'=>true));
			
			// $this->addField(array('field'=>'nip', 'required'=>false, 'search'=>true, 'size'=>20));
			$this->addField(array('field'=>'nama_lengkap', 'required'=>true, 'search'=>true, 'size'=>40));
			// $this->addField(array('field'=>'jabatan', 'type'=>'int', 'input'=>'combo', 'combo'=>$this->cbo_posisi, 'size'=>0, 'search'=>true));
			$this->addField(array('field'=>'gender', 'type'=>'int', 'input'=>'combo', 'combo'=>$this->cbo_kelamin, 'size'=>0, 'search'=>true));
			$this->addField(array('field'=>'hp', 'size'=>30));
			$this->addField(array('field'=>'email', 'size'=>30));
			// $this->addField(array('field'=>'catatan', 'input'=>'multitext', 'size'=>500));
			// $this->addField(array('field'=>'sts_email', 'input'=>'boolean'));
			// $this->addField(array('field'=>'sts_sms', 'input'=>'boolean'));
			$this->addField(array('field'=>'aktif', 'input'=>'boolean'));
			$this->addField(array('field'=>'user', 'type'=>'free','input'=>'free','mode'=>'o'));
			$this->addField(array('field'=>'is_admin', 'show'=>false));
			$this->addField(array('field'=>'last_activity_date', 'show'=>false));
			$this->addField(array('field'=>'last_visit_date', 'show'=>false));
			$this->addField(array('field'=>'need_approve', 'show'=>false));
			$this->addField(array('field'=>'last_visit', 'show'=>false));
		$this->set_Close_Tab();
		$this->set_Open_Tab('Data Login');
			$this->addField(array('field'=>'username', 'required'=>true, 'size'=>40));
			$this->addField(array('field'=>'password', 'input'=>'pass', 'size'=>20));
			$this->addField(array('field'=>'passwordc', 'type'=>'free', 'input'=>'pass', 'label'=>'l_passwordc'));
		$this->set_Close_Tab();
		
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		
		$this->set_Sort_Table($this->tbl_master,'nama_lengkap');
		
		if ($this->_Preference_['list_photo']==1)
			$this->set_Table_List($this->tbl_master,'photo','Photo',0,'center');
		// $this->set_Table_List($this->tbl_master,'nip');
		$this->set_Table_List($this->tbl_master,'username');
		$this->set_Table_List($this->tbl_master,'nama_lengkap');
		// $this->set_Table_List($this->tbl_master,'hp');
		// $this->set_Table_List($this->tbl_master,'email');
		// $this->set_Table_List($this->tbl_master,'is_admin');
		$this->set_Table_List($this->tbl_master,'last_activity_date');
		$this->set_Table_List($this->tbl_master,'last_visit_date');
		// $this->set_Table_List($this->tbl_master,'need_approve');
		// $this->set_Table_List($this->tbl_master,'last_visit');
		
		$this->set_Close_Setting();	
	}
	
	function searchBox_EWARN_USERS_ID_PLACE($fields, $post){
		$combo=$fields['input']['combo'];
		if (array_key_exists('q_kel_place',$post))
			$combo=$this->data->get_data_place($post['q_kel_place'], true);
		
		$content = $this->__search_Combo_Custom($fields, $post, $combo);
		return $content;
	}
	
	function listBox_KEL_PLACE($rows, $value){
		$isi="";
		if (array_key_exists($value, $this->cbo_kel)){
			$isi=$this->cbo_kel[$value];
			$isi = '<span style="background-color:'.$this->cbo_kel_color[$value].';padding:5px;color:#ffffff;"> '.$isi.' </span>';
		}
		return $isi;
	}
	
	function updateBox_ID_PLACE($field, $rows, $value){
		$kel = $rows['l_kel_place'];
		
		$field['input']['combo'] = $this->data->get_data_place($kel, true);
		$hasil = $this->add_Box_Input('combo:search', $field, $value);
		return $hasil;
	}
	
	function get_place_operator(){
		$id = $this->input->post('id');
		$data['combo']=$this->data->get_data_place($id);
		echo json_encode($data);
	}
	
	function reset_need_login(){
		$id = $this->uri->segment(3);
		if ($id>0){
			$result=$this->crud->crud_data(array('table'=>_TBL_USERS, 'field'=>array('need_approve'=>0,  'kode_login'=>''),'where'=>array('id'=>$id),'type'=>'update'));
		}
		header("Location:".base_url($this->modul_name));
	}
	
	function listBox_NEED_APPROVE($row, $value){
		$o="";
		if ($value=="1"){
			$o = '<a href="'.base_url($this->modul_name.'/reset-need-login/'.$row['l_id']).'"> reset </a>';
		}
		return $o;
	}
	
	function listBox_LAST_VISIT_DATE($row, $value){
		$o="";
		if (!empty($value))
			$o='<small>'.time_ago($value).'</small>';
		return $o;
	}
	
	function listBox_LAST_ACTIVITY_DATE($row, $value){
		$o="";
		if (!empty($value)){
			$o=time_ago($value);
			$o='<small><a href ="'.base_url($this->modul_name.'/monitoring/'.$row['l_id']).'" title="Click to monitoring">'.$o.'</a></small>';
		}
		return $o;
	}
	
	function monitoring(){
		$id=$this->uri->segment(3);
		$rows = $this->db->where('id', $id)->get(_TBL_VIEW_USERS)->row();
		$data['user']=(array) $rows;
		$rows = $this->db->where(_TBL_KNOWLEDGE_LOG.'.user_no', $id)->select(_TBL_KNOWLEDGE.'.*,'._TBL_KNOWLEDGE_LOG.'.create_date as tgl')->from(_TBL_KNOWLEDGE_LOG)->join(_TBL_KNOWLEDGE, _TBL_KNOWLEDGE_LOG.'.knowledge_no='._TBL_KNOWLEDGE.'.id')->get()->result_array();
		$data['activity']=$rows;
		$rows = $this->db->where(_TBL_KNOWLEDGE_FEEDBACK.'.user_no', $id)->select(_TBL_KNOWLEDGE.'.*,'._TBL_KNOWLEDGE_FEEDBACK.'.create_date as tgl')->from(_TBL_KNOWLEDGE_FEEDBACK)->join(_TBL_KNOWLEDGE, _TBL_KNOWLEDGE_FEEDBACK.'.knowledge_no='._TBL_KNOWLEDGE.'.id')->get()->result_array();
		$data['feedback']=$rows;
		$this->template->build('monitoring', $data);
	}
	
	function listBox_PHOTO($row, $value){
		$o="";
		if (!empty($value))
			$o=show_image($value,60, 0, 'staft', $row['l_id']);
		return $o;
	}
	
	
	function insertBox_USER($field){
		return $this->user_group(0);
	}
	
	function updateBox_USER($field, $row){
		return $this->user_group($row['l_id']);
	} 
	
	function user_group($id)
	{
		$data=$this->data->get_group($id);
		$data['angka']="10";
		$data['cbogroup']=$this->get_combo('groups');
		$result=$this->load->view('groups',$data,true);
		return $result;
	}
	
	function POST_CHECK_BEFORE_INSERT($data){
		$pesan="";
		$no=1;
		$result = $this->authentication->username_check($data['l_username']);
		if (!$result){
			$pesan = "<br/>" . $no . ". username - ".$data['l_username'].' - sudah digunakan';
			$no++;
		}
		
		if($data['l_password'] !== $data['l_passwordc']){
			$pesan .= "<br/>" . $no . ". Password tidak sama";
			$no++;
		}
		
		if(empty($data['l_password']) || empty($data['l_username'])){
			$pesan .= "<br/>" . $no . ". User name dan Password tidak boleh kosong";
			$no++;
		}
		
		if (!isset($data['id_edit'])){
			$pesan .= "<br/>" . $no . ". User minimal harus memiliki 1 group yang aktif";
			$no++;
		}
		
		if (!empty($pesan)){
			$this->session->set_userdata(array('result_proses_error'=>$pesan));
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	function POST_CHECK_BEFORE_UPDATE($new_data, $old_data){
		$result=true;
		if ($new_data['l_username'] !== $old_data['l_username'])
			$result = $this->authentication->username_check($new_data['l_username']);
		return $result;
	}
	
	function POST_INSERT_PROCESSOR($id , $new_data){
		$result=true;
		$result_gambar=false;
		$generate_pass = $this->authentication->set_password($new_data['l_password'], $id);
		
		if ($result)
			$result = $this->data->save_group($id , $new_data, $result_gambar);
		return $result;
	}
	
	function POST_UPDATE_PROCESSOR($id , $new_data, $old_data){
		$result=true;
		$result_img="";
		if (!empty($new_data['l_password'])){
			$result = $this->authentication->change_password($new_data['l_password'],'id',$id);
		}
		
		$now = new DateTime();
		$tgl= $now->format('Y-m-d H:i:s');
		
		if ($result)
			$result=$this->data->save_group($id , $new_data, $result_img);
		
		return $result;
	}

	function list_MANIPULATE_PERSONAL_ACTIONx($tombol, $rows){
		if ($rows['l_is_admin']=="1"){
			$tombol['tombol']=array();
			$tombol['default']=array();
		}
		return $tombol;
	}
	
	function CHANGE_PRIVILEGE($id, $privilege){
		if ($id==1) {
			$privilege['edit']=true;
			$privilege['delete']=false;
		}
		return $privilege;
	}
}