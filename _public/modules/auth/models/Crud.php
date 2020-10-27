<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crud extends MX_Model {
	var $privilege_owner=0;
	var $arr_Result=array();
		
	public function __construct()
    {
        parent::__construct();
		ini_set('max_execution_time', 300); 
	}
	
	public function get_all_data($rows=array(), $search=array(), $param=array(), $dttbl=array(), $forPrint=false)
	{
		ini_set('max_execution_time', 2500);
		// doi::dump($search);
		/* 
		 * Paging
		 */
			
		if ($x=$this->session->userdata('_'.$param['modul'].'_ses_sLimit_')){
			$sLimit =$this->session->userdata('_'.$param['modul'].'_ses_sLimit_');
		}else{ $sLimit = "LIMIT 10";}
		
		if ( isset( $dttbl['iDisplayStart'] ) && $dttbl['iDisplayLength'] != '-1' )
		{
			$sLimit = "LIMIT ".intval( $dttbl['iDisplayStart'] ).", ".intval( $dttbl['iDisplayLength'] );
			$ses_sLimit['_'.$param['modul'].'_ses_sLimit_']=$sLimit;
			$this->session->set_userdata($ses_sLimit);
		}
		
		/*
		 * Ordering
		 */
		$sorts=array();
		if (array_key_exists("sort",$rows)){
			foreach($rows['sort'] as $sort)
			{
				$type='asc';
				if (!empty($sort['type']))
					$type=$sort['type'];
				$sorts[]=$sort['tbl'].'.'.$sort['id'].' '.$type;
			}
		}
		$sort='';
		if (count($sorts)>0){
			$sort=implode(', ',$sorts);
			$sort=' ORDER BY '.$sort;
		}
		
		$sOrder = $sort;
		if (isset($dttbl['iSortCol_0']) AND !empty($dttbl['iSortCol_0']))
		{
			$sOrder = "ORDER BY  ";
			$i=1;
			foreach($rows['title'] as $title){
				if (intval($dttbl['iSortCol_0']) == $i)
				{
					$sOrder .= "".$title[0].'.'.$title[1]." ".($dttbl['sSortDir_0']==='asc' ? 'asc' : 'desc') .", ";
				}
				++$i;
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		$ses_sOrder['_'.$param['modul'].'_ses_sOrder_']=$sOrder;
		$this->session->set_userdata($ses_sOrder);
		
		$sIndexColumn=$rows['primary']['tbl'].'.'.$rows['primary']['id'];
		$fields=array();
		$filter=array();
		
		/*
		cari field apa saya yang akan di ambil dari database data field akan ditampung di variabel $fields
		cari data kondisi jika ada
		*/
		if (array_key_exists("fields",$rows)){
			foreach($rows['fields'] as $key=>$row)
			{
				$label='l_'.$row['field'];
				if (array_key_exists('label',$row)){
					$label= $row['label'];
				}
					
				if (array_key_exists('input',$row)){
					if ($row['input']['type']!=='free'){
						$fields[]= $row['nmtbl'].'.'.$row['field'].' as '.$label;
					}
				}else{
					$fields[]= $row['nmtbl'].'.'.$row['field'].' as '.$label;
				}
				
				if (count($search)>0)
				{
					if (array_key_exists('search',$row))
					{
						if ($row['search'])
						{
							if (array_key_exists('q_'.$row['field'], $search)){
								if ($search['q_'.$row['field']]!=="" && $search['q_'.$row['field']]!=="-"  && $search['q_' . $row['field']]!=="0"){
									switch ($row['input']['type']){
										case 'string':
										case 'text':
											$filter[] = $row['nmtbl'].'.'.$row['field'] . " like '%".$search['q_'.$row['field']]."%'";
											break;
										case 'int':
										case 'integer':
										case 'boolean':
										case 'float':
											$filter[] = $row['nmtbl'].'.'.$row['field'] . " = '".$search['q_'.$row['field']]."'";
											break;
										case 'date':
											$tgl=date('Y-m-d',strtotime($search['q_'.$row['field']]));
											$filter[] = $row['nmtbl'].'.'.$row['field'] . " = '".$tgl."'";
											break;
									}
								}
							}
						}
					}
				}
			}
		}
		
		/*
		cari hubungan antar tabel yang akan ditampilkan 
		*/
		
		$no=1;
		$from="";
		if (array_key_exists("m_tbl",$rows)){
			foreach($rows['m_tbl'] as $key=>$row)
			{
				if (count($rows['m_tbl'])==1 && count($row)<3){
					$from=" ".$row['pk']." ";
					break;
				}else{
					$join = " left join ";
					if (array_key_exists('type', $row))
						$join = " " . $row['type'] . " ";
					
					if ($no==1){
						$from .=" ".$row['pk']. $join .$row['sp'].' on '.$row['pk'].'.'.$row['id_pk'].' = '.$row['sp'].'.'.$row['id_sp']." ";
						++$no;
					}else{
						$from .= $join .$row['sp'].' on '.$row['pk'].'.'.$row['id_pk'].' = '.$row['sp'].'.'.$row['id_sp']." ";
					}
				}
			}
		}
		
		/*
		cari kondisi data yang akan diambil
		*/
		$where='';
		if (array_key_exists("where",$rows)){
			foreach($rows['where'] as $whr)
			{
				$op='=';
				if (!empty($whr['op'])){
					if ($whr['op']=='null'){
						$op=' IS NULL ';
					}elseif ($whr['op']=='not null'){
						$op=' IS NOT NULL ';
					}elseif ($whr['op']=='in'){
						$op=" in (".$whr['value'].")";
					}elseif ($whr['op']=='not in'){
						$op=" not in (".$whr['value'].")";
					}else{
						$op=$whr['op']."'".$whr['value']."'";
					}
				}else{
					$op=" = '".$whr['value']."'";
				}
				$filter[]=$whr['tbl'].'.'.$whr['id'].' '.$op;
			}
		}
		
		if (count($filter)>0)
		{
			$where=implode(" and ",$filter);
			$where = " where (".$where.") ";
		}
		
		$filter=array();
		if (array_key_exists("where_or",$rows)){
			foreach($rows['where_or'] as $whr)
			{
				$op='=';
				if (!empty($whr['op'])){
					if ($whr['op']=='null'){
						$op=' IS NULL ';
					}elseif ($whr['op']=='not null'){
						$op=' IS NOT NULL ';
					}elseif ($whr['op']=='in'){
						$op=" in (".$whr['value'].")";
					}elseif ($whr['op']=='not in'){
						$op=" not in (".$whr['value'].")";
					}else{
						$op=$whr['op']."'".$whr['value']."'";
					}
				}else{
					$op=" = '".$whr['value']."'";
				}
				$filter[]=$whr['tbl'].'.'.$whr['id'].' '.$op;
			}
		}
		
		if (count($filter)>0)
		{
			$wherex=implode(" or ",$filter);
			if (empty($where))
				$where = " where (".$wherex.") ";
			else
				$where .= " OR (".$wherex.") ";
		}
		
		$sWhere = $where;
		if ( isset($dttbl['sSearch']) && $dttbl['sSearch'] != "" )
		{
			if (!empty($sWhere))
				$sWhere .= " and (";
			else
				$sWhere=" where (";
			
			foreach($rows['title'] as $title){
				$con=true;
				foreach($rows['fields'] as $field)
				{
					if ($title[1]==$field['field']){
						if(array_key_exists('input',$field)){
							if ($field['input']['type']=='free'){
								$con=false;
							}
						}
						break;
					}	
				}
				if ($con){
					// $sWhere .= "".$title[0].".".$title[1]." LIKE '%".mysql_real_escape_string( $dttbl['sSearch'] )."%' OR ";
					$sWhere .= "".$title[0].".".$title[1]." LIKE '%".$dttbl['sSearch']."%' OR ";
				}
			}
			
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		$ses_sWhere['_'.$param['modul'].'_ses_sWhere_']=$sWhere;
		$this->session->set_userdata($ses_sWhere);

		$field=implode(', ',$fields);
	
		if($forPrint){
			$sql = $this->session->userdata('_'.$param['modul'].'_ses_sCetak_');
		}else{
			$sql = "select {$field} from {$from} {$sWhere} {$sOrder} {$sLimit} ";
		}
		// die($sql);	
		$sql_nolimit = "select COUNT({$sIndexColumn}) as iFilteredTotal from {$from} {$sWhere} {$sOrder}";
		
		// untuk keperluan mencetak
		if(!$forPrint){
			$ses_sCetak['_'.$param['modul'].'_ses_sCetak_']="select {$field} from {$from} {$sWhere} {$sOrder} ";
			$this->session->set_userdata($ses_sCetak);
		}
		
		if(!$query = $this->db->query($sql))
		{
			$x=$this->db->error(); 
			$this->session->set_flashdata('err_no', $x['code'].' Database');
			$this->session->set_flashdata('err_desc', $x['message']);
			
			$d='error';
			$msg="Gagal memproses data<br>"; 
			$this->session->set_userdata(array('last_url'=>$this->router->fetch_module()));
			$log['message']=$sql;
			$log['priority']=3;
			$log['priority_name']='Info';
			$log['type']='List';
			save_log($log);
			
			header('location:'.base_url('error'));
		}
		// die($sql);	
		$data['fields']=$query->result_array();
		$sess['_'.$param['modul'].'_query_']=$sql;
		$this->session->set_userdata($sess);
			
		$data['sql']=$sql;
		
		/* Data set length after filtering */
		$query = $this->db->query($sql_nolimit);
		$iFiltered = $query->result_array();
		// var_dump($iFiltered);
		$data["iFilteredTotal"] = $iFiltered[0];
		
		/* Total data set length */
		$sql = "SELECT COUNT({$sIndexColumn}) as iTotal FROM  {$from} {$where} ";
		$query = $this->db->query($sql);
		$ttl=$query->result_array();
		$data['iTotal'] = $ttl[0];
		
		return $data;
	}
	
	function get_data($id=0, $rows)
	{
		$fields=array();
		foreach($rows['fields'] as $key=>$row)
		{
			if (array_key_exists('label',$row))
				$label= $row['label'];
			else
				$label='l_'.$row['field'];
			
			if (array_key_exists('input',$row)){
				if ($row['input']['type']!=='free'){
					$fields[]= $row['nmtbl'].'.'.$row['field'].' as '.$label;
				}
			}else{
				$fields[]= $row['nmtbl'].'.'.$row['field'].' as '.$label;
			}
		}
		
		$no=1;
		$from="";
		$tbl="";
		foreach($rows['m_tbl'] as $key=>$row)
		{
			if (array_key_exists('master',$row))
				$tbl=$row['pk'];
				
			if (count($rows['m_tbl'])==1 && count($row)<3){
				$from=" ".$row['pk']." ";
				break;
			}else{
				if ($no==1){
					$from .=" ".$row['pk'].' left join '.$row['sp'].' on '.$row['pk'].'.'.$row['id_pk'].' = '.$row['sp'].'.'.$row['id_sp']." ";
					++$no;
				}else{
					$from .=" left join ".$row['sp'].' on '.$row['pk'].'.'.$row['id_pk'].' = '.$row['sp'].'.'.$row['id_sp']." ";
				}
			}
		}
		
		$field=implode(', ',$fields);
		
		if(array_key_exists('info',$rows['primary'])){
			if($rows['primary']['info']){
				$field .= ', '.$tbl.'.create_date, '.$tbl.'.create_user, '.$tbl.'.update_date, '.$tbl.'.update_user ';
			}
		}
		
		$field_where=$rows['primary']['tbl'].'.'.$rows['primary']['id'];
		if (is_array($id)){
			$id = implode(',', $id);
			$sql="select {$field} from {$from} where {$field_where} in ({$id}) ";
		}else{
			$sql="select {$field} from {$from} where {$field_where}={$id} ";
		}
		$data = $this->db->query($sql);
		if ($data)
		{
			$hasil=$data->result_array();
			
			$d = array();
			$xx=array();
			foreach($hasil as $key=>$dt)
			{
				foreach($rows['fields'] as $key=>$row)
				{
					if (array_key_exists('label',$row)){
						$label= $row['label'];
					}else{
						$label='l_'.$row['field'];
					}
					
					if (array_key_exists('input',$row)){
						if ($row['input']['type']!=='free'){
							if ($row['input']['type']=='date'){
								if (!empty($dt[$label]))
									$xx[$label]=date('d-m-Y',strtotime($dt[$label]));
								else
									$xx[$label]="";
							}elseif ($row['input']['type']=='datetime'){
								if (!empty($dt[$label]))
									$xx[$label]=date('d-m-Y H:s',strtotime($dt[$label]));
								else
									$xx[$label]="";
							}else{
								$xx[$label]=$dt[$label];
							}
						}
					}else{
						$xx[$label]=$dt[$label];
					}
				}
			}
			
			if (count($xx)>0){
				if(array_key_exists('info',$rows['primary'])){
					if($rows['primary']['info']){
						$xx['create_date']=$dt['create_date'];
						$xx['create_user']=$dt['create_user'];
						$xx['update_date']=$dt['update_date'];
						$xx['update_user']=$dt['update_user'];
					}
				}
			}
		
			$d['fields']=$xx;
		}else{	
			$d='error';
			$msg="Gagal memproses data<br>"; 
			$this->session->set_userdata(array('result_proses_error'=>$msg));
			$log['message']=$sql;
			$log['priority']=3;
			$log['priority_name']='Info';
			$log['type']='View/Edit';
			$log['jml']=0;
			save_log($log);
		}
		
		return $d;
	}
	
	function simpan_data($data=array(),$nm_tbl, $old_data=array())
	{
		$id=0;
		$now = new DateTime();
		// $tgl_skr= $now->format('Y-m-d H:i:s');

		$type=$data['data']['sts_simpan'];
		
		foreach($data['fields'] as $key=>$row)
		{
			$isi="";
			if (array_key_exists('label',$row))
				$label= $row['label'];
			else
				$label='l_'.$row['field'];
			
			if (!isset($data['data'][$label]) && $row['input']['input']!=='upload'){
				$save = false;
			}elseif ($row['input']['type']=='free'){
				$save=false;
			}elseif (!$row['save']){
				$save=false;
			}elseif ($row['show'] && !$row['save']){
				$save=false;
			}else{
				$save=true;
			}
			
			if ($save){
				$sts_save=true;						
				if($row['input']['input']=='upload'){
					if (!empty($_FILES[$label]['name'])){
						$upload=upload_image_new(array('nm_file'=>$label, 'path'=>$row['path'], 'thumb'=>$row['file_thumb'], 'type'=>$row['file_type'], 'size'=>$row['file_size'], 'nm_random'=>$row['file_random']));
						if (!$upload){
							$sql['message']=$this->session->userdata('result_proses_error');
							$sql['priority']=1;
							$sql['priority_name']='Gawat';
							$sql['type']=$type;
							save_log($sql);
							return 0;
						}
						
						$isi=$upload['file_name'];
					}else{
						$sts_save=false;
					}
				}else{
					if (array_key_exists($label, $data['data'])){
						if (is_array($data['data'][$label])){
							$isi = implode(',',$data['data'][$label]);
						}
						elseif ($row['input']['type']=='date')
						{
							if (!empty($data['data'][$label]))
								$isi=date('Y-m-d',strtotime($data['data'][$label]));
							else
								$isi=null;
						}elseif ($row['input']['type']=='datetime')
						{
							if (!empty($data['data'][$label]))
								$isi=date('Y-m-d H:s',strtotime($data['data'][$label]));
							else
								$isi=null;
						}elseif ($row['input']['type']=='float')
						{
							$isi=str_replace(',','',$data['data'][$label]);
						}else{
							$isi=$data['data'][$label];
						}
						
						if ($type=="edit"){
							if (array_key_exists('dontupdate', $data)){
								foreach($data['dontupdate'] as $row_edit)
								{
									if ($row['field']==$row_edit['field']){
										$sts_save=false;
										break;
									}
								}
							}
						}else{
							if (array_key_exists('dontinsert', $data)){
								foreach($data['dontinsert'] as $row_edit)
								{
									if ($row['field']==$row_edit['field']){
										$sts_save=false;
										break;
									}
								}
							}
						}
					}
				}
				
				if ($sts_save){
					if($row['field']!=='password'){
						$upd[$row['field']] = $isi;
					}elseif($row['field']=='password' && !empty($isi)){
						$upd[$row['field']] = $isi;
					}
				}
			}
		}
		
		if($type=="edit")
		{
			if (array_key_exists('info',$data['primary'])){
				if ($data['primary']['info']){
					$upd['update_user'] = $this->authentication->get_Info_User('username');
					$upd['update_date'] = Doi::now();
				}
			}
			
			$id=$data['data']["l_id"];
			
			$where[$data['primary']['id']]=$data['data']["l_id"];
			$this->crud->crud_data(array('table'=>$nm_tbl, 'field'=>$upd, 'old_field'=>$old_data, 'where'=>$where,'type'=>'update'));
		}
		else if($type=="add")
		{
			if (array_key_exists('save_cabang',$data)){
				if ($data['save_cabang']){
					$upd['cabang_no'] = _CABANG_NO_;
				}
			}
			
			if (array_key_exists('info',$data['primary'])){
				if ($data['primary']['info']){
					$upd['create_user'] = $this->authentication->get_Info_User('username');
				}
			}
			
			$id=$this->crud->crud_data(array('table'=>$nm_tbl, 'field'=>$upd, 'old_field'=>$old_data,'type'=>'add'));
			
			// echo "Hsil penyimpanan : " . $id ."<br/>";
			// echo $this->db->last_query();
		}
		
		if ($this->db->error()['code']){
			$msg=lang('msg_failed_save')."<br>".$this->db->error()['message']; 
			$this->session->set_userdata(array('result_proses_error'=>$msg));
			$sql['message']=$this->db->last_query();
			$sql['priority']=1;
			$sql['priority_name']='Gawat';
			$sql['type']=$type;
			save_log($sql);
			$id=0;
		}else{
			if ($type=='edit'){
				$msg=lang('msg_success_save_edit');
			}elseif ($type=='add'){
				$msg=lang('msg_success_save_add');
			}else{
				$msg="Unknow type";
			}
			$this->session->set_userdata(array('result_proses'=>$msg));
		}
		return $id;
	}
	
	function crud_data($data=array())
	{
		$type=$data['type'];
		if (!array_key_exists('pesan', $data)){
			$sts_pesan=true;
		}else{
			$sts_pesan=$data['pesan'];
		}
		
		switch ($type){
			case 'add':
				$this->db->insert($data['table'],$data['field']);
				$id=$this->db->insert_id();
				$jml=1;
				break;
			case 'add_batch':
				$this->db->insert_batch($data['table'],$data['field']);
				$id=$this->db->insert_id();
				$jml=count($data['field']);
				break;
			case 'update':
				// doi::dump($data['table']);
				$this->db->update($data['table'], $data['field'], $data['where']);
				$jml=$this->db->affected_rows();
				$id=1;
				break;
			case 'delete':
				if (array_key_exists('where_in', $data))
					$this->db->where_in($data['where_in']['id'], $data['where_in']['value']);
				else
					$this->db->where($data['where']);
				
				$this->db->delete($data['table']);
				$jml=$this->db->affected_rows();
				$id=$jml;
				break;
		}
		
		$this->logdata->_log_data('modul', $this->module_name);
		$this->logdata->_log_data('kel', $type);
		// Doi::dump($this->db->last_query(), false,true);
		
		$sql['message']=$this->db->last_query();
		$sql['type']=$type;
		$sql['old_data']="";
		$sql['new_data']="";
		$sql['jml']=$jml;
		
		if (array_key_exists('old_field', $data)){
			$sql['old_data']=$data['old_field'];
			$this->logdata->_log_data('old_data', $data['old_field']);
		}
		if (array_key_exists('field', $data)){
			$sql['new_data']=$data['field'];
			$this->logdata->_log_data('new_data', $data['field']);
		}
		
		if ($this->db->error()['code']){
			$msg=lang('msg_failed_save')."<br>".$this->db->error()['message']; 
			$this->session->set_userdata(array('result_proses_error'=>$msg));
			$id=0;
		}else{
			$msg="";
			if ($sts_pesan){
				if ($type=='update'){
					$msg=lang('msg_success_save_edit');
				}elseif ($type=='add'){
					$msg=lang('msg_success_save_add');
				}elseif ($type=='delete'){
					$msg=lang('msg_success_save_edit');
				}else{
					$msg="Unknow type";
				}
				$this->session->set_userdata(array('result_proses'=>$msg));
			}
			
			if (intval($this->authentication->get_Preference('status_log'))==1){
				$sql['priority']=1;
				$sql['priority_name']='Info';
				// save_log($sql);
			}
			
		}
		return $id;
	}
	
	function delete_data($data, $id){
		$this->db->where_in($data['id'], $id);
		$this->db->delete($data['tbl']);
		$jml=$this->db->affected_rows();
		$sql['message']=$this->db->last_query();
		if ($jml>0){
			$this->session->set_userdata('result_proses', $jml.' record berhasil dihapus');
			$sql['priority_name']='Info';
			$sql['priority']=3;
			$sql['type']='Delete';
			$sql['jml']=$jml;
			save_log($sql);
			$result=true;
		}else{
			$this->session->set_userdata('result_proses_error', 'Gagal menghapus record');
			$sql['priority']=1;
			$sql['priority_name']='Gawat';
			$sql['type']='Fail Delete';
			$sql['jml']=0;
			save_log($sql);
			$result=false;
		}
		return $result;
	}
	
	
	// // ===============================
	// // Untuk mencarai data Map Risk
	// // ===============================
	
	public function get_setting($param=array())
	{
		// Doi::dump($param);
		// die();
		
		if($this->id_param_owner){
			$this->privilege_owner = $this->id_param_owner['privilege_owner']['id'];
		}
		
		$this->owner_child=array();
		
		if (array_key_exists('rcsa_no', $param)){
			$this->owner_child[]=$param['rcsa_no'];
		}
		
		if (array_key_exists('type_map', $param)){
			if ($param['type_map']==2 && $this->privilege_owner<=2 && !empty($param['rcsa_no'])){
				$this->get_owner_child($param['rcsa_no']);
			}
		}
		$param['owner_child']=$this->owner_child;
		$this->db->select('*');
		$this->db->from(_TBL_LEVEL);
		$this->db->where('category','likelihood');
		$this->db->order_by('urut','desc');
		
		$query=$this->db->get();
		$likelihoods=$query->result_array();
		
		$result=array();
		$type_map='residual';
		foreach($likelihoods as $likelihood){
			$result[]=array('code'=>$likelihood['code'],'isi'=>$this->get_color($likelihood['id'], $param, $type_map));
		}
		
		// die(json_encode($param));
		$hasil['tbl'][$type_map]['jml']=$result;
		$hasil['tbl'][$type_map]['param']=json_encode($param);
		
		$result=array();
		$type_map='inherent';
		foreach($likelihoods as $likelihood){
			$result[]=array('code'=>$likelihood['code'],'isi'=>$this->get_color($likelihood['id'], $param, $type_map));
		}
		$hasil['tbl'][$type_map]['jml']=$result;
		$hasil['tbl'][$type_map]['param']=json_encode($param);
		
		$arr_rekap=array();
		$title="";
		$jml=0;
		$first=true;
		foreach($this->arr_Result as $row){
			if ($title !== $row['title']){
				if (!$first){
					$arr_rekap[$type][]=array('id'=>$id,'title'=>$title,'jml'=>$jml,'type'=>$type);
				}
				$first = false;
				$title = $row['title'];
				$type = $row['type'];
				$jml = intval($row['jml']);
				$id = $row['id'];
			}else{
				$jml += intval($row['jml']);
			}
		}
		
		if ($arr_rekap){
			$arr_rekap[$type][]=array('id'=>$id,'title'=>$title,'jml'=>$jml,'type'=>$type);
		}
		
		$hasil['rekap']=$arr_rekap;
		
		$this->db->select(_TBL_RCSA.'.*,'._TBL_PERIOD.'.periode_name,'._TBL_OWNER.'.name,'. _TBL_OWNER.'.phone,'. _TBL_OWNER.'.mobile,'. _TBL_OWNER.'.email,' ._TBL_OWNER.'.fax');
		
		$this->db->from(_TBL_RCSA);
		$this->db->join(_TBL_PERIOD, _TBL_RCSA.'.period_no='._TBL_PERIOD.'.id');
		$this->db->join(_TBL_OWNER, _TBL_RCSA.'.owner_no='._TBL_OWNER.'.id');
		
		// $id_param=explode(',',$this->authentication->get_info_user('id_param_level'));
		// $sts_param = $this->authentication->get_info_user('sts_param');
		
		if (array_key_exists('type_map', $param)){
			if (($param['type_map']==2 || $param['type_map']==4) && $this->privilege_owner<=2 && !empty($param['rcsa_no'])){
				$this->db->where_in(_TBL_OWNER.'.id',$this->owner_child);
			}
		}
		
		if (array_key_exists('type_dash', $param)){
			if (intval($param['type_dash'])<3)
				$this->db->where(_TBL_RCSA.'.type',$param['type_dash']);
		}
		
		$this->db->where(_TBL_RCSA.'.status',1);
		
		if (array_key_exists('project_no', $param)){
			if (intval($param['project_no'])>=0){
				$this->db->where(_TBL_RCSA.'.id',$param['project_no']);
			}
		}
		
		if (array_key_exists('periode_no', $param)){
			if (intval($param['periode_no'])>0){
				$this->db->where(_TBL_RCSA.'.period_no',$param['periode_no']);
			}
		}
		
		// Doi::dump($param, false,true);
		$query=$this->db->get();
		$rcsa=$query->result_array();
		$hasil['rcsa']=$rcsa;
	
		$this->db->select('*');
		$this->db->from(_TBL_OFFICER);
		// Doi::dump($param);
		// die();
		if (array_key_exists('rcsa_no', $param)){
			// $this->db->where_in('owner_no',$this->owner_child);
			$this->db->where_in('owner_no',$param['rcsa_no']);
		}
		$query=$this->db->get();
		$rcsa=$query->result_array();
		$hasil['office']=$rcsa;
		// Doi::dump($hasil);die();
		return $hasil;
	}
	
	function get_color($likelihood, $param=array(), $type_map='residual'){
		$this->db->select('*');
		$this->db->from(_TBL_LEVEL);
		$this->db->where('category','impact');
		$this->db->order_by('urut','asc');
		
		$query=$this->db->get();
		$impacts=$query->result_array();
		
		$result=array();
		foreach($impacts as $key=>$impact){
			$this->db->select(_TBL_LEVEL_MAPPING.'.color,'._TBL_LEVEL_MAPPING.'.color_text,'._TBL_LEVEL_MAPPING.'.level_mapping,'._TBL_LEVEL_COLOR.'.id');
			$this->db->from(_TBL_LEVEL_COLOR);
			$this->db->join(_TBL_LEVEL_MAPPING,_TBL_LEVEL_MAPPING.'.id='._TBL_LEVEL_COLOR.'.level_risk_no');
			$this->db->where('impact',$impact['id']);
			$this->db->where('likelihood',$likelihood);
			
			$query=$this->db->get();
			$colors=$query->result_array();
			foreach ($colors as $color){
				$detail_tmp=$this->cari_jml_color($impact['id'], $likelihood, $param, $type_map, $color['id']);
				if ($detail_tmp['jml']>0){ 
					$this->arr_Result[]=array('id'=>$color['id'],'title'=>$color['level_mapping'],'jml'=>$detail_tmp['jml'],'type'=>$type_map);
					$jml=$detail_tmp['jml'];
				}else{$jml="";}
				$result[]=array('id_detail'=>$detail_tmp['id'],'jml'=>$jml,'code'=>$impact['code'],'id'=>$color['id'],'title'=>$color['level_mapping'],'color'=>$color['color'],'color_text'=>$color['color_text']);
			}
		}
		return $result;
	}
	
	function cari_jml_color($impact, $likelihood, $param=array(), $type_map, $id){
		
		$this->db->select(_TBL_RCSA_DETAIL.'.*');
		$this->db->from(_TBL_RCSA_DETAIL);
		$this->db->join(_TBL_RCSA,_TBL_RCSA.'.id='._TBL_RCSA_DETAIL.'.rcsa_no');
		if (array_key_exists('type_map', $param)){
			if (($param['type_map']==2 || $param['type_map']==4) && $this->privilege_owner<=2 && !empty($param['rcsa_no'])){
				$this->db->where_in(_TBL_RCSA.'.owner_no',$this->owner_child);
			}
		}
		
		if (array_key_exists('type_dash', $param)){
			if (intval($param['type_dash'])<3)
				$this->db->where(_TBL_RCSA.'.type',$param['type_dash']);
		}
		
		if (array_key_exists('project_no', $param)){
			if (intval($param['project_no'])>=0){
				$this->db->where(_TBL_RCSA.'.id',$param['project_no']);
			}
		}
		
		if (array_key_exists('periode_no', $param)){
			if (intval($param['periode_no'])>0){
				$this->db->where(_TBL_RCSA.'.period_no',$param['periode_no']);
			}
		}
		
		$this->db->where(_TBL_RCSA.'.status',1);
		
		if ($type_map=='residual')
			$this->db->where('risk_level',$id);
		else
			$this->db->where('inherent_level',$id);
		
		$query=$this->db->get();
		$result['jml']=$query->num_rows();
		$id_detail=array();
		foreach($query->result_array() as $row){
			$id_detail[]=$row['event_no'];
		}
		$result['id']="";
		if ($result['jml']>0){
			$result['id']=implode(',',$id_detail);
		}
		// doi::dump($this->db->last_query(),false, true);
		return $result;
	}
	
	function get_param($data){
		$this->db->select('*');
		if ($data=='owner'){
			$this->db->from(_TBL_OWNER);
			$id_param=explode(',',$this->authentication->get_info_user('id_param_level'));
			$sts_param = $this->authentication->get_info_user('sts_param');
			if ($sts_param =="0")
				$this->db->where_in(_TBL_OWNER.'.id',$id_param);
		}else{
			$this->db->from(_TBL_PERIOD);
		}
		$this->db->where('status',1);
		
		$query=$this->db->get();
		$result=$query->result();
		return $result;
	}
	
	function cek_double_data_library($kode, $kel=1){
		$this->db->select('*');
		$this->db->from(_TBL_LIBRARY);
		$this->db->where('code',$kode);
		$this->db->where('type',$kel);
		
		$query=$this->db->get();
		$result=$query->result_array();
		die($this->db->last_query());
		$hasil=true;
		if (count($result)>0){
			$msg ="Gagal memproses data, Kode Library ".$kode." sudah terpakai"; 
			$this->session->set_userdata(array('result_proses_error'=>$msg));				
			$hasil=false;
		}
		return $hasil;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */