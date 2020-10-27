<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Logdata {
	private $ci;
	
	protected $msg_log_perda=array();
	protected $_log_data_perda=array();
	
	function __construct()
	{	
		$this->ci =& get_instance();
		
	}
	
	function _msg_log_perda_bg($msg=''){
		$this->msg_log_perda[]=$msg;
	}
	
	function _save_log_data(){
		if (array_key_exists('kel', $this->_log_data_perda))
			$data['kel']=$this->_log_data_perda['kel'];
		if (array_key_exists('new_data', $this->_log_data_perda))
			$data['new_data']=$this->_log_data_perda['new_data'];
		if (array_key_exists('old_data', $this->_log_data_perda))
			$data['old_data']=$this->_log_data_perda['old_data'];
		if (array_key_exists('modul', $this->_log_data_perda))
			$data['modul']=$this->_log_data_perda['modul'];
		
		$data['ket']=implode('<br/>',$this->msg_log_perda);
		save_log($data);
		$this->_log_data_perda=array();
		$this->msg_log_perda=array();
	}
	
	function _log_data($key, $msg){
		$this->_log_data_perda[$key][]=$msg;
	}
}

/* End of file Authentication.php */
/* Location: ./application/libraries/Authentication.php */