<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cetak
{
	private $_ci;
	private $preference=array();
	
	function __construct()
	{
		$this->_ci =& get_instance();

		if ($x=$this->_ci->session->userdata('preference')){
			$this->preference=$this->_ci->session->userdata('preference');
		}
		
	}

	function initialize($config = array())
	{
		
	}
	
	public function cetak_pdf_satu($data=array(), $title=array(), $nmfile='', $size=array(), $arr_title=array(), $sts_all=true, $fields=array())
	{
		$this->_ci->load->library('pdf');
		$nmFile=$nmfile.".pdf";
		$pdfFilePath = download_path_relative($nmFile);
		
		// die($pdfFilePath);
		$html ='<table width="100%"><tr><td rowspan="3"><img src="'.img_url('logo-lap.png').'"></td>';
		$html .='<td>'.$this->preference['nama_kantor'].'</td></tr>';
		$html .='<tr><td>'.$this->preference['alamat_kantor'].'</td></tr>';
		$html .='<tr><td>Telp: '.$this->preference['telp_kantor'].' email: '.$this->preference['email_kantor'].'</td></tr></table><br/>';
		
		$html .="<strong>List Data</strong> <br/>";
		
		$html .="<table width='100%' border='1' cellspacing='0' cellpadding='0'>";
		$rows=$data;
		
		$html .="<tbody>";
		
		$align=array();
		$format=array();
		$no_urut=0;
		if ($sts_all){
			foreach($rows as $key=>$judul)
			{
				$key_tmp = substr($key,2,100);
				$label = lang('msg_field_'.$key_tmp);
				if (empty($label))
					$label=ucwords(str_replace('_',' ',$key_tmp));
				
				$align="left";
				$value = $judul;
				foreach($fields as $fld){
					if ($fld['label']==$key){
						if ($fld['input']['type']=='float'){
							$align="right";
							$value = number_format($judul);
							break;
						}
					}
				}
				$html .="<tr><td>".++$no_urut."</td>";
				$html .="<td>".$label."</td>";
				$html .="<td align='".$align."'>".$value."</td>";
				$html .="</tr>";
			}
		}else{
			foreach($title as $key=>$judul)
			{
				if (array_key_exists('align', $size)){
					if (array_key_exists($key, $size['align'])){
						$align[]=$size['align'][$key];
					}else{
						$align[]="left";
					}
				}else{
					$align[]="left";
				}
				
				if (array_key_exists('number_format', $size)){
					if (array_key_exists($key, $size['number_format'])){
						$format[]=$size['number_format'][$key];
					}else{
						$format[]="";
					}
				}else{
					$format[]="";
				}
			}
			
			$no_urut=0;
		
			$row =$rows;
			$kol=0;
			
			foreach($title as $key=>$judul)
			{
				if (in_array($judul[1],$arr_title)){
					$jdl=lang('msg_field_'.$judul[1]);
					if(empty($jdl)){
						$jdl=$judul[1];
						if (array_key_exists(2,$judul))
							if (!empty($judul[2]))
								$jdl=$judul[2];
					}
					
					if ($format[$key]=='float'){
						if(floatval($row['l_'.$judul[1]])){
							$value = number_format($row['l_'.$judul[1]]);
						}
					}else{
						$value=$row['l_'.$judul[1]];
					}
					
					$html .="<tr><td>".++$no_urut."</td>";
					$html .="<td>".$jdl."</td>";
					$html .="<td align='".$align[$key]."'>".$value."</td>";
					$html .="</tr>";
				}
			}
		}
		
		$html .="</tbody></table>";
		
		// die($html);
		$pdf = $this->_ci->pdf->load();
		$pdf->SetHeader('');
		$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822)); 
		$pdf->WriteHTML($html); 
		ob_clean();
		$pdf->Output($nmFile, 'I'); 
		redirect(download_url($nmFile));
		return true;
	}
	
	public function cetak_pdf($data=array(), $title=array(), $nmfile='', $size=array(), $field=array())
	{
		$nmFile=$nmfile.".pdf";
		$pdfFilePath = download_path_relative($nmFile);
		
		// die($pdfFilePath);
		$html ='<table width="100%"><tr><td rowspan="3"><img src="'.img_url('logo-lap.png').'"></td>';
		$html .='<td>'.$this->preference['nama_kantor'].'</td></tr>';
		$html .='<tr><td>'.$this->preference['alamat_kantor'].'</td></tr>';
		$html .='<tr><td>Telp: '.$this->preference['telp_kantor'].' email: '.$this->preference['email_kantor'].'</td></tr></table><br/>';
		
		$html .="<strong>List Data</strong> <br/>";
		
		$html .='<table  width="100%" cellpadding="4" cellspacing="0" border="0" style="border:1px solid black ;">';
		$rows=$data;
		
		$html .="<thead><tr>";
		$html .="<th style='border:1px solid black ;'>No.</th>";
		
		$align=array();
		$format=array();
		
		foreach($title as $key=>$judul)
		{
			if (array_key_exists('align', $size)){
				if (array_key_exists($key, $size['align'])){
					$align[]=$size['align'][$key];
				}else{
					$align[]="left";
				}
			}else{
				$align[]="left";
			}
			
			if (array_key_exists('number_format', $size)){
				if (array_key_exists($key, $size['number_format'])){
					$format[]=$size['number_format'][$key];
				}else{
					$format[]="";
				}
			}else{
				$format[]="";
			}
		}
		
		foreach($title as $key=>$judul)
		{
			$jdl=$judul[1];
			if (array_key_exists(2,$judul))
				if (!empty($judul[2]))
					$jdl=$judul[2];
			
			$html .="<th align='".$align[$key]."' style='border:1px solid black ;'>".$jdl."</th>";
		}
		
		$html .="</tr></thead><tbody>";
		
		$no_urut=0;
		foreach($rows['fields'] as $row)
		{
			$kol=0;
			$html .="<tr><td  style='border:1px solid black ;'>".++$no_urut."</td>";
			foreach($title as $key=>$judul)
			{
				if ($format[$key]=='float')
					$value = number_format($row['l_'.$judul[1]]);
				else
					$value=$row['l_'.$judul[1]];
					
				$html .="<td align='".$align[$key]."' style='border:1px solid black ;'>".$value."</td>";
			}
			$html .="</tr>";
		}
		$html .="</tr></tbody></table>";
		
		// die($html);
		$pdf = $this->_ci->pdf->load();
		$pdf->SetHeader('');
		$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822)); 
		$pdf->WriteHTML($html); 
		ob_clean();
		$pdf->Output($pdfFilePath, 'F'); 
		redirect(download_url($nmFile));
		return true;
	}
	
	public function cetak_word($data=array(), $title=array(), $nmfile='', $size=array(), $field=array())
	{
		$this->_ci->load->library('PHPWord');
		$sectionStyle = array('orientation' => null,
			    'marginLeft' => 500,
			    'marginRight' => 500,
			    'marginTop' => 900,
			    'marginBottom' => 900);
		
		$this->_ci->phpword->addParagraphStyle('normal', array('align' => 'left', 'spaceBefore' => 0, 'spaceAfter' => 0, 'spacing' => 1));
		
		$section = $this->_ci->phpword->createSection($sectionStyle);
		
		$header = array('size' => 14, 'bold' => true);

		// 1. Basic table

		$rows = 10;
		$cols = 5;
		$html="";
		$html .=$this->preference['nama_kantor']."<br/>";
		$html .=$this->preference['alamat_kantor']."<br/>";
		$html .='Telp: '.$this->preference['telp_kantor'].' email: '.$this->preference['email_kantor']."<br/>&nbsp;<br/>";
		
		
		$section->addText(htmlentities($this->preference['nama_kantor']), $header);
		$section->addText(htmlentities($this->preference['alamat_kantor']), $header);
		$section->addText(htmlentities('Telp: '.$this->preference['telp_kantor'].' email: '.$this->preference['email_kantor']), $header);
		
		$rows=$data;
		
		$center = array('spaceAfter' => 0, 'align' => 'center');

		$table_block_format = array(    'borderSize'        =>  7,
										'cellMarginTop'     =>  0,
										'cellMarginLeft'    =>  100,
										'valign'            =>  'center',);

		$cellTextStyleBig = array(      'bold'  =>  false, 
										'size'  =>  22, 
										'name'  =>  'Calibri');

		$cellTextStyleBigBold = array(  'bold'  =>  true, 
										'size'  =>  13, 
										'name'  =>  'Calibri'   );  
																
		$styleFirstRow = array('bgColor'=>'66BBFF','align' => 'center');
		$this->_ci->phpword->addTableStyle('myTable', $table_block_format, $styleFirstRow);


		$table = $section->addTable('myTable');
		$table->addRow();
		$table->addCell(1750)->addText('No.');
		foreach($title as $judul)
		{
			$jdl=$judul[1];
			if (array_key_exists(2,$judul))
				if(!empty($judul[2]))
					$jdl=$judul[2];
					
			$table->addCell(1750)->addText($jdl,$cellTextStyleBigBold);
		}
		
		$i=0;
		foreach($rows['fields'] as $row)
		{
			$table->addRow();
			$table->addCell(700)->addText(++$i);
			$size=1000;
			foreach($title as $judul)
			{
				$size +=500;
				$table->addCell($size)->addText($row['l_'.$judul[1]]);
			}
		}
		
		$objWriter = PHPWord_IOFactory::createWriter($this->_ci->phpword	, 'Word2007');
		
		$filename="$nmfile.docx"; //save our document as this file name
		$pdfFilePath = $this->_ci->config->item('file_path').$filename;
		
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=$filename");
		header("Content-Type: application/docx");
		header("Content-Transfer-Encoding: binary");

		ob_clean();
		$objWriter->save($filename);
		$status = readfile($filename);
		// unlink($h2d_file_uri);
		return true;
		exit;
	}
	
	public function cetak_excel($data=array(), $title=array(), $nmfile='', $size=array(), $field=array())
	{
		header("Content-type:appalication/vnd.ms-excel");
        header("content-disposition:attachment;filename=".$nmfile.'.xls');
		
		$html ="<table width='100%' border='0'>";
		$html .="<tr><td colspan='3'>".$this->preference['nama_kantor']."</td></tr>";
		$html .="<tr><td colspan='3'>".$this->preference['alamat_kantor']."</td></tr>";
		$html .="<tr><td colspan='3'>Telp : ".$this->preference['telp_kantor']." Email : ".$this->preference['email_kantor']."</td></tr>";
		$html .="<tr><td colspan='3'></td></tr>";
		$html .="<tr><td></td><td></td><td></td></tr></table>";
		$html .="<tr><td></td><td></td><td></td></tr></table>";
		$html .="<tr><td colspan='3'> LIST ".strtoupper(lang("msg_title_"._MODULE_NAME_REAL_))."</td></tr></table>";
		
		$html .="<table width='100%' border='1'>";
		$rows=$data;
		
		$html .="<thead><tr>";
		$html .="<th>No.</th>";
		
		$align=array();
		$format=array();
		
		foreach($title as $key=>$judul)
		{
			if (array_key_exists('align', $size)){
				if (array_key_exists($key, $size['align'])){
					$align[]=$size['align'][$key];
				}else{
					$align[]="left";
				}
			}else{
				$align[]="left";
			}
			
			if (array_key_exists('number_format', $size)){
				if (array_key_exists($key, $size['number_format'])){
					$format[]=$size['number_format'][$key];
				}else{
					$format[]="";
				}
			}else{
				$format[]="";
			}
		}
		
		foreach($title as $key=>$judul)
		{
			$jdl=$judul[1];
			if (array_key_exists(2,$judul))
				if (!empty($judul[2]))
					$jdl=$judul[2];
			
			$html .="<th align='".$align[$key]."'>".$jdl."</th>";
		}
		
		$html .="</tr></thead><tbody>";
		
		$no_urut=0;
		foreach($rows['fields'] as $row)
		{
			$kol=0;
			$html .="<tr><td>".++$no_urut."</td>";
			foreach($title as $key=>$judul)
			{
				if ($format[$key]=='float')
					$value = number_format($row['l_'.$judul[1]]);
				else
					$value=$row['l_'.$judul[1]];
					
				$html .="<td align='".$align[$key]."'>".$value."</td>";
			}
			$html .="</tr>";
		}
		$html .="</tr></tbody></table>";
		
		echo $html;
		exit;
	}
	
	function huruf_kolom($col){
		$j = 0;
		for ($i = 65;$i<= 90;++$i){
			$arrHuruf[++$j] = chr($i);
		}
		
		for ($i = 65;$i<= 90;++$i){
			$arrHuruf[++$j] = "A".chr($i);
		}
		
		for ($i = 65;$i<= 90;++$i){
			$arrHuruf[++$j] = "B".chr($i);
		}
		
		for ($i = 65;$i<= 90;++$i){
			$arrHuruf[++$j] = "C".chr($i);
		}
	
		return  $arrHuruf[$col];
	}
	
	public function kirim_email($row=array(), $master=array(), $nmfile='', $size=array()){
		ini_set('MAX_EXECUTION_TIME', -1);
		$subject="Laporan ".$nmfile." | ".date('d M Y');
		$email_user=$this->_ci->session->userdata('email_user');
		$config = Array(
					  'protocol' => 'smtp',
					  'smtp_host' => 'in-v3.mailjet.com',
					  'smtp_port' => 25,
					  'smtp_user' => 'b081d327903a7934ecaec92304bb1692', // change it to yours
					  'smtp_pass' => 'd4bd0f2cdbee63e3a1b031927f0d192b', // change it to yours
					  'mailtype' => 'html',
					  'charset' => 'iso-8859-1',
					  'wordwrap' => TRUE
					);
		
		$var['pref']=$this->preference;
		$var['data']=$row;
		$var['master']=$master;
		
		// $message=$this->_ci->load->view('email/billing',$var,true);
		$message = $this->get_data_email($row, $master);
		echo $message;
		die();
		
		$this->_ci->load->library('email', $config);
		$this->_ci->email->set_newline("\r\n");
		$this->_ci->email->from('abutiara@gmail.com'); // change it to yours
		$this->_ci->email->to($email_user);// change it to yours
		$this->_ci->email->subject($subject);
		$this->_ci->email->message($message);
		if($this->_ci->email->send())
		{
			echo 'Email sent.';
		}
		else
		{
			 echo $this->_ci->email->print_debugger();
			 die();
		}

	}
	
	function get_data_email($rows, $master){
		$style = '<style>
					*:before, *:after {
						box-sizing: border-box;
					}
					*:before, *:after {
						box-sizing: border-box;
					}
					.box .box-body .table {
						margin-bottom: 0;
					}
					
					.table {
						margin-bottom: 20px;
						max-width: 100%;
						width: 100%;
						background-color: transparent;
						border-collapse: collapse;
						border-spacing: 0;
						display: table;
						margin-top: 0;
						text-indent: 0;
					}
					
					tbody {
						display: table-row-group;
						vertical-align: middle;
					}
					
					tr {
						display: table-row;
						vertical-align: inherit;
					}
					
					.table-condensed > thead > tr > th, .table-condensed > tbody > tr > th, .table-condensed > tfoot > tr > th, .table-condensed > thead > tr > td, .table-condensed > tbody > tr > td, .table-condensed > tfoot > tr > td {
						padding: 5px;
					}

					.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
						border-top: 1px solid #ddd;
						line-height: 1.42857;
						padding: 8px;
						vertical-align: top;
					}
					</style>';
	
		$html ='<table border="0" width="100%"><tr>';
		$html .='<td>'.$this->preference['nama_kantor'].'</td></tr>';
		$html .='<tr><td>'.$this->preference['alamat_kantor'].'</td></tr>';
		$html .='<tr><td>Telp: '.$this->preference['telp_kantor'].' email: '.$this->preference['email_kantor'].'</td></tr></table><br/>';
		
		$html .="<strong>List Siswa</strong> <br/>";
		
		$html .="<table width='100%' class='table table-bordered table-striped'>";
		
		$html .="<thead><tr>";
		$html .="<th>No.</th>";
		foreach($master['title'] as $judul)
		{
			if (array_key_exists('2',$judul))
				$label=$judul[2];
			else
				$label=$judul[1];
			
			$html .="<th>".$label."</th>";
		}
		$html .="</tr></thead><tbody>";
		
		$no_urut=0;
		foreach($rows['fields'] as $row)
		{
			$kol=0;
			$html .="<tr><td>".++$no_urut."</td>";
			foreach($master['title'] as $judul)
			{
				foreach($master['fields'] as $field){
					if ($field['field']==$judul[1]){
						if (array_key_exists('label',$field)){
							$label=$field['label'];
						}else{
							'l_'.$judul[1];
						}
					}
				}
				$html .="<td>".$row[$label]."</td>";
			}
			$html .="</tr>";
		}
		$html .="</tr></tbody></table>";
		
		return $style.$html;
	}
}

// END Template class