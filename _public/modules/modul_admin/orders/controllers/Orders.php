<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders extends BackendController {
	public function __construct()
	{
    	parent::__construct();

    	$this->cbo_customers = $this->get_combo_no_select('customers');
    	$this->cbo_products = $this->get_combo_no_select('products');

    	$this->set_Tbl_Master(_TBL_TEST_ORDERS);

		$this->set_Open_Tab(lang('msg_tab_1'),'home2');
			$this->addField(['field'=>'id', 'type'=>'int', 'show'=>false, 'help'=>false, 'size'=>4]);
			$this->addField(['field'=>'customer_id', 'required'=>true, 'type'=>'int' , 'input'=>'combo:search', 'combo'=>$this->cbo_customers, 'search'=>true, 'size'=>20]);
			$this->addField(['field'=>'order_item_id', 'required'=>true, 'type'=>'int' , 'input'=>'combo:search', 'combo'=>$this->cbo_products, 'search'=>true, 'size'=>20]);
			$this->addField(['field'=>'order_qty', 'input'=>'int', 'size'=> '10%', 'manual_input'=> 1]);
			$this->addField(['field'=>'create_date', 'input'=>'datetime', 'show' => false]);
			$this->set_Close_Tab();

		$this->set_Field_Primary('id');
		$this->set_Join_Table(['pk'=>$this->tbl_master]);

		$this->set_Table_List($this->tbl_master,'customer_id');
		$this->set_Table_List($this->tbl_master,'order_item_id');
		$this->set_Table_List($this->tbl_master,'order_qty');
		$this->set_Table_List($this->tbl_master,'create_date');

		// $this->_SET_PRIVILEGE('add', false);
		// $this->_SET_PRIVILEGE('edit', false);
		// $this->_SET_PRIVILEGE('cetak', false);
		// $this->_SET_PRIVILEGE('delete', true);

		$this->set_Close_Setting();

	}

	function POST_AFTER_INSERT($data){
		$item = $data['l_order_item_id'];
		$qty = $data['l_order_qty'];

		$this->db->where('id', $item);
		$this->db->set('item_qty', 'item_qty - ' . (int) $qty, FALSE);
		$this->db->update('bangga_test_stock');

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}

	
	function listBox_CUSTOMER_ID($row, $value) {
		$result = $this->db->where('id', $value)->get(_TBL_TEST_CUSTOMERS)->result();
		return $result[0]->customer_name;
	}
	
	function listBox_ORDER_ITEM_ID($row, $value) {
		$result = $this->db->where('id', $value)->get(_TBL_TEST_STOCK)->result();
		return $result[0]->item_code . ' - ' . $result[0]->item_name;
	}

}
