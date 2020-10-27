<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_History extends FrontendController {
	public function __construct()
	{
    	parent::__construct();

    	// doi::dump($this->data->count_order());

    	$this->template->_sideleft = true;
    	$this->midtrans->config([
    		'server_key' => $this->authentication->get_Preference('server_key'), 
    		'production' => (bool)$this->authentication->get_Preference('production')
    	]);
	}

	public function index()
	{
		$data['address'] = $this->data->get_address();
		$this->template->build('index', $data);
	}

	public function get_history() {
		$type = $this->input->post('type');
		

		switch ($type) {
			case 'status-pembayaran':
				$data['result_payment'] = $this->data->get_order();
				$result = $this->load->view('sts_pembayaran', $data);
				break;
			case 'status-pesanan':
				$result = $this->load->view('sts_pesanan');
				break;
			case 'konfirmasi-pesanan':
				$result = $this->load->view('konfirmasi');
				break;
			case 'history-pesanan':
				$result = $this->load->view('histori');
				break;
			default:
				$result = $this->load->view('sts_pembayaran');
				break;
		}
		return $result;
	}

	
}
