<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends FrontendController {
	public function __construct() {
    	parent::__construct();
	}

	public function index() {
		$this->template->_sideleft =  false;
		$data['banners'] = $this->data->get_banner();
		$data['brands'] = $this->data->get_brand();
		$data['products'] = $this->data->get_product();
		$data['highlight_product'] = $this->data->get_highlight_product();
		$data['categories'] = $this->data->get_categories();
		$data['flashsale'] = $this->data->get_flashsale_product();
		// doi::dump($data['flashsale']);



		$this->template->build('home', $data);
	}
	public function product($id) {
		$this->template->build('product_detail');
	}
	
}
