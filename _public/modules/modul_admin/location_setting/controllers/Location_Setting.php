<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//NamaTbl, NmFields, NmTitle, Type, input, required, search, help, isiedit, size, label 
//$tbl, 'id', 'id', 'int', false, false, false, true, 0, 4, 'l_id'

class Location_Setting extends BackendController {
	var $table="";
	var $post=array();
	var $sts_cetak=false;
	public function __construct()
	{
        parent::__construct();
		$this->set_Tbl_Master('preference');
		$this->provinsi = json_decode($this->rajaongkir->province())->rajaongkir->results;
		$provinsi = [];
		foreach ($this->provinsi as $key => $value) {
			$provinsi[$value->province_id] = $value->province;
		}

		$this->addField(array('field'=>'id', 'type'=>'int', 'show'=>false, 'help'=>false, 'size'=>4));
		$this->addField(['field'=>'provinsi', 'input'=>'combo:search', 'combo'=>$provinsi, 'search'=>false, 'size'=>20]);
		$this->addField(['field'=>'kota', 'input'=>'combo:search', 'combo'=>[], 'search'=>false, 'size'=>20]);
		$this->addField(['field'=>'kecamatan', 'input'=>'combo:search', 'combo'=>[], 'search'=>false, 'size'=>20]);
		
		
		
		$this->set_Field_Primary('id');
		$this->set_Join_Table(array('pk'=>$this->tbl_master));
		$this->data_fields['master']=$this->tmp_data;
		
		$this->_SET_PRIVILEGE('tombol_save_quit', false);
		$this->_SET_PRIVILEGE('tombol_add', false);
		$this->_SET_PRIVILEGE('tombol_quit', false);

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

	public function get_city()
	{
		$id = $this->input->post('id');
		echo $this->rajaongkir->city($id);
	}

	public function get_subdistrict()
	{
		$id = $this->input->post('id');
		echo $this->rajaongkir->subdistrict($id);
	}
	public function get_subdistrict()
	{
		dd($this->rajaongkir->city());
		$id = $this->input->post('id');
		echo $this->rajaongkir->subdistrict($id);
	}


}