<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('rupiah'))
{
	function rupiah($bil)
	{
		return "Rp " . number_format($bil,0,',',',');
	}
}

if ( ! function_exists('cek_form_validation'))
{
	function cek_form_validation($data = array()) {
		$valid=false;
		$CI =& get_instance(); 
		$rules=array('required','matches','is_unique','min_length','max_length','exact_length','greater_than','less_than','alpha','alpha_numeric','alpha_dash','numeric','integer','decimal','is_natural','is_natural_no_zero','valid_email','valid_emails','valid_ip','valid_base64','xss_clean','prep_for_form','prep_url','strip_image_tags','encode_php_tags');
		
		foreach($rules as $rule){
			$lang=lang("msg_rule_".$rule);
			if (!empty($lang)){
				$CI->form_validation->set_message($rule, lang('msg_rule_'.$rule));
				// echo "nonya ".$rule."<br>";
			}
		}
		
		foreach($data as $key=>$row){
			$ada=false;
			if (array_key_exists('show',$row)){
				if ($row['show']){
					if (array_key_exists('required',$row)){
						$msg_title=lang('msg_field_'.$row['field']);
						if (empty($msg_title)){
							$msg_title=$row['title'];
						}
						
						if (array_key_exists('label',$row))
							$label= $row['label'];
						else
							$label='l_'.$row['field'];
						
						if ($row['required']){
							if (array_key_exists('rule',$row['input'])){
								$rule='required';
								if(isset($row['input']['rule'])){
									$rule=$row['input']['rule'];
								}
							}else{
								$rule='required';
							}
							
							$valid=true;
							$ada=true;
						}elseif (array_key_exists('rule',$row['input'])){
							
							$rule=$row['input']['rule'];
							$valid=true;
							$ada=true;
						}
						if ($ada){
							$CI->form_validation->set_rules($label,$msg_title,$rule);
							// echo $row['field'].' - '.$rule." - ".$msg_title."<br>";
						}
						$ada=false;
						$rule='';
					}
				}
			}
		}
		// die();
		
		if ($valid){
			$proses=$CI->form_validation->run();
			// die(validation_errors());
			return $proses;
		}else{	
			return true;
		}
	}
}

if ( ! function_exists('tombol_cetak'))
{
	function tombol_cetak($tombol=array()) {
	
		$result=array();
		foreach($tombol as $tbl)
		{
			switch ($tbl){
				case "pdf":
					$result[]=array('label'=>'Pdf','type'=>'pdf','icon'=>'<i class="fa fa-file-pdf-o" style=""></i>&nbsp;&nbsp;');
					break;
				case "excel":
					$result[]=array('label'=>'Ms-Excel','type'=>'excel','icon'=>'<i class="fa fa-file-excel-o" style=""></i>&nbsp;&nbsp;');
					break;
				case "word":
					$result[]=array('label'=>'Ms-Word','type'=>'word','icon'=>'<i class="fa fa-file-word-o" style=""></i>&nbsp;&nbsp;');
					break;
				case "email":
					$result[]=array('label'=>'Email','type'=>'email','icon'=>'<i class="fa fa-envelope" style=""></i>&nbsp;&nbsp;');
					break;
				case "csv":
					$result[]=array('label'=>'CSV','type'=>'csv','icon'=>'<i class="fa fa-file-text" style=""></i>&nbsp;&nbsp;');
					break;
			}	
		}
		return $result;
	} 
}

if ( ! function_exists('dd'))
{
	function dd($data, $die=false) {
		$type = gettype($data);
		$result = "";

		switch ($type) {
			case 'array':
				$result .= 'result : '.count($data) . '<br>' . 
							str_replace("[", '<span class="dd-arrows text-red">[</span>',
								str_replace("]", '<span class="dd-arrows text-red">]</span>',
									str_replace(')', ']', 
										str_replace('array (', '[', 
											str_replace(" '", '<span class="text-yellow"> "', 
												str_replace("' ", '"</span> ', 
													str_replace("',", '"</span> ', 
														 
														var_export($data, true)
														
													)
												)
											)
										)
									)
								)
							);
				break;
			case 'integer':
				$result .= '<span class="text-red bold">'.$data.'</span>';
				break;
			case 'string':
				$result .= '<span class="text-yellow">"'.$data.'"</span>';
				break;
			case 'boolean':
				$result .= '<span class="text-yellow">"'.$data.'"</span>';
				break;
			default:
				$result .= '<span class="text-yellow">"'.$data.'"</span>';
				break;
		}
		echo "<html>";
		echo link_tag("https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/css/bootstrap.min.css");
		echo '<pre style="width:100%;overflow:auto; font-size: 10px;text-align:left">'.
					$result . 
			 '</pre>';
		if ($die == TRUE) {
			die();
		}
		echo "</html>";
		
	} 
}

if ( ! function_exists('huruf_kolom'))
{
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
		
		for ($i = 65;$i<= 90;++$i){
			$arrHuruf[++$j] = "D".chr($i);
		}
		
		for ($i = 65;$i<= 90;++$i){
			$arrHuruf[++$j] = "E".chr($i);
		}
		
		for ($i = 65;$i<= 90;++$i){
			$arrHuruf[++$j] = "F".chr($i);
		}
		return  $arrHuruf[$col];
	}
}

if ( ! function_exists('script_tag'))
{
    function script_tag($src = '', $language = 'javascript', $type = 'text/javascript', $index_page = FALSE, $html5 = true)
    {
        $CI =& get_instance();

        $script = '<scr'.'ipt';

        if (is_array($src))
        {
            foreach ($src as $k=>$v)
            {
                if ($k == 'src' AND strpos($v, '://') === FALSE)
                {
                    if ($index_page === TRUE)
                    {
                        $script .= ' src="'.$CI->config->site_url($v).'"';
                    }
                    else
                    {
                        $script .= ' src="'.$CI->config->slash_item('base_url').$v.'"';
                    }
                }
                else
                {
                    $script .= "$k=\"$v\"";
                }
            }

            $script .= "></scr'.'ipt>\n";
        }
        else
        {
            if ( strpos($src, '://') !== FALSE)
            {
                $script .= ' src="'.$src.'"'; // removed extra space - Bill Hernandez(Plano, Texas)
            }
            elseif ($index_page === TRUE)
            {
                $script .= ' src="'.$CI->config->site_url($src).'"'; // removed extra space - Bill Hernandez(Plano, Texas)
            }
            else
            {
                $script .= ' src="'.$CI->config->slash_item('base_url').$src.'"'; // removed extra space - Bill Hernandez(Plano, Texas)
            }

            if(false == $html5)                     // fixed a bug - Bill Hernandez(Plano, Texas)
            {
                $script .= ' language="'.$language; // added extra space - Bill Hernandez(Plano, Texas)
                $script .= '" type="'.$type.'"';
            }

            $script .= '></scr'.'ipt>'."\n";        // removed extra space - Bill Hernandez(Plano, Texas)
        }

        return $script;
    }
}

if ( ! function_exists('img_tag'))
{
    function img_tag($src = '')
    {
        $result = '<img src="'.$src.'"/>';
        return $result;
    }
}

if ( ! function_exists('is_model_exist'))
{
	function is_model_exist($model)
	{
		$ci =& get_instance();
		$load_arr = (array) $ci->load;
		$mod_arr = array();
		foreach ($load_arr as $key => $value)
		{
			if (substr(trim($key), 2, 50) == "_ci_model_paths"){
				$mod_arr = $value;
				break;
			}
		}
		
		$nama='models/'.ucfirst($model).'.php';
		foreach($mod_arr as $path)
		{
			if (file_exists($path.$nama))
				return true;
		}
		return false;
	}
}

if ( ! function_exists('show_404'))
{
	function show_404($page = '', $log_error = TRUE)
	{
		$_error =& load_class('Exceptions', 'core');
		$_error->show_404($page, $log_error);
		exit;
	}
}

if ( ! function_exists('format_hp'))
{
	function format_hp($hp)
	{
		$allowed = "/[^0-9]/i";
		$hp=preg_replace($allowed,"",$hp);
		$hp=floatval(trim($hp));
		
		$prefix=substr($hp,0,2);
		if ($prefix!=='62')
			$hp='62'.$hp;
		return '+'.$hp;
	}
}

if ( ! function_exists('format_list'))
{
	function format_list($str_arr)
	{
		$arr = explode(', ', $str_arr);
		$format = '<ol><li>' . implode( '</li><li>', $arr) . '</li></ol>';
		return $format;
	}
}

if ( ! function_exists('save_debug'))
{
	function save_debug($data=array()){
		$ci =& get_instance();
		
		$hasil=strpos($data['message'], 'language line');
		$hasil1=strpos($data['message'], 'language file');
			// doi::dump("nonya ".$hasil);
			// doi::dump("nonya ".$hasil1);
		if ($hasil=="0" && $hasil1=="0")
		{
			// doi::dump($data);
			// die();
			$nm_tbl='debug';
			if ($ci->authentication->is_loggedin()){
				$upd['user'] = $ci->authentication->get_Info_User('username');
				$upd['user_no'] = $ci->authentication->get_Info_User('identifier');
			}
			$upd['created_at'] = date('Y-m-d H:i:s');
			$upd['priority'] = 1;
			$upd['priority_name'] = $data['priority_name'];
			$upd['type'] = $data['type'];
			$upd['http_user_agent'] =  $_SERVER['HTTP_USER_AGENT'];
			$upd['remote_addr'] = $_SERVER['REMOTE_ADDR'];
			$upd['request_uri'] = $_SERVER['REQUEST_URI'];
			$upd['message'] = $data['message'];
			// Doi::dump($upd);
			$ci->db->insert($nm_tbl, $upd);
		}
	}
}

if ( ! function_exists('product_img'))
{
	function product_img($id){
		$ci =& get_instance();
        return json_decode($ci->db->where('id', $id)
                                ->get(_TBL_PRODUK)
                                ->row()
                                ->product_logo)[0]->nama;
	}
}

if ( ! function_exists('save_log'))
{
	function save_log($data=array()){
		$ci =& get_instance();
		if ($ci->authentication->is_loggedin()){
			if ($ci->authentication->get_Preference('status_log')){
				$nm_tbl='log';
				
				if(!array_key_exists('old_data', $data)){
					$data['old_data']=array();
				}
				if(!array_key_exists('new_data', $data)){
					$data['new_data']=array();
				}
				if(!array_key_exists('priority', $data)){
					$data['priority']=2;
				}
				
				if(!array_key_exists('priority_name', $data)){
					$data['priority_name']="";
				}
				if(!array_key_exists('type', $data)){
					$data['type']="";
				}
				if(!array_key_exists('message', $data)){
					$data['message']="";
				}
				
				$upd['tgl_proses'] = Doi::now();
				$upd['modul'] = $ci->uri->segment(1);
				if (empty($upd['modul']))
					$upd['modul'] = 'dashboard';
				if(!array_key_exists('type', $data)){
					$data['type']=$ci->uri->segment(2);
				}elseif (!empty($ci->uri->segment(2))){
					if ($ci->uri->segment(2)=='add' || $ci->uri->segment(2) =='edit' || $ci->uri->segment(3)=='delete' || $ci->uri->segment(2)=='print'){
						$data['type']=$ci->uri->segment(2);
					}
				}
				
				$upd['type'] = $data['type'];
				$upd['http_referer'] = (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "-");
				$upd['http_user_agent'] =  $_SERVER['HTTP_USER_AGENT'];
				$upd['remote_addr'] = $_SERVER['REMOTE_ADDR'];
				$upd['request_uri'] = $_SERVER['REQUEST_URI'];
				$upd['user'] = $ci->authentication->get_Info_User('username');
				$upd['user_no'] = $ci->authentication->get_Info_User('identifier');
				// $upd['jml'] = intval($data['jml']);
				$upd['db_dump'] = $data['message'];
				$upd['old_data'] = json_encode($data['old_data']);
				$upd['new_data'] = json_encode($data['new_data']);
				$ci->db->insert($nm_tbl,$upd);
			}
		}
	}
}

if ( ! function_exists('upload_image'))
{
	function upload_image($nmfile, $data=array(), $path='staft', $type='gif|jpg|png', $thumb=TRUE, $size='10000'){
		switch($path){
			case 'staft':
				$path=staft_path_relative();
				break;
			case 'slide':
				$path=slide_path_relative();
				break;
			case 'regulasi':
				$path=regulasi_path_relative();
				break;
			case 'rcsa':
				$path=rcsa_path_relative();
				break;
			case 'import':
				$path=import_path_relative();
				break;
			case 'export':
				$path=export_path_relative();
				break;
			default:
				$path=upload_path_relative();
				break;
		}
		// Doi::dump($_FILES);
		// die();
		// echo $path;
		$ci =& get_instance();
		$config['upload_path']=$path;
		if (empty($type))
			$type="pdf|jpg|png|doc|docx|xls|xlsx|ppt|pptx|rar|zip|gif";
		
		// Doi::dump($nmfile);
		// die($_FILES[$nmfile]['name']);
		$config['allowed_types']=$type;
		$config['max_size']=$size;
		$config['overwrite']=false;
		$config['encryp_name']=false;
		$config['remove_space']=true;
		$config['file_name']=md5($_FILES[$nmfile]['name']);
		// echo $config['file_name']."<br/>";
		if(! is_dir($config['upload_path'])){
			return false;
		}
		
		$ci->load->library('upload',$config);
		if(! $ci->upload->do_upload($nmfile)){
			$error = $ci->upload->display_errors();
			$msg=$error; 
			$ci->session->set_userdata(array('result_proses_error'=>$msg));
			$sql['message']='upload image profile';
			$sql['priority']=3;
			$sql['priority_name']='Biasa';
			$sql['type']='image';
			$sql['jml']=1;
			save_log($sql);
			$id=0;
			
			return false;
		}else{
			$result= $ci->upload->data();
		}
		if ($thumb){
			create_thumb($result['file_name'], 160, $path);
			create_thumb($result['file_name'], 60, $path);
		}
		return $result;
	}
}


if ( ! function_exists('upload_image_new'))
{
	function upload_image_new($data=array(), $multi=false, $no=0){
		// Doi::dump($data);
		
		if (!array_key_exists('path', $data))
			$data['path']='staft';
		if (!array_key_exists('nm_random', $data))
			$data['nm_random']=TRUE;
		if (!array_key_exists('type', $data))
			$data['type']='gif|jpg|png';
		if (!array_key_exists('thumb', $data))
			$data['thumb']=TRUE;
		if (!array_key_exists('size', $data))
			$data['size']=10000;
		if (!array_key_exists('sub_path', $data))
			$data['sub_path']='';
		if (!array_key_exists('file_name', $data))
			$data['file_name']=$_FILES[$data['nm_file']]['name'];
			// $data['file_name']=url_title(strtolower($_FILES[$data['nm_file']]['name']));
		// Doi::dump($_FILES[$data['nm_file']]);
		switch($data['path']){
			case 'staft':
				$path=staft_path_relative();
				break;
			case 'slide':
				$path=slide_path_relative();
				break;
			case 'regulasi':
				$path=regulasi_path_relative();
				break;
			case 'rcsa':
				$path=rcsa_path_relative();
				break;
			case 'import':
				$path=import_path_relative();
				break;
			case 'export':
				$path=export_path_relative();
				break;
			case 'events':
				$path=events_path_relative();
				break;
			case 'img':
				$path=img_path_relative();
				break;
			case 'upload':
				$path=upload_path_relative();
				break;
			default:
				$path=upload_path_relative();
				break;
		}
		if (defined('_CABANG_NO_')){
			$fld = strtolower(_CABANG_NO_ . '-' . url_title(_CABANG_KODE_));
			// echo $fld;
			if (!is_dir($path.'/'.$fld)) {
				mkdir($path.'/'.$fld, 0777, TRUE);
			}
			$path .= '/'.$fld;
		}
		// die("cabang nya : "._CABANG_NO_." namanya :"._CABANG_NAMA_);
		
		$ci =& get_instance();
		$config['upload_path']=$path;
		
		$config['allowed_types']=$data['type'];
		$config['max_size']=$data['size'];
		$config['overwrite']=false;
		$config['encryp_name']=false;
		$config['remove_space']=true;
		// if (array_key_exists('file_name', $data)){
			// $config['file_name']=$data['file_name'];
		// }else{
			// $config['file_name']=$_FILES[$data['nm_file']]['name'];
		// }
		// die();
		
		$data['file_name'] = preg_replace('/(.*)\\.[^\\.]*/', '$1', $data['file_name']);
		if ($data['nm_random'])
			$config['file_name']=md5($data['file_name'].time());
		else
			$config['file_name']=url_title(strtolower(basename($data['file_name'])));
		
		if(!is_dir($config['upload_path'])){
			Doi::dump($config['upload_path']);
			return false;
		}
		// Doi::dump($config);
		// Doi::dump("nonya ".$no);
		// Doi::dump(" - nonya ".$multi);
		if (($multi && $no==0) || !$multi){
			$ci->load->library('upload',$config);
		}else{
			$ci->load->library('upload',$config);
			$ci->upload->initialize($config, true);
		}
		if(! $ci->upload->do_upload($data['nm_file'])){
			$error = $ci->upload->display_errors();
			// Doi::dump($data);
			// Doi::dump($config);
			// Doi::dump($_FILES['userfile']);
			die($error);
			$msg=$error;
			$ci->session->set_userdata(array('result_proses_error'=>$msg));
			$sql['message']='upload image gagal ' . $_FILES[$data['nm_file']]['name'] ;
			$sql['priority']=3;
			$sql['priority_name']='Biasa';
			$sql['type']='image';
			$sql['jml']=1;
			$sql['old_data']="";
			$sql['new_data']="";
			$id=0;
			return false;
		}else{
			$result= $ci->upload->data();
		}
		if ($data['thumb']){
			create_thumb($result['file_name'], 160, $path);
			create_thumb($result['file_name'], 60, $path);
		}
		// if (defined('_CABANG_NO_')){
			// $result['file_name'] = $fld . "/". $result['file_name'];
		// }
		return $result;
	}
}

if ( ! function_exists('create_thumb'))
{
	function create_thumb($file_name, $width, $path) {
		$ci =& get_instance();
		$ci->load->library('image_lib');
		$arrpic=explode('.',$file_name);
		$nmpic=$arrpic[count($arrpic)-2];
		$ext=$arrpic[count($arrpic)-1];
		$img_cfg['image_library'] = 'gd2';
		$img_cfg['source_image'] = $path . $file_name;
		$img_cfg['maintain_ratio'] = TRUE;
		$img_cfg['create_thumb'] = TRUE;
		
		// die($path. $nmpic.'_'.$width.'_'.$width.'.'.$ext);
		$img_cfg['new_image'] = $path . 'thumb_' . $width . '/' . $nmpic.'_'.$width.'_'.$width.'.'.$ext;
		$img_cfg['width'] = $width;
		$img_cfg['quality'] = 100;
		$img_cfg['height'] = $width;

		$ci->image_lib->initialize($img_cfg);
		$ci->image_lib->resize();
	}
}

if ( ! function_exists('show_image'))
{
	function show_image($nmfile, $width=0, $scale=0, $pathx='staft', $id=0, $class="") {
		$size=$width;
		switch($pathx){
			case 'staft':
				$path=staft_url();
				$path_relatif=staft_path_relative();
				break;
			case 'slide':
				$path=slide_url();
				$path_relatif=slide_path_relative();
				break;
			case 'regulasi':
				$path=regulasi_url();
				$path_relatif=regulasi_path_relative();
				break;
			case 'rcsa':
				$path=rcsa_url();
				$path_relatif=rcsa_path_relative();
				break;
			case 'export':
				$path=export_url();
				$path_relatif=peserta_path_relative();
				break;
			case 'import':
				$path=import_url();
				$path_relatif=import_path_relative();
				break;
			default:
				$path=upload_url();
				$path_relatif=upload_path_relative();
				break;
		}
		
		$o='';
		if(!empty($nmfile)){
			$arrpic=explode('.',$nmfile);
			if ($width>0 && count($arrpic)>=2){
				$nmpic=$arrpic[count($arrpic)-2].'_'.$width.'_'.$width.'_thumb';
				$ext='.'.$arrpic[count($arrpic)-1];
				$nmpic = $nmpic.$ext;
				$width='thumb_' . $width . '/';
			}else{
				$nmpic=$nmfile;
				$width='';
			}
			$path .= $width;
			$path_relatif .= $width;
			if ($scale>0){
				$scale = " width='".$scale."'";
			}else{
				$scale="";
			}
			if (file_exists($path_relatif.$nmpic)){
				$o = '<img id="'.$id.'" class="'.$class.'" data-id="'.$id.'" src="'.$path . $nmpic.'" alt="image"/>';
			}else{
				$img='male';
				$img.=($size>0)?'_60':'';
				$img.='.png';
				$o = '<img id="thumbnil" class="text-center detail-img pointer '.$class.'" data-id="'.$id.'" data-kelompok="'.$pathx.'"  src="'.img_url($img).'" alt="image" '.$scale.'/>';
			}
		}else{
			$o = '<img id="thumbnil" class="text-center detail-img pointer '.$class.'" data-id="'.$id.'" data-kelompok="'.$pathx.'"  src="'.img_url('male'.($width>0)?'_60':''.'.png').'" alt="image" '.$scale.' width="40"/>';
		}
		return $o;
	}
}

if ( ! function_exists('create_unique_slug'))
{
	 function create_unique_slug($string, $table, $field='uri_title')
	{
		$CI =& get_instance();
		$slug = url_title($string);
		$slug = strtolower($slug);
		$i = 0;
		$params = array ();
		$params[$field] = $slug;
		if ($CI->input->post('id')) {
			$params['id !='] = $CI->input->post('id_edit');
		}
		
		while ($CI->db->where($params)->get($table)->num_rows()) {
		if (!preg_match ('/-{1}[0-9]+$/', $slug )) {
			$slug .= '-' . ++$i;
		} else {
			$slug = preg_replace ('/[0-9]+$/', ++$i, $slug );
		}
		$params [$field] = $slug;
		}
		
		return $slug;
	}  
}

if ( ! function_exists('read_more'))
{
	 function read_more($content, $batas='###break###', $sts='')
	{
		if (empty($sts)){
			$content = explode($batas, $content);
			$content = $content[0];
		}else{
			$content = str_replace($batas,'',$content);
		}
		return $content;
	}  
}
	
if ( ! function_exists('get_help'))
{
	function get_help($field=''){
		$CI =& get_instance();
		$x=lang($field);
		$help="";
		if ($CI->authentication->get_Preference('help_tool')=='yes'){
			if ($CI->config->item('sts_mdl_help')){
				if (!empty($x)){
					$help="&nbsp;&nbsp;&nbsp;&nbsp;<span class='glyphicon glyphicon-info-sign pointer text-primary' data-container='body' data-toggle='popover' data-placement='top' data-content='".$x."' style='cursor:help;'></span>";
				}
			}
		}
		return $help;
	}
}

if ( ! function_exists('time_ago'))
{
	function time_ago($tgl, $unit=6){
		$CI =& get_instance();
		$CI->lang->load('date');
		
		$str = array();
		// $xx=date('Y-m-d H:i:s') ;
		$waktu_tujuan = strtotime($tgl);
		$waktu_sekarang = mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"));
		// echo $tgl . ' ' . $xx . "<br>";
		// echo $waktu_sekarang . ' ' . $waktu_tujuan . "<br>";
		// die();

		//hitung selisih kedua waktu
		$selisih_waktu = $waktu_sekarang - $waktu_tujuan;
		
		//Untuk menghitung jumlah dalam satuan hari:
		$jumlah_tahun = floor($selisih_waktu/31557600);
		if ($jumlah_tahun > 0)
		{
			$str[] = $jumlah_tahun.' '.$CI->lang->line($jumlah_tahun > 1 ? 'date_years' : 'date_year');
		}
		
		//Untuk menghitung jumlah dalam satuan hari:
		$sisa = $selisih_waktu % 31557600;
		$jumlah_bulan = floor($sisa/2629743);
		if ($jumlah_bulan > 0)
		{
			$str[] = $jumlah_bulan.' '.$CI->lang->line($jumlah_bulan > 1 ? 'date_months' : 'date_month');
		}
		
		//Untuk menghitung jumlah dalam satuan hari:
		$sisa = $selisih_waktu % 2629743;
		$jumlah_minggu = floor($sisa/604800);
		if ($jumlah_minggu > 0)
		{
			$str[] = $jumlah_minggu.' '.$CI->lang->line($jumlah_minggu > 1 ? 'date_weeks' : 'date_week');
		}
		
		//Untuk menghitung jumlah dalam satuan hari:
		$sisa = $selisih_waktu % 604800;
		$jumlah_hari = floor($sisa/86400);
		if ($jumlah_hari > 0)
		{
			$str[] = $jumlah_hari.' '.$CI->lang->line($jumlah_hari > 1 ? 'date_days' : 'date_day');
		}
		
		//Untuk menghitung jumlah dalam satuan jam:
		$sisa = $selisih_waktu % 86400;
		$jumlah_jam = floor($sisa/3600);
		if ($jumlah_jam > 0)
		{
			$str[] = $jumlah_jam.' '.$CI->lang->line($jumlah_jam > 1 ? 'date_hours' : 'date_hour');
		}
		
		//Untuk menghitung jumlah dalam satuan menit:
		$sisa = $sisa % 3600;
		$jumlah_menit = floor($sisa/60);
		if ($jumlah_menit > 0)
		{
			$str[] = $jumlah_menit.' '.$CI->lang->line($jumlah_menit > 1 ? 'date_minutes' : 'date_minute');
		}
		// die(implode(', ', $str));
		$result=$CI->lang->line("date_a_few");
		if (count($str)>0)
			$result=$str[0] . $CI->lang->line("date_ago");;
		
		return $result;
	}
}

if ( ! function_exists('_tree'))
{
	 function _tree(array $elements, $parentId = 0)
	{
		$branch = array();
		foreach ($elements as $element) {
			if ($element['slug'] == $parentId) {
				$children = _tree($elements, $element['id']);
				if ($children) {
					$element['children'] = $children;
				}
				$branch[] = $element;
			}
		}
		return $branch;
	}  
}

if ( ! function_exists('_build_menu'))
{
	function _build_menu($pos="kiri") {
		$ci =& get_instance();
		$ad = $ci->authentication->get_menus($pos);
		$html='';
		$item='';
		if ($ad){
			if ($pos=='kiri'){
				foreach($ad as $row){
					$item .= _menu_kiri($row);
				}
				$html = '<ul class="nav side-menu">';
				
				// $html .= '<li class="header">'.lang('msg_label_header_menu').'</li>';
				$html .= '<li>
							  <a href="'.base_url('dashboard').'">
							  	<i class="fa fa-dashboard fa-fw s24"></i>
							  	<span>'.lang('msg_mdl_dashboard').'</span>
							  </a>
						  </li>';
						
				$html .=$item;
				$html .='<li>
						 	<a href="'.base_url('auth/logout').'" id="logout">
						 		<i class="fa fa-sign-out fa-fw"></i>
						 	<span>'.lang('msg_mdl_logout').'</span></a>
						 </li>';
				$html .='</ul>';
			}elseif($pos=='atas-kiri' || $pos=='atas-kanan'){
				foreach($ad as $row){
					$item .= _menu_atas($row);
				}
				$html = $item;
			}
		}
		
		return $html;
	}
}

if ( ! function_exists('_get_menu'))
{
	function _get_menu($pos="kiri") {
		$ci =& get_instance();
		$ad = $ci->authentication->get_menus($pos);
		$html='';
		$item='';
		if ($ad){
			if ($pos=='kiri'){
				foreach($ad as $row){
					$item .= _left_menu($row);
				}
				$html = '<ul class="sidebar-menu">';
				
				$html .= '<li class="header"><strong>'.lang('msg_label_header_menu').'</strong></li>';

				// $html .= '<li class="treeview">
				//              <a href="'.base_url().'">
				//             	 <i class="icon icon-sailing-boat-water blue-text s-18"></i><span class="">Home</span>
				//              </a>
				//           </li>';
						
				$html .= $item;
				$html .='<li>
						 	<a href="'.base_url('auth/logout').'" id="logout">
						 		<i class="icon fa fa-sign-out red-text s-14 fa-fw"></i><span class="">'.lang('msg_mdl_logout').'</span>
						 	</a>
						 </li>';
				$html .='</ul>';
			}elseif($pos=='atas-kiri' || $pos=='atas-kanan'){
				foreach($ad as $row){
					$item .= _menu_atas($row);
				}
				$html = $item;
			}
		}
		
		return $html;
	}
}

if ( ! function_exists('_left_menu'))
{
	function _left_menu($ad) {
		if ($ad['nm_modul']=='#'){
			$url='';
		}else{
			$url="href='".base_url($ad['nm_modul'])."' ";
		}
		
		$bahasa_mdl=lang('msg_mdl_'.str_replace('-','_',$ad['nm_modul']));
		
		if ($ad['nm_modul']=='#')
			$bahasa_mdl=lang('msg_mdl_'.url_title(strtolower($ad['title'])));
		
		if (empty($bahasa_mdl))
			$bahasa_mdl=$ad['title'];
		
		$icon_down='';
		$class='';

		if (array_key_exists('children', $ad)) {
			$icon_down='<i class="icon icon-angle-left pull-right"></i>';
			$class=" class='nav child_menu' data-toggle='dropdown'";
		}
		
		$icon='<i class="icon '.$ad['icon'].' red-text"></i>';
		
		$isi = sprintf("<a %s>%s<span class=''>%s</span>%s</a>", $url, $icon, $bahasa_mdl, $icon_down);
		$html = "<li class='treeview' data-modul='".$ad['nm_modul']."'>".$isi;

		if (array_key_exists('children', $ad)) {	
			$html .= '<ul class="treeview-menu" data-id="'.$ad['pid'].'" data-parent="'.$ad['pid'].'">';
			foreach($ad['children'] as $row){
				$html .= _left_menu($row);
			}
			$html .= "</ul>";
		}	
		$html .= "</li>";
		return $html;
	}
}

if ( ! function_exists('_menu_kiri'))
{
	function _menu_kiri($ad) {
		if ($ad['nm_modul']=='#'){
			$url='';
		}else{
			$url="href='".base_url($ad['nm_modul'])."' ";
		}
		
		$bahasa_mdl=lang('msg_mdl_'.str_replace('-','_',$ad['nm_modul']));
		
		if ($ad['nm_modul']=='#'){
			$bahasa_mdl=lang('msg_mdl_'.url_title(strtolower($ad['title'])));
		}
		
		if (empty($bahasa_mdl))
			$bahasa_mdl=$ad['title'];
		
		$icon_down='';
		$class='';
		if (array_key_exists('children', $ad)) {
			$icon_down='<span class="fa fa-chevron-down"></span>';
			$class=" class='nav child_menu' data-toggle='dropdown' ";
		}
		
		$icon='<i class="'.$ad['icon'].' fa-fw"></i> ';
		
		$isi = sprintf("<a %s title='%s'>%s%s%s</a>", $url, $bahasa_mdl, $icon, '<span>' . $bahasa_mdl . '</span>', $icon_down);
		
		$html = "<li data-modul='".$ad['nm_modul']."'>".$isi;
		if (array_key_exists('children', $ad)) {	
			$html .= '<ul class="nav child_menu" data-id="'.$ad['pid'].'" data-parent="'.$ad['pid'].'">';
			foreach($ad['children'] as $row){
				$html .= _menu_kiri($row);
			}
			$html .= "</ul>";
		}	
		$html .= "</li>";
		return $html;
	}
}

if ( ! function_exists('_menu_atas'))
{
	function _menu_atas($ad) {
		if ($ad['nm_modul']=='#'){
			$url='#';
		}else{
			$url=base_url($ad['nm_modul']);
		}
		
		$bahasa_mdl=lang('msg_mdl_'.str_replace('-','_',$ad['nm_modul']));
		
		if ($ad['nm_modul']=='#'){
			$bahasa_mdl=lang('msg_mdl_'.url_title(strtolower($ad['title'])));
		}
		if (empty($bahasa_mdl))
			$bahasa_mdl=$ad['title'];
		
		$icon_down='';
		$class='';
		if (array_key_exists('children', $ad)) {
			$class=" class='dropdown-toggle trigger right-caret' data-toggle='dropdown' ";
			if ($ad['pid']==0){
				$icon_down='<span class="caret"></span>';
				$class=" class='dropdown-toggle' data-toggle='dropdown' ";
			}
		}
		
		$icon='<i class="'.$ad['icon'].'"></i> ';
		
		$isi = sprintf("<a href='%s' title='%s' %s>%s %s %s</a>", $url, $bahasa_mdl, $class, $icon, '<span>' . $bahasa_mdl . '</span>', $icon_down);
		
		if (array_key_exists('children', $ad)) {	
			$html = "<li class='dropdown'>".$isi;
			$html .= '<ul class="dropdown-menu sub-menu"  role="menu" data-id="'.$ad['pid'].'" data-parent="'.$ad['pid'].'">';
			foreach($ad['children'] as $row){
				$html .= _menu_atas($row);
			}
			$html .= "</ul>";
		}else{
			$html = "<li class='dropdown'>".$isi;
		}
		$html .= "</li>";
		return $html;
	}
}

if ( ! function_exists('cari_no_bukti'))
{
	function cari_no_bukti($no_last, $no_format, $rule=array()){
		$CI =& get_instance();
		
		$CI->db->select('*');
		$CI->db->from('preference');
		$CI->db->where('uri_title',$no_last);
		$query=$CI->db->get();
		$rows=$query->row();
		$last_no=intval($rows->value)+1;
		
		$CI->db->select('*');
		$CI->db->from('preference');
		$CI->db->where('uri_title',$no_format);
		$query=$CI->db->get();
		$rows=$query->row();
		$format=$rows->value;
		
		$format = str_replace('#no#', $last_no, $format);
		foreach($rule as $key=>$rl){
			$format = str_replace('#'.$key.'#', $rl, $format);
		}
		
		$format = format_serti($format);
		
		$result=$CI->crud->crud_data(array('table'=>'preference', 'field'=>array('value'=>$last_no),'where'=>array('uri_title'=>$no_last),'type'=>'update'));
		
		$hasil=$format;
		return $hasil;
	}
}

if ( ! function_exists('format_serti'))
{
	function format_serti($format){
		$arrblnR=array(1=>'I',2=>'II',3=>'III',4=>'IV',5=>'V',6=>'VI',7=>'VII',8=>'VIII',9=>'IX',10=>'X',11=>'XI',12=>'XII');
		$arrbln=array(1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10,11=>11,12=>12);
		
		$format = str_replace('#no#', "", $format);
		$format = str_replace('#blnR#', $arrblnR[date('n')], $format);
		$format = str_replace('#bln#', date('m'), $format);
		$format = str_replace('#thn#', date('Y'), $format);
		$format = str_replace('#tgl#', date('d'), $format);
		$format = str_replace('#th#', date('y'), $format);
		return $format;
	}
}

if ( ! function_exists('romanic_number'))
{
	function romanic_number($integer, $upcase = true) 
	{ 
		$table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1); 
		$return = ''; 
		while($integer > 0) 
		{ 
			foreach($table as $rom=>$arb) 
			{ 
				if($integer >= $arb) 
				{ 
					$integer -= $arb; 
					$return .= $rom; 
					break; 
				} 
			} 
		} 

		return $return; 
	} 
} 

if ( ! function_exists('terbilang'))
{
	function terbilang($x){
        $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        if ($x < 12)
        return " " . $abil[$x];
        elseif ($x < 20)
        return terbilang($x - 10) . "belas";
        elseif ($x < 100)
        return terbilang($x / 10) . " puluh" . terbilang($x % 10);
        elseif ($x < 200)
        return " seratus" . terbilang($x - 100);
        elseif ($x < 1000)
        return terbilang($x / 100) . " ratus" . terbilang($x % 100);
        elseif ($x < 2000)
        return " seribu" . terbilang($x - 1000);
        elseif ($x < 1000000)
        return terbilang($x / 1000) . " ribu" . terbilang($x % 1000);
        elseif ($x < 1000000000)
        return terbilang($x / 1000000) . " juta" . terbilang($x % 1000000);
    }
}

if ( ! function_exists('pagination'))
{
	function pagination($url, $rowscount, $per_page, $uri=3) {
		$ci = & get_instance();
		$ci->load->library('pagination');
		
		$config = array();
		$config["base_url"] = base_url($url);
		$config["total_rows"] = $rowscount;
		$config["per_page"] = $per_page;
		$config["uri_segment"] = $uri;
		$config['full_tag_open'] = '<nav><ul class="pagination pagination-xs">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['next_link'] = '&rsaquo;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['prev_link'] = '&lsaquo;';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$ci->pagination->initialize($config);
		return $ci->pagination->create_links();
	}
}

if ( ! function_exists('cek_nama_file'))
{
	function cek_nama_file($folder=4, $nama=5) {
		$ci = & get_instance();
		$folder=$ci->uri->segment($folder);
		$nmfile=$ci->uri->segment($nama);
		if (empty($nmfile))
			$nmfile=$ci->uri->segment($folder);
		else
			$nmfile=$folder . '/'.$nmfile;
		
		return $nmfile;
	}
}

if ( ! function_exists('get_csrf')){
	function get_csrf()
	{
		$error['csrf_token'] = $this->security->get_csrf_hash();
		echo json_encode($error);
		die();
	}
}

if ( ! function_exists('hexToRgb')){
	function hexToRgb($hex, $alpha = false) {
	   $hex      = str_replace('#', '', $hex);
	   $length   = strlen($hex);
	   $rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
	   $rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
	   $rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
	   if ( $alpha ) {
		  $rgb['a'] = $alpha;
	   }
	   return $rgb;
	}
}

if ( ! function_exists('getUserIP')){
	function getUserIP() {
		if( array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
			if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',')>0) {
				$addr = explode(",",$_SERVER['HTTP_X_FORWARDED_FOR']);
				return trim($addr[0]);
			} else {
				return $_SERVER['HTTP_X_FORWARDED_FOR'];
			}
		}
		else {
			return $_SERVER['REMOTE_ADDR'];
		}
	}
}

if ( ! function_exists('split_words'))
{
	function split_words($string, $nb_caracs){
		$final_string = "";
		$string = strip_tags(html_entity_decode($string));
		if( strlen($string) <= $nb_caracs ){
			$final_string = $string;
		} else {
			$final_string = "";
			$words = explode(" ", $string);
			foreach( $words as $value ){
				if( strlen($final_string . " " . $value) < $nb_caracs ){
					if( !empty($final_string) ) $final_string .= " ";
					$final_string .= $value;
				} else {
					break;
				}
			}
		}
		return $final_string;
	}
}
if ( ! function_exists('set_nilai_map'))
{
	function set_nilai_map($value){
		$jml=0;
		$span='';
		$jml=$value;
		if (intval($jml)>0){
			$span='<span class="span_map">'.$jml.'</span>';
		}
		
		return $span;
	}
}

if ( ! function_exists('draw_map'))
{
	function draw_map($data, $width='100', $type_map='residual', $info=array('title'=>'','sub_title'=>'','level_title'=>1),$color='#ffffff'){
		$CI =& get_instance();
		$rcsa_no=0;
		$rcsa=$data['rcsa'];
		$arr_rcsa=array();
		
		foreach($rcsa as $row){
			$arr_rcsa[]=$row['id'];
		}
		$rcsa_no=implode(',',$arr_rcsa);
		
		$param=$data['tbl'][$type_map]['param'];
		$data=$data['tbl'][$type_map]['jml'];
		
		$judul='';
		
		if (array_key_exists('level_title',$info)){
			if ($info['level_title'])
				$judul = $CI->lang->line("msg_field_titel_map_".$type_map);
		}
		
		$info=json_encode($info);
		// Doi::dump($param);die();
		// if ($rcsa)
			// $rcsa_no=$rcsa[0]['id'];
		// Doi::dump($rcsa);;
		
		$content = '<div class=""><div style="padding:10px 0;font-size:18px;margin-left:75px;" class="text-center"><strong><i class="fa fa-maps"></i> '.$judul.'</strong></div><table class="table no-padding no-margin borderless text-center" style="width:'.$width.'%;margin:0 auto;">';
		$i=0;
		$title_impact=array();
		foreach($data as $ket_set=>$set){
			$x=0;
			$content .= '<tr>';
			if ($i==0){
				$content .= '<td width="5%" style="border:none;width:5%;vertical-align:middle" class="text-center" rowspan="'.count($data).'"><img src="'.img_url('likelihood.jpg').'"></td>';
			}
			$content .= '<td class="text-center">'.$set['code'].'</td>';
			foreach($set['isi'] as $ket=>$row){
				if ($i==0){ 
					$title_impact[]=$row['code'];
				}
				$span=set_nilai_map($row['jml']);
				$content .= '<td class="cursor td-map detail-map text-center" style="text-align:center;padding:13px 0 0 0;border:'.$CI->authentication->get_Preference('map_border_width').' '.$CI->authentication->get_Preference('map_border_type').' '.$CI->authentication->get_Preference('map_border_color').';background-color:'.$row['color'].';color:'.$color.';" title="'.$row['jml'].'"  value="'.$row['id'].'"  rcsa="'.$rcsa_no.'"  typemap="'.$type_map.'" data-param='.$param.' data-info="'.htmlspecialchars($info, ENT_QUOTES, 'UTF-8').'">'.$span.'</td>';
				$x++;
			}
			$i++;
			$content .= '</tr>';
		}
		$content .= '<tr>
					<td style="border:none;">&nbsp;</td>
					<td style="border:none;">&nbsp;</td>';
		foreach($title_impact as $title){
			$content .= '<td>'.$title.'</td>';
		}
		$content .= '</tr>
					<tr>
						<td style="border:none;">&nbsp;</td>
						<td style="border:none;">&nbsp;</td>
						<td colspan="'.$x.'" class="text-center" style="border:none;"><img src="'.img_url('impact.jpg').'"></td>
					</tr>
				</table>
				<div id="overlay" class="overlay hide">
					<i class="fa fa-refresh fa-spin"></i>
				</div>
				</div>';
		return $content;
	}
}

if ( ! function_exists('draw_map_exposure'))
{
	function draw_map_exposure($data, $width='100', $type_map='residual', $back=0, $no_urut=0){
		$CI =& get_instance();
		$rcsa_no=0;
		
		$owner = $data['owner'];
		// Doi::dump($owner);die();
		$data=$data['tbl'][$type_map]['jml'];
		
		$judul = $CI->lang->line("msg_field_titel_map_".$type_map);
		
		if ($owner['parent_no']==0){
			$back=0;
		}
		
		$content = '<table class="borderless" width="100%"><tr><td rowspan="3" width="22%">'.$owner['photo'].'</td><td width="15%">Owner</td><td width="3%"> : </td><td width="60%" class="text-left"><strong>'.$owner['name'].'</strong></td></tr><tr><td>Name</td><td> : </td><td class="text-left"><strong>'.$owner['person_name'].'</strong></td></tr><tr><td>Eksposure <sup>*</sup></td><td> : </td><td class="text-left"><strong>'.number_format($owner[$type_map]/1000000).'</strong></td>
		</tr></table>';
		$content .= '<div style="padding:10px 0;font-size:18px;margin-left:75px;" class="text-center"><strong><i class="fa fa-maps"></i> '.$judul.'</strong></div><table class="table no-padding no-margin borderless text-center" style="width:'.$width.'%;margin:0 auto;">';
		$i=0;
		$title_impact=array();
		foreach($data as $ket_set=>$set){
			$x=0;
			$content .= '<tr>';
			if ($i==0){
				$content .= '<td width="5%" style="border:none;width:5%;vertical-align:middle" class="text-center" rowspan="'.count($data).'"><img src="'.img_url('likelihood.jpg').'"></td>';
			}
			$content .= '<td class="text-center">'.$set['code'].'</td>';
			foreach($set['isi'] as $ket=>$row){
				if ($i==0){ 
					$title_impact[]=$row['code'];
				}
				$span=set_nilai_map($row['jml']);
				$content .= '<td class="cursor td-map detail-exposure" style="padding:13px 0 0 0;border:'.$CI->authentication->get_Preference('map_border_width').' '.$CI->authentication->get_Preference('map_border_type').' '.$CI->authentication->get_Preference('map_border_color').';background-color:'.$row['color'].';color:#ffffff;" title="'.$row['jml'].'"  value="'.$row['id_detail'].'"  typemap="'.$type_map.'" data-back="'.$back.'" data-urut="'.$no_urut.'"  data-owner="'.$owner['id'].'">'.$span.'</td>';
				$x++;
			}
			$i++;
			$content .= '</tr>';
		}
		$content .= '<tr>
					<td style="border:none;">&nbsp;</td>
					<td style="border:none;">&nbsp;</td>';
		foreach($title_impact as $title){
			$content .= '<td>'.$title.'</td>';
		}
		$content .= '</tr>
					<tr>
						<td style="border:none;">&nbsp;</td>
						<td style="border:none;">&nbsp;</td>
						<td colspan="'.$x.'" class="text-center" style="border:none;"><img src="'.img_url('impact.jpg').'"></td>
					</tr></table><br/>&nbsp<sup>*)dalam jutaan</sup>';
		return $content;
	}
}

if ( ! function_exists('checkPassword'))
{
	function checkPassword($pwd, &$errors) {
		$CI =& get_instance();
		$errors_init = $errors;

		if (strlen($pwd) < intval($CI->authentication->get_Preference('pass_min'))) {
			$errors[] = str_replace('[n]',$CI->authentication->get_Preference('pass_min'), lang('msg_pass_min'));
		}
		
		if (strlen($pwd) > intval($CI->authentication->get_Preference('pass_max'))) {
			$errors[] = str_replace('[n]',$CI->authentication->get_Preference('pass_max'),lang('msg_pass_max'));
		}
		
		if (intval($CI->authentication->get_Preference('pass_number'))==1) {
			if (!preg_match("#[0-9]+#", $pwd)) {
				$errors[] = lang('msg_pass_number');
			}
		}
		
		if (intval($CI->authentication->get_Preference('pass_letter'))==1) {
			if (!preg_match("#[a-zA-Z]+#", $pwd)) {
				$errors[] = lang('msg_pass_letter');
			}     
		}     
		
		if (intval($CI->authentication->get_Preference('pass_upper'))==1) {
			if( !preg_match("#[A-Z]+#", $pwd) ) {
				$errors[] = lang('msg_pass_upper');
			}
		}
		
		if (intval($CI->authentication->get_Preference('pass_lower'))==1) {
			if( !preg_match("#[a-z]+#", $pwd) ) {
				$errors[] = lang('msg_pass_lower');
			}
		}
		
		if (intval($CI->authentication->get_Preference('pass_symbol'))==1) {
			if( !preg_match("#\W+#", $pwd) ) {
				$errors[] = lang('msg_pass_symbol');
			}
		}
		// Doi::dump($errors);die();
		return $errors;
	}
}

if ( ! function_exists('is_decimal'))
{
	function is_decimal( $val )
	{
		return is_numeric( $val ) && floor( $val ) != $val;
	}
}
if ( ! function_exists('comment_time'))
{
	function comment_time($timestamp)
	{
	    $selisih = time() - strtotime($timestamp) ;

	    $detik = $selisih ;
	    $menit = round($selisih / 60 );
	    $jam = round($selisih / 3600 );
	    $hari = round($selisih / 86400 );
	    $minggu = round($selisih / 604800 );
	    $bulan = round($selisih / 2419200 );
	    $tahun = round($selisih / 29030400 );

	    if ($detik <= 60) {
	        $waktu = $detik.' detik yang lalu';
	    } else if ($menit <= 60) {
	        $waktu = $menit.' menit yang lalu';
	    } else if ($jam <= 24) {
	        $waktu = $jam.' jam yang lalu';
	    } else if ($hari <= 7) {
	        $waktu = $hari.' hari yang lalu';
	    } else if ($minggu <= 4) {
	        $waktu = $minggu.' minggu yang lalu';
	    } else if ($bulan <= 12) {
	        $waktu = $bulan.' bulan yang lalu';
	    } else {
	        $waktu = $tahun.' tahun yang lalu';
	    }
	    
	    return $waktu;
	}
}


if ( ! function_exists('save_attacker'))
{
	function save_attacker($data=array()){
		$ci =& get_instance();
		$nm_tbl='log_security';
		if ($ci->authentication->is_loggedin()){
			$upd['create_user'] = $ci->authentication->get_Info_User('username');
		}
		$upd['attack_type'] = $data['attack_type'];
		$upd['data'] = $data['data'];

		/* save log serangan */
		$ci->db->insert($nm_tbl, $upd);

		/* selanjutnya sistem menonaktifkan akun user yang menyerang,
		 bisa dengan cara update status user agar tidak dapat login setelah melakukan serangan
		 dan sistem akan otomatis melogout user tersebut */

	}
}


?>