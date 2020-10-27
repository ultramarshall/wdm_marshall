<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification extends FrontendController {
	public function __construct()
	{
    	parent::__construct();
    	$this->template->_sideleft =  false;
	}

	public function index()
	{	
		$this->template->build('index');
	}

	public function get_notification() {
		$post = $this->input->post();
		// $data['notif'] = $this->data->notif();
		return $this->load->view('item_transaction');
	}




	public function alert() {
		return $this->load->view('alert');
	}

	public function send() {
		$options = ['cluster'=>'ap1', 'useTLS' => true];
		$pusher = new Pusher\Pusher('e2612f472d9f47e4d346', '29eb4cc1d26f86ba53c2', '731484', $options);
		$data['message'] = 'hello world';
		$pusher->trigger('my-channel', 'my-event', $data);
	}

}
