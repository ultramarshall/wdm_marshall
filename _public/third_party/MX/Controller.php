<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/** load the CI class for Modular Extensions **/
require dirname(__FILE__).'/Base.php';

/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 * @link	http://codeigniter.com
 *
 * Description:
 * This library replaces the CodeIgniter Controller class
 * and adds features allowing use of modules and the HMVC design pattern.
 *
 * Install this file as application/third_party/MX/Controller.php
 *
 * @copyright	Copyright (c) 2015 Wiredesignz
 * @version 	5.5
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/
class MX_Controller 
{
	public $autoload = array();
	public $modul_name="dashboard";
	public $_Preference_=array();
	public $_Snippets_=array();
	public $_param_list_=array();
	protected $mode_action="";
	
	public function __construct() 
	{
		$sts_app = $this->authentication->get_Preference('sts_app');
		define('_STS_APP_', ucwords($sts_app));
		$class = str_replace(CI::$APP->config->item('controller_suffix'), '', get_class($this));
		log_message('debug', $class." MX_Controller Initialized");
		Modules::$registry[strtolower($class)] = $this;	
		
		/* copy a loader instance and initialize */
		$this->load = clone load_class('Loader');
		$this->load->initialize($this);	
		
		// Doi::dump($this->session->all_userdata());
		/* autoload module items */
		$this->load->_autoloader($this->autoload);
					
		$lock_screen=$this->session->userdata('lock_screen');
		if ($lock_screen  && $this->router->fetch_module()!=='lock_screen')
			header('location:'.base_url().'lock-screen');
		
		$this->_Preference_=$this->authentication->get_Preference();
		$this->_Group_=$this->authentication->get_Info_User('group');
		
		$this->_Snippets_['modul']=str_replace('_','-',$this->router->fetch_module());
		$this->_Snippets_['method']=$this->router->fetch_method();
		$this->_Snippets_['class']=$this->router->fetch_class();
		$this->_Snippets_['uri']=explode("/",$this->uri->uri_string);
		$this->_param_list_['breadcrumb']=$this->_Snippets_['uri'];
		$this->modul_name = $this->_Snippets_['modul'];
		$this->mode_action = $this->_Snippets_['method'];
		define('_MODULE_NAME_', ucwords($this->modul_name));
		define('_MODULE_NAME_REAL_', $this->router->fetch_module());
		define('_METHOD_', $this->_Snippets_['method']);
		define('_MODE_', strtolower($this->uri->segment(2)));
		// define('_TAHUN_', $this->_Preference_['tahun']['nama']);
		// define('_TAHUN_NO_', $this->_Preference_['tahun']['id']);
		// define('_TERM_NO_', $this->_Preference_['term']['id']);
		// define('_TERM_', $this->_Preference_['term']['nama']);
		$this->set_Define_Table();
		if ($this->session->userdata('bahasa')=='')
			$bahasa=$this->config->item('language');
		else
			$bahasa=$this->session->userdata('bahasa');
		
		foreach (Modules::$locations as $location => $offset) {
			if (file_exists($location.$this->router->fetch_module().'/config/var.php'))
			{
				$this->config->load('var');
				break;
			}
		}
		
		define('_BAHASA_', $bahasa);
		$arr_bahasa=array('datatable', 'tombol', 'umum',  'pesan','validation', 'modul', 'help', $this->router->fetch_module());
		foreach($arr_bahasa as $bhs){
			if (file_exists(APPPATH.'/language/'.$bahasa.'/'. $bhs .'_lang.php'))
			{
				$this->lang->load($bhs,$bahasa);
			}
		}
		if (file_exists(FCPATH . 'themes/'.$this->config->item('theme').'/assets/js/pages/'.$this->modul_name.".js"))
		{
			$js= script_tag(js_url("pages/".$this->modul_name.".js"));
			$this->template->append_metadata($js);
		}
		
		if (file_exists(FCPATH . 'themes/'.$this->config->item('theme').'/assets/js/pages/umum.js'))
		{
			$js= script_tag(js_url("pages/umum.js"));
			$this->template->append_metadata($js);
		}
		
		if (is_model_exist('data')){
			$this->load->model('data');
		}
		
		if ($this->uri->segment(2)=='login-activation'){
			$email=$this->input->get('email');
			$hash=$this->input->get('code');
			if (!empty($email) && !empty($hash)){
				$rows = $this->db->where('email', $email)->where('kode_login', $hash)->get(_TBL_USERS)->row();
				if ($rows){
					$this->crud->crud_data(array('table'=>_TBL_USERS, 'field'=>array('need_approve'=>0, 'kode_login'=>''), 'where'=>array('id'=>$rows->id),'type'=>'update'));
				}
			}
		}
	}

	public function __get($class) {
		return CI::$APP->$class;
	}
	
	public function set_Define_Table(){
		$prefix=$this->db->dbprefix;
		$table = $this->db->list_tables();
		foreach ($table as $tbl){
			$nama=strtoupper(str_replace($prefix, '_tbl_', $tbl));
			define($nama, $tbl);
		}
	}
	
	function _TOMBOL_PRINT($param=array(), $key=""){
		$sts_cetak="success";
		$txt_print = lang("msg_tombol_print");
		
		if ($param)
			$cetak=tombol_cetak($param);
		else
			$cetak=tombol_cetak();
		
		$result="";
		if ($cetak>0){
			$li='';
			foreach($cetak as $tombol){
				$lang=lang("msg_tombol_print_".$tombol['type']);
				if (!empty($lang)){
					$title=lang("msg_tombol_print_".$tombol['type']);
				}else{
					$title=$tombol['label'];
				}
				// $li .='<li><a class="_cetak" onClick="cetak_lap(\''.$tombol['type'].'\')" target="_blank" data-id="'.$key.'" data-kel="'.$tombol['type'].'">'.$tombol['icon'].$title.'</a></li>';
				$li .='<a class="dropdown-item" class="_cetak" onClick="cetak_lap(\''.$tombol['type'].'\')" target="_blank" data-id="'.$key.'" data-kel="'.$tombol['type'].'">'.$tombol['icon'].$title.'</a>';
			}
			
			$result=' <div class="btn-group">
				  <button class="btn btn-sm btn-flat dropdown-toggle btn-'.$sts_cetak.'" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-content="'.lang("msg_prop_tombol_print").'">
				    <i class="fa fa-print"></i> '.$txt_print.'
				  </button>
				  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				    '.$li.'
				  </div>
				</div>';
		}
		
		return $result;
	}
}