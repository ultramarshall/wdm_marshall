<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Produk_Flashsale extends BackendController {
	public function __construct()
	{
    	parent::__construct();
    	$this->set_Tbl_Master(_TBL_FLASHSALE);

    	$this->cbo_status = [0=>'Tidak Aktif',1=>'Aktif'];
    	$this->cbo_product = $this->get_combo_no_select('product');

		$this->set_Open_Tab(lang('msg_tab_1'),'home2');
			$this->addField(['field'=>'id', 'type'=>'int', 'show'=>false, 'help'=>false, 'size'=>4]);
			$this->addField(['field'=>'flashsale_title', 'type'=>'text', 'required'=>true]);

			$this->addField(['field'=>'start_period', 'input'=>'date','type' =>'date', 'size'=>'200px', 'required'=>true]);
			// $this->addField(['field'=>'start_time', 'input'=>'time','type' =>'time', 'size'=>'200px', 'required'=>true]);
			$this->addField(['field'=>'end_period', 'input'=>'date','type' =>'date', 'size'=>'200px', 'required'=>true]);
			// $this->addField(['field'=>'end_time', 'input'=>'time','type' =>'time', 'size'=>'200px', 'required'=>true]);
			$this->addField(['field'=>'flashsale_product']);
			$this->addField(['field'=>'status', 'type'=>'int' , 'input'=>'combo:search', 'combo'=>$this->cbo_status, 'search'=>true, 'size'=>'100px']);
			// $this->addField(['field'=>'count', 'type'=>'o']);
		$this->set_Close_Tab();

		$this->set_Field_Primary('id');
		$this->set_Join_Table(['pk'=>$this->tbl_master]);

		$this->set_Bid(['nmtbl'=>$this->tbl_master,'field'=>'start_period', 'span_right_addon'=>'<span class="icon-calendar fs-16"></span>', 'align'=>'center']);
		$this->set_Bid(['nmtbl'=>$this->tbl_master,'field'=>'end_period', 'span_right_addon'=>'<span class="icon-calendar fs-16"></span>', 'align'=>'center']);
		// $this->set_Bid(['nmtbl'=>$this->tbl_master,'field'=>'start_time', 'span_right_addon'=>'<span class="icon-clock-o fs-16"></span>', 'align'=>'center']);
		// $this->set_Bid(['nmtbl'=>$this->tbl_master,'field'=>'end_time', 'span_right_addon'=>'<span class="icon-clock-o fs-16"></span>', 'align'=>'center']);

		/* table view */
		$this->set_Table_List($this->tbl_master,'flashsale_title','Judul Flashsale',14,'left');
		// $this->set_Table_List($this->tbl_master,'periode','Periode',5,'center');
		// $this->set_Table_List($this->tbl_master,'count','Total Produk',5,'center');

		$this->set_Close_Setting();
	}

	function listBox_periode($row) {
		$diff = abs(strtotime($row["l_end_period"]) - strtotime($row["l_start_period"]));
		$years = floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$diffdays = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		return '<span class="badge deep-orange shadow-sm text-white bold">'.$diffdays.' hari</span>';
	}

	function listBox_count($row) {
		$values = array_map('intval', explode(',', $row['l_flashsale_product'] ));
		return '<span class="badge deep-orange shadow-sm text-white bold">'.count($values) . " Produk</span>";
	}

	function insertBox_flashsale_product($field) {

		$html = '<table class="table table-bordered table-sm input-table">
				  	<thead class="dark">
				  		<tr>
					  		<th class="pl-3">Product</th>
					  		<th class="text-center" width="10%">action</th>
				  		</tr>
				  	</thead>
				  	<tbody>
				  		<tr>
						  	<td class-"p-2">
								'.form_dropdown("data[]",$this->cbo_product, '', 'class="select_2"').'
							</td>
							<td class="text-center">
								<span class="btn bg-red text-white icon-trash-o detete"></span>
							</td>
						</tr>
					</tbody>
				  	<tfoot>
				  		<tr>
					  		<th class="white" colspan="2">
					  			<button class="btn btn-sm bg-blue text-white w-25" id="add" onclick="return false"><span class="icon-add"></span>add product</button>
					  		</th>
				  		</tr>
				  	</tfoot>	
				  </table>
				  <input type="hidden" name="l_flashsale_product" id="l_flashsale_product" value="'.$value.'">';
				  
		return $html;

	}

	function updateBox_flashsale_product($data, $old_data, $value) {

		$html = '<table class="table table-bordered table-sm input-table">
				  	<thead class="dark">
				  		<tr>
					  		<th class="pl-3">Product</th>
					  		<th class="text-center" width="10%">action</th>
				  		</tr>
				  	</thead>
				  	<tbody>';
	  	$values = array_map('intval', explode(',', $value ));
		foreach ($values as $val) {
			$html .= '<tr>
					  	<td class-"p-2">
							'.form_dropdown("data[]",$this->cbo_product, $val, 'class="select_2"').'
						</td>
						<td class="text-center">
							<span class="btn bg-red text-white icon-trash-o delete"></span>
						</td>
				  	  </tr>';
		}
		$html .= '</tbody>
				  	<tfoot>
				  		<tr>
					  		<th class="white" colspan="2">
					  			<button class="btn btn-sm bg-blue text-white w-25" id="add" onclick="return false"><span class="icon-add"></span>add product</button>
					  		</th>
				  		</tr>
				  	</tfoot>	
				  </table>
				  <input type="hidden" name="l_flashsale_product" id="l_flashsale_product" value="'.$value.'">';
				  
		return $html;

	}

}
