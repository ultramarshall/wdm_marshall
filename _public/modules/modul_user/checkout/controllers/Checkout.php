<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checkout extends FrontendController {
	public function __construct()
	{
    	parent::__construct();
    	$this->template->_sideleft =  false;
    	$this->origin = (int)$this->authentication->get_Preference('kota');
	}

	public function index()
	{	
		$data['total_weight'] = 0;
		foreach ($this->cart->contents() as $key => $value) {
			$id = (int)$value['id'];
			$product = $this->data->get_product_detail($id);
			$weight = $product->weight * $value['qty'];
			$data['total_weight'] += $weight;
		}
		if ($this->authentication->is_loggedin()) {
			$data['alamat'] = $this->data->default_address();
			$data['destination'] = (int)$data['alamat']->kecamatan;
			$data['cost'] = json_decode(
				$this->rajaongkir->cost(
					$this->origin, 
					$data['destination'], 
					$data['total_weight'], 
					"jne"
			))->rajaongkir->results[0]->costs;
			$data['provinsi'] = json_decode($this->rajaongkir->province())->rajaongkir->results;
			$js= '<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-3y2qW9z-YUQyyW36"></script>';
			$this->template->append_metadata($js);
		}

		
		$this->template->build('index', $data);
	}

	public function service_courier()
	{
		$data['cost'] = json_decode(
			$this->rajaongkir->cost(
				$this->origin, 
				$this->input->post('destination'), 
				$this->input->post('weight'), 
				$this->input->post('kurir')
		))->rajaongkir->results[0]->costs;
		echo json_encode($data);
	}


}
