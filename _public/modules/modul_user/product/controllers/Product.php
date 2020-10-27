<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends FrontendController {
	public function __construct()
	{
    	parent::__construct();
    	$this->template->_sideleft = false;
	}

	function _remap($param) {
        $this->index($param);
    }

	public function index($id)
	{
    	$id = $this->uri->segment(2);
		$data['product'] = $this->data->get_product_detail($id);
		$this->template->build('index', $data);
	}

	
}
