<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends FrontendController {
	public function comment() {
		$data['comments'] = $this->data->get_product_comments($this->input->post('id'));
		return $this->load->view('view_product_comment' ,$data);		
	}

	public function post_comment() {
		$post = $this->data->post_comments($this->input->post());
		if ($post) {
			$data['comments'] = $this->data->get_product_comments($this->input->post('id'));
			return $this->load->view('view_product_comment' ,$data);
		}
	}
}
