<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Setting extends BackendController {
	var $table="";
	var $post=array();
	var $sts_cetak=false;
	public function __construct()
	{
        parent::__construct();
		$this->set_Tbl_Master('preference');
		
		$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'help'=>false, 'size'=>4));
		$this->set_Open_Tab(lang('msg_tab_1'),'home2');
			$this->addField(array('field'=>'nama_kantor', 'input'=>'multitext', 'required'=>true, 'size'=>250));
			$this->addField(array('field'=>'alamat_kantor', 'input'=>'multitext', 'size'=>250));
			$this->addField(array('field'=>'telp_kantor', 'size'=>20));
			$this->addField(array('field'=>'fax_kantor', 'size'=>20));
			$this->addField(array('field'=>'email_kantor', 'size'=>40));
			$this->addField(array('field'=>'web_kantor', 'size'=>40));
			$this->addField(array('field'=>'logo_kantor', 'size'=>40));
			$this->addField(array('field'=>'nama_pimpinan', 'size'=>40));
			$this->addField(array('field'=>'bahasa', 'size'=>40));
			$this->addField(array('field'=>'judul_atas', 'size'=>60));
			$this->addField(array('field'=>'judul_bawah', 'input'=>'multitext', 'size'=>500));
			$this->addField(array('field'=>'sts_app', 'size'=>20, 'input'=>'boolean'));
			$this->addField(array('field'=>'help_tool', 'size'=>20, 'input'=>'boolean'));
			$this->addField(array('field'=>'help_popup', 'size'=>20, 'input'=>'boolean'));
			$this->addField(array('field'=>'status_log', 'size'=>20, 'input'=>'boolean'));
			// $this->addField(array('field'=>'notif_pos', 'size'=>20, 'input'=>'combo', 'combo'=>array(''=>'-','kiri'=>'kiri','kanan'=>'kanan')));
			$this->addField(array('field'=>'icon_tombol', 'size'=>20, 'input'=>'boolean'));
			$this->addField(array('field'=>'list_photo', 'size'=>20, 'input'=>'boolean'));
			$this->addField(array('field'=>'upload_type', 'size'=>30, ));
			$this->addField(array('field'=>'upload_size', 'size'=>20, ));
		$this->set_Close_Tab();
		$this->set_Open_Tab(lang('msg_tab_2'),'home');
			$this->addField(array('field'=>'email_smtp_host', 'size'=>40));
			$this->addField(array('field'=>'email_smtp_port', 'size'=>40));
			$this->addField(array('field'=>'email_smtp_user', 'size'=>40));
			$this->addField(array('field'=>'email_smtp_pass', 'size'=>40));
		$this->set_Close_Tab();
		$this->set_Open_Tab(lang('msg_tab_3'));
			$this->addField(array('field'=>'pass_min', 'input'=>'updown', 'size'=>90));
			$this->addField(array('field'=>'pass_max', 'input'=>'updown', 'size'=>90));
			$this->addField(array('field'=>'pass_letter', 'input'=>'boolean', 'size'=>40));
			$this->addField(array('field'=>'pass_number', 'input'=>'boolean', 'size'=>40));
			$this->addField(array('field'=>'pass_lower', 'input'=>'boolean', 'size'=>40));
			$this->addField(array('field'=>'pass_upper', 'input'=>'boolean', 'size'=>40));
			$this->addField(array('field'=>'pass_symbol', 'input'=>'boolean', 'size'=>40));
			$this->addField(array('field'=>'notif_email', 'input'=>'boolean', 'size'=>40));
			$this->addField(array('field'=>'notif_email_waktu', 'size'=>10));
			$this->addField(array('field'=>'password_expr_sts', 'input'=>'boolean', 'size'=>40));
			$this->addField(array('field'=>'password_expr', 'size'=>10));
		$this->set_Close_Tab();
		$this->set_Open_Tab(lang('msg_tab_4'));
			$this->addField(array('field'=>'gambar_background', 'save'=>false, 'size'=>10, 'mode'=>'a'));
		$this->set_Close_Tab();
		
		
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		
		$this->set_Bid(array('nmtbl'=>$this->tbl_master,'field'=>'upload_size', 'span_left_addon'=>' Kb ', 'align'=>'center'));
		$this->set_Bid(array('nmtbl'=>$this->tbl_master,'field'=>'notif_email_waktu', 'span_left_addon'=>' hari ', 'align'=>'center'));
		$this->set_Bid(array('nmtbl'=>$this->tbl_master,'field'=>'password_expr', 'span_left_addon'=>' hari ', 'align'=>'center'));
		$this->data_fields['master']=$this->tmp_data;
		
		$this->_SET_PRIVILEGE('tombol_save_quit', false);
		$this->_SET_PRIVILEGE('tombol_add', false);
		$this->_SET_PRIVILEGE('tombol_quit', false);
		
		if ($x=$this->input->post())
			$this->post=$this->input->post();
		elseif ($x=$this->session->userdata('_'.$this->_Snippets_['modul'].'_search_')){
			$this->post=$this->session->userdata('_'.$this->_Snippets_['modul'].'_search_');
		}
		
		$js= script_tag(plugin_url("ckeditor/ckeditor.js"));
		
		$js .= '<script> 
				var url = "'.base_url().'";
				CKEDITOR.replace("editor1",
				{
					filebrowserBrowseUrl  : url + "ajax/media?type=Images",
					filebrowserUploadUrl  : url +  "ajax/upload?type=Images",
					toolbar : "Full", /* this does the magic */
					uiColor : "#9AB8F3"
				});
				
				CKEDITOR.stylesSet.add( "my_styles_custom",
				[
					// Block-level styles
					{ name : "huruf", element : "body", styles : { "font-family" : "Helvetica,Arial,sans-serif" } },
					{ name : "Red Title" , element : "h3", styles : { "color" : "Red" } },
				]);
				</script>';
		$this->template->append_metadata($js);
	}
	
	public function index()
	{	
		$this->mode_action='edit';
		$this->__edit(1);
	}
	
	
	function updateBox_GAMBAR_BACKGROUND($field, $rows, $value){
		$value=json_decode($value, true);
		// Doi::dump($value);die();
		$hasil = $this->load->view("latar", array('latar'=>$value), true);
		return $hasil;
	}
	
	function postData_SOURCE_UPDATE(){
		$result=$this->data->get_data();
		return $result;
	}
	
	function POST_UPDATE_HANDLE($data, $old_data){
		$result=$this->data->save_data($data, $old_data);
		return $result;
	}
	
	public function MANIPULATE_BUTTON_ACTION($tombol=array())
	{
		$this->_tombol['add']='';
		$this->_tombol['add_input']='';
		$this->_tombol['savequit']='';
		$this->_tombol['act_personal']['default']['edit']=array('url'=>base_url($this->_Snippets_['modul'].'/reply'),'label'=>'Reply');
		$tbl=$this->_tombol;
		return $tbl;
	}
	
	function POST_UPDATE_REDIRECT_URL($url){
		$url = base_url($this->_Snippets_['modul']);
		return $url;
	}
}