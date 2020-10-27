<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends FrontendController {

	public function __construct() {
        parent::__construct();
        $this->midtrans->config([
    		'server_key' => $this->authentication->get_Preference('server_key'), 
    		'production' => (bool)$this->authentication->get_Preference('production')
    	]);
    }

    public function index() {
    	$this->load->view('checkout_snap');
    }

    public function token() {
		$this->session->set_userdata('ongkir', (int)$this->input->post('ongkos_kirim'));
		// Required
		$transaction_details = array(
		  'order_id' => rand(),
		  'gross_amount' => ((int)$this->input->post('total_harga') + (int)$this->input->post('ongkos_kirim')), // no decimal allowed for creditcard
		);

		$item_detail = [];
		foreach ($this->cart->contents() as $item) {
			$item_detail[] = [
			  'id' => $item['id'],
			  'price' => $item['price'],
			  'quantity' => $item['qty'],
			  'name' => $item['name']
			];
		}

		/*item ongkir*/
		$item_detail[] = [
			'id' => rand(),
			'price' => (int)$this->input->post('ongkos_kirim'),
			'quantity' => 1,
			'name' => "Ongkir"
		];


		// Optional
		$billing_address = array(
		  'first_name'    => "Andri",
		  'last_name'     => "Litani",
		  'address'       => "Mangga 20",
		  'city'          => "Jakarta",
		  'postal_code'   => "16602",
		  'phone'         => "081122334455",
		  'country_code'  => 'IDN'
		);
		// Optional
		$shipping_address = array(
		  'first_name'    => "Obet",
		  'last_name'     => "Supriadi",
		  'address'       => "Manggis 90",
		  'city'          => "Jakarta",
		  'postal_code'   => "16601",
		  'phone'         => "08113366345",
		  'country_code'  => 'IDN'
		);
		// Optional
		$customer_details = array(
		  'first_name'    => "Andri",
		  'last_name'     => "Litani",
		  'email'         => "andri@litani.com",
		  'phone'         => "081122334455",
		  'billing_address'  => $billing_address,
		  'shipping_address' => $shipping_address
		);
		// Data yang akan dikirim untuk request redirect_url.
        $credit_card['secure'] = true;
        //ser save_card true to enable oneclick or 2click
        //$credit_card['save_card'] = true;
        $time = time();
        $custom_expiry = array(
            'start_time' => date("Y-m-d H:i:s O",$time),
            'unit' => 'minute', 
            'duration'  => 2
        );
        
        $transaction_data = array(
            'transaction_details'=> $transaction_details,
            'item_details'       => $item_detail,
            // 'customer_details'   => $customer_details,
            'credit_card'        => $credit_card,
            'expiry'             => $custom_expiry
        );

		error_log(json_encode($transaction_data));
		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		error_log($snapToken);
		echo $snapToken;
    }

    public function finish() {
    	$result_order = json_decode($this->input->post('result_data'));
    	$this->session->set_userdata('result_order', $result_order);

    	/*simpan order*/
        $item_detail = [];
    	foreach ($this->cart->contents() as $value) {
    		$item_detail[] = [
    			'id'=>(int)$value['id'],
    			'qty'=>(int)$value['qty']
			];
    	}

    	$result = $this->data->set_order([
    		'order_id' => $result_order->order_id,
    		'item_detail' => json_encode($item_detail),
    		'ongkir'=> $this->session->userdata('ongkir')
    	]);
    	/*end simpan order*/

    	$this->cart->destroy();
    	header('Location: ' . base_url('order_history'));
    }
}