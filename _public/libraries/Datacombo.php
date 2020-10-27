<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Datacombo
{	
	private $_ci;
	private $preference=array();
	private $output_parent=array();
	
	function __construct()
	{
		$this->_ci =& get_instance();

		if ($x=$this->_ci->session->userdata('preference')){
			$this->preference=$this->_ci->session->userdata('preference');
		}
		
	}

	function initialize($config = array())
	{
		
	}
	
	function get_data(){
		
		$this->_ci->db->select('*');
		$this->_ci->db->from(_TBL_MODUL);
		$this->_ci->db->order_by('urut');
		$query=$this->_ci->db->get();
		$rows=$query->result_array();
		$input=array();
		foreach($rows as $row){
			$input[] = array("id" => $row['id'], "title" => '['.$row['nm_modul'].'] - '.$row['title'], "slug" => $row['pid'], "pid" => $row['pid'],  "urut" => $row['urut'], "aktif" => $row['aktif']);
		}
		
		$result = _tree($input);
		return $result;
	}
	
	function _COMBO_MODUL(){
		$data=$this->get_data();
		
		$this->output_parent = array(0=>' - Parent - ');
		foreach($data as $row){
			$this->buildItem($row);
		}
		return $this->output_parent;
	}
	
	function buildItem($ad, $level=0) {
		$space = str_repeat('&nbsp;',$level*6);
		$this->output_parent[$ad['id']]=$space . $ad['title'];
		if (array_key_exists('children', $ad)) {	
			++$level;
			foreach($ad['children'] as $row){
				$this->buildItem($row, $level);
			}
		}
		$level=0;
	}
}
// END Template class