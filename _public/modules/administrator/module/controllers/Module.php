<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Module extends BackendController {
	var $table="";
	var $post=array();
	var $sts_cetak=false;
	var $output_parent=array();
	public function __construct()
	{
        parent::__construct();
		$this->set_Tbl_Master(_TBL_MODUL);
		$this->set_Table(_TBL_FONT_ICON);
		
		$this->arr_icons=$this->get_combo('icon');
		$this->arr_positions=$this->get_combo('posisi-menu');

		$this->set_Open_Tab('Data Module');
			$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'size'=>4));
			$this->addField(array('field'=>'pid', 'input'=>'combo', 'combo'=>$this->get_combo_parent(), 'search'=>true, 'size'=>20));
			$this->addField(array('field'=>'icon', 'input'=>'combo:search', 'combo'=>$this->arr_icons, 'search'=>true, 'size'=>20));
			$this->addField(array('field'=>'nm_modul', 'required'=>true, 'search'=>true, 'size'=>50));
			$this->addField(array('field'=>'title', 'required'=>true, 'search'=>true, 'size'=>50));
			$this->addField(array('field'=>'posisi', 'input'=>'combo', 'combo'=>$this->arr_positions, 'search'=>true, 'size'=>20));
			$this->addField(array('field'=>'urut', 'input'=>'updown', 'size'=>70));
			$this->addField(array('field'=>'aktif', 'input'=>'boolean', 'size'=>20));
		$this->set_Close_Tab();
		
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		
		$this->set_Sort_Table($this->tbl_master,'id');
		
		$this->set_Table_List($this->tbl_master,'title');
		$this->set_Table_List($this->tbl_master,'nm_modul');
		$this->set_Table_List($this->tbl_master,'icon');
		$this->set_Table_List($this->tbl_master,'posisi');
		$this->set_Table_List($this->tbl_master,'urut');
		$this->set_Table_List($this->tbl_master,'aktif','',7, 'center');
		
		$this->set_Close_Setting();

		$js = '<script src="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.js"></script>';
		$this->template->append_metadata($js);
	}
	
	function index(){
		$this->menu_posisi();
	}
	
	function list_MANIPULATE_ACTION(){
		$tombol['urut']='<a class="add btn btn-primary" href="'.base_url($this->modul_name.'/menu-posisi').'" data-toggle="popover" data-content="Atur Menu Posisi"><i class="icon-list"></i> Edit All </a>&nbsp;&nbsp;';
		return $tombol;
	}
	
	function get_combo_parent(){
		$data=$this->data->get_data_posisi_menu();
		$this->output_parent = array(0=>' - Parent - ');
		foreach($data as $row){
			$this->buildItem_parent($row);
		}
		return $this->output_parent;
	}
	
	function menu_posisi(){
		$this->_SET_PRIVILEGE('add', true);
		$this->_SET_PRIVILEGE('tombol_quit', true);
		$this->_SET_PRIVILEGE('tombol_save_quit', false);
		$data = $this->input->post();
		if ($data){
			$this->simpan_nilai($data);
		}else{
			$data['field']=$this->data->get_data_posisi_menu();
			$outpute = '';
			foreach($data['field'] as $row){
				$outpute .= $this->buildItem($row);
			}
			// die('end');
			$data['tree'] = $outpute;
			$data['source_tree'] = json_encode($data['field']);
			$tombol = $this->_get_list_action_button();
			$data['action']=$tombol;
			$this->template->build('modul',$data); 
		}
	}
	
	function buildItem($ad) {
		$aktif = '';
		if($ad['aktif']==0){
			$aktif=" <i class='icon-x text-danger aktif'></i>";
		}
		
		$html = "<li class='dd-item dd3-item' data-id='" . $ad['id'] . "'>";
		$html .= "<div class='dd-handle dd3-handle'></div><div class='dd3-content'>".
					 	"<i class='icon ".$ad['icon']." fa-fw'></i>&nbsp;&nbsp;".
						"<span class='judul text-primary'>". 
							$ad['title'] . $aktif . 
						"</span> 
						<span class='pull-right' style='margin-top:0px;'>
							<a href='".base_url($this->modul_name.'/edit/'.$ad['id'])."' class='edit_modul'>
								<i class='fa fa-pencil-square-o'></i>
							</a>
							<a href='".base_url($this->modul_name.'/delete/'.$ad['id'])."' class='delete_modul'>
								<i class='fa fa-trash-o'></i>
							</a>
						</span>
				  </div>";
		if (array_key_exists('children', $ad)) {	
			$html .= "<ol class='dd-list'>";
			foreach($ad['children'] as $row){
				$html .= $this->buildItem($row);
			}
			$html .= "</ol>";
		}	
		$html .= "</li>";
		return $html;
	}
	
	function buildItem_parent($ad, $level=0) {
		$space = str_repeat('&nbsp;',$level*6);
		$this->output_parent[$ad['id']]=$space . $ad['title'];
		if (array_key_exists('children', $ad)) {	
			++$level;
			foreach($ad['children'] as $row){
				$this->buildItem_parent($row, $level);
			}
		}
		$level=0;
	}
	
	function simpan_nilai($post){
		$result = $this->data->simpan_data($post);
		$this->logdata->_save_log_data();
		unset($_POST);
		if ($post['l_save']=="Simpan"){
			header('location:'.base_url($this->uri->uri_string));
		}else{
			header('location:'.base_url($this->modul_name));
		}
		exit();
	}
	
	function listBox_ICON($row, $value){
		$o="<i class='$value'></i>";
		return $o;
	}
	
	function listBox_AKTIF($row, $value){
		if ($value=='1')
			$result='<span class="label label-success"> '.lang('msg_cbo_yes').'</span>';
		else
			$result='<span class="label label-warning"> '.lang('msg_cbo_no').'</span>';
		
		return $result;
	}
	
	function POST_INSERT_PROCESSOR($id , $new_data){
		$this->authentication->set_Menu_Navigator();
		
		return true;
	}
	
	function POST_UPDATE_PROCESSOR($id , $new_data, $old_data){
		$this->authentication->set_Menu_Navigator();
		
		return true;
	}
}