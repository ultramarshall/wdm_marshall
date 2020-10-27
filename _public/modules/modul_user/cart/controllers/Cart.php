<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends FrontendController {
	public function __construct()
	{
    	parent::__construct();

    	$this->template->_sideleft =  false;
	}

	public function index()
	{
		$this->template->build('index');
	}

	public function add_cart() {
		$data = array(
			'id' => $this->input->post('id'),
			'qty' => $this->input->post('qty'),
			'price' => $this->input->post('price'),
			'name' => $this->input->post('name'),
			'varian' => $this->input->post('varian'),
		);
		echo json_encode([
			(bool)$this->cart->insert($data),
			count($this->cart->contents()),
			$this->notif()
		]);
	}
	
	public function update_cart() {
		$data = [
			'rowid' => $this->input->post('row_id'),
			'qty'	=> intval($this->input->post('qty'))
		];
		echo json_encode([
			(bool)$this->cart->update($data),
			count($this->cart->contents()),
			$this->notif(),
			$this->cart->contents()[$data['rowid']]['subtotal'],
			$this->content()
		]);
	}
	public function remove_cart() {
		echo json_encode([
			(bool)$this->cart->update(['rowid' => $this->input->post('rowid'),'qty'=>0]),
			count($this->cart->contents()),
			$this->content(),
			$this->notif()
		]);
	}

	public function update_total() {
		echo json_encode($this->cart->total());
	}

	public function contents() {
		doi::dump($this->cart->contents());
	}

	public function notif(){
		$html = '';
		if (count($this->cart->contents()) > 0) {

			foreach ($this->cart->contents() as $value) {
				$produk = $this->data->get_product_detail($value['id']);
				$img = json_decode($produk[0]->product_logo);

				$html .= '<div class="card-body fs-14 p-1 border-bottom d-inline-block mw-300">
					    <a href="#" class="d-block o-auto">
					        '.show_image($img[0]->nama,60, 0, 'slide', 'w-25 p-0 pt-1 pl-1 pull-left').'
					        <div class="float-left text-left p-0 pl-1 w-75 fs-12 cur-pointer bold ">
					            <div class="col-12 pt-1 pl-1">'.$value['name'].'</div>
						        <div class="col-12 pt-0 pl-1 no-bold text-left">
		                            <span class="col-5 d-flex p-0 float-left">Quantity</span>
		                            <span class="col-7 d-flex p-0 m-0 text-right">
		                                :'.$value['qty'].' x '.rupiah($value['price']).'
		                            </span>
		                        </div>
		                        <div class="col-12 pt-0 pl-1 no-bold text-left">
		                            <span class="col-5 d-flex 0px p-0 float-left">Total</span>
		                            <span class="col-7 d-flex p-0 m-0 text-right">
		                                :'.rupiah(($value['qty']*$value['price'])).'
		                            </span>
		                        </div>
					        </div>
					    </a>
					</div>';
			} 
			$html .= '<div class="card-body pl-2 p-1 text-left">
				          <div class="w-50 float-left bold pl-1">Total</div>
				          <div class="w-50 float-left bold">
				              <span class="pull-right pr-2">
				                  '.rupiah($this->cart->total()).'
				              </span>
				          </div>
				      </div>
				      <div class="card-footer d-block p-1 fs-10">
				          <a href="'.base_url('cart').'">lihat semua</a>
				      </div>';
		    return $html;
		} else { 
			$html .= '<div class="card-body p-5 text-left">
                        <img src="https://orig00.deviantart.net/c477/f/2015/224/b/3/giphy__3__by_electricookie-d95d30j.gif" alt="">
                    </div>
                    <div class="card-footer">
                        no cart
                    </div>';
            return $html;
		}

	}

	public function content() {
		$html = '';
		if (count($this->cart->contents()) === 0) {
            $html .= '<div class="text-center p-5 border">
                <img class="mb-2" src="https://orig00.deviantart.net/c477/f/2015/224/b/3/giphy__3__by_electricookie-d95d30j.gif" height="100" alt=""><br>
                <span class="fs-18 bold ">Belum ada belanjaan</span><br>
                <a href="'.base_url().'" class="btn btn-lg bg-ailin-pink text-white bold w-200px mt-2">cari produk</a>
            </div>';
            return $html;
        } else {
            $html .= '<table class="table table-sm bg-white m-0 tbl-no-border">
                <thead>
                    <tr>
                        <th class="p-2 bordered-pink text-center" colspan="2">Produk</th>
                        <th class="p-2 bordered-pink text-right">Harga Satuan</th>
                        <th class="p-2 bordered-pink text-center" width="10" align="center">Kuantitas</th>
                        <th class="p-2 bordered-pink text-right">Total Harga</th>
                        <th class="p-2 bordered-pink text-center">Pilihan</th>
                    </tr>
                </thead>
                <tbody>';
            foreach ($this->cart->contents() as $item) {
                $product = $this->data->get_product_detail($item['id'])[0];
                $pic = show_image(json_decode($product->product_logo)[0]->nama,60, 0, 'slide', 'm-auto');
                $varian = '<span class="badge badge-secondary">'.$item['varian'].'</span> ';
	            $html.='<tr>
	                <td class="text-center">'.$pic.'</td>
	                <td>Varian: '.$varian.'</td>
	                <td class="text-right">'.rupiah($item['price']).'</td>
	                <td class="text-center justify-content center text-center" >
	                    <div class="d-flex align-center">
	                        <button id="btn-qty" data-action="min" data-id="'.$item['rowid'].'" class="hw-30 bold white r-0 float-left border" data-id="'.$item['rowid'].'">-</button>
	                        <input type="text" class="float-left p-0 w-30px form-control white text-center" id="qty" value="'.$item['qty'].'" disabled>
	                        <button id="btn-qty" data-action="max" data-id="'.$item['rowid'].'" class="hw-30 bold white r-0 float-left border" data-id="'.$item['rowid'].'">+</button>
	                    </div>    
	                </td>
	                <td class="text-right">'.rupiah($item['subtotal']).'</td>
	                <td class="text-center">
	                    <button class="delete-item btn btn-danger m-auto" data-id="'.$item['rowid'].'">
	                        <i class="fa fa-trash red"></i> Hapus
	                    </button>
	                </td>
	            </tr>';
	            $html .= '</tbody></table>';
            	return $html;
            }

        }
	}

	public function check_promo_code() {
		$data['kode'] = $this->input->post('kode');
		$data['kode_status'] = $this->data->get_status_promotion($data['kode']);
		return $this->load->view('promo',$data);
	}
}
