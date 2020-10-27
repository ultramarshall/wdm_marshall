
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wds_Report extends BackendController {
	public function __construct()
	{
    	parent::__construct();
    	$this->set_Tbl_Master(_TBL_WDS_PRODUCT_SALES);


		$this->addField(['field'=>'id', 'type'=>'int', 'show'=>false, 'help'=>false, 'size'=>4]);
		$this->addField(['field'=>'product_no', 'required'=>true, 'search'=>false]);

		$this->set_Field_Primary('id');
		$this->set_Join_Table(['pk'=>$this->tbl_master]);
		$this->set_Sort_Table($this->tbl_master, 'id', 'desc');


		$this->set_Table_List($this->tbl_master,'product_no', 'Nama Produk');


		$this->set_Close_Setting();

		
	}

	

	

	
}
