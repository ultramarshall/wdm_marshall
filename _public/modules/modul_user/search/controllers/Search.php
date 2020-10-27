<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends FrontendController {
	public function __construct()
	{
    	parent::__construct();
    	$this->template->_sideleft =  false;
	}

	public function index()
	{
		$this->session->set_userdata('keyword', $this->input->post('keyword'));
		$this->template->build('index');
	}

	public function filter_product_by() {
		$post = $this->input->post();
		$this->session->set_userdata('keyword', $this->input->post('keyword'));
		$data['product'] = $this->data->filter($post);
		return $this->load->view('product', $data);
	}

}
