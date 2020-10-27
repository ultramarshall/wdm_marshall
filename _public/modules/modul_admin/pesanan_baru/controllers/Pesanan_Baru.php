<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pesanan_Baru extends BackendController {
	public function __construct()
	{
    	parent::__construct();

    	$this->set_Tbl_Master(_TBL_ORDER);

    	$this->cbo_status = [0=>'Tidak Aktif',1=>'Aktif'];

		$this->set_Open_Tab(lang('msg_tab_1'),'home2');
			$this->addField(['field'=>'id', 'type'=>'int', 'show'=>false, 'help'=>false, 'size'=>4]);
			$this->addField(['field'=>'order_id', 'size'=>4]);
			$this->addField(['field'=>'create_user', 'size'=>4]);
			$this->addField(['field'=>'create_date', 'size'=>4]);
		$this->set_Close_Tab();

		$this->set_Field_Primary('id');
		$this->set_Join_Table(['pk'=>$this->tbl_master]);

		/* table view */
		$this->set_Table_List($this->tbl_master,'order_id','KODE PESANAN',14,'left');
		$this->set_Table_List($this->tbl_master,'create_user','NAMA PEMESAN',14,'left');
		$this->set_Table_List($this->tbl_master,'create_date','TANGGAL PESANAN',14,'left');

		$this->set_Close_Setting();
	}

	function listBox_ORDER_ID($row, $value) {
		$this->midtrans->config([
    		'server_key' => $this->authentication->get_Preference('server_key'), 
    		'production' => (bool)$this->authentication->get_Preference('production')
    	]);
    	$result =  $this->midtrans->status($value);
    	// ob_start();
    	// echo "<pre>";
    	// var_dump($result->transaction_status);
    	// echo "</pre>";
    	// return ob_get_clean();
    	return $result->transaction_status;
	}


}
