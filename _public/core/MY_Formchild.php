<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Router class */
// require APPPATH."third_party/MX/Controller.php";

class FormChild extends BackendController
{
	protected $_data_menu=array();
    public function __construct()
    {
        parent::__construct();
		// $this->template->set_layout('frontend');
		// $this->get_script_template();
    }
	
	public function get_script_templatex($nm_modul=''){
		$this->_data_menu['moduls']=array();
		if (method_exists($this->router->fetch_class(),'SIDEBAR_LEFT'))
		{$this->template->var_tmp('posisi',$this->SIDEBAR_LEFT());}
		
		if (method_exists($this->router->fetch_class(),'SIDEBAR_RIGHT'))
		{$this->template->var_tmp('menukanan',$this->SIDEBAR_RIGHT());}
		
		$this->template->prepend_metadata("<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>");
		$this->template->set_partial('css_frontend','css_frontend');
		$this->template->set_partial('js_frontend','js_frontend');
		$this->template->set_partial('footer_frontend','footer_frontend');
		$this->template->set_partial('js_bottom_frontend','js_bottom_frontend');
		$this->template->set_partial('header_frontend','header_frontend',$this->_data_menu);
	}
}