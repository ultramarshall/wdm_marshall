<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wds_Products extends BackendController {
	public function __construct()
	{
    	parent::__construct();
    	$this->set_Tbl_Master(_TBL_WDS_PRODUCT);

    	$this->cbo_category = $this->get_combo_no_select('category');
    	$this->cbo_color = $this->get_combo_no_select('color');

		$this->addField(['field'=>'id', 'type'=>'int', 'show'=>false, 'help'=>false, 'size'=>4]);
		$this->addField(['field'=>'product_image', 'input'=>'upload', 'path'=>'staft', 'file_thumb'=>true]);
		$this->addField(['field'=>'product_name', 'required'=>true, 'search'=>false]);
		$this->addField(['field'=>'product_color_no', 'required'=>true, 'type'=>'int' , 'input'=>'combo:search', 'combo'=>$this->cbo_color, 'search'=>true, 'size'=>20]);
		$this->addField(['field'=>'product_category_no', 'required'=>true, 'type'=>'int' , 'input'=>'combo:search', 'combo'=>$this->cbo_category, 'search'=>true, 'size'=>20]);
		$this->addField(['field'=>'product_price', 'required'=>true, 'input'=>'float', 'type'=>'float', 'size'=>50]);

		$this->set_Field_Primary('id');
		$this->set_Join_Table(['pk'=>$this->tbl_master]);
		$this->set_Sort_Table($this->tbl_master, 'id', 'desc');

		$this->set_Bid(['nmtbl'=>$this->tbl_master,'field'=>'product_price', 'span_right_addon'=>' Rp ', 'align'=>'left']);

		$this->set_Table_List($this->tbl_master,'product_image', 'Picture');
		$this->set_Table_List($this->tbl_master,'product_name', 'Nama Produk');
		$this->set_Table_List($this->tbl_master,'product_color_no', 'Warna');
		$this->set_Table_List($this->tbl_master,'product_price', 'Harga_(Rp)');
		$this->set_Table_List($this->tbl_master,'id', 'Action');


		$this->set_Close_Setting();

		
	}

	function listBox_ID($row, $value){
		$html = '<a href="'.base_url('wds-products/edit/'.$value).'" class="btn btn-sm btn-primary">edit</a>';
		$html .= '&nbsp;&nbsp;';
		$html .= '<button class="btn btn-sm btn-danger">delete</button>';
		return $html;
	}
	
	function listBox_PRODUCT_COLOR_NO($row, $value){
		return $this->cbo_color[$value];
	}


	function listBox_PRODUCT_IMAGE($row, $value){
		return '<img width="120px" src="'.base_url('themes/file/staft/'.$value).'"/>';
	}

	

	
}
