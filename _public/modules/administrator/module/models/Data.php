<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	public function __construct()
    {
        parent::__construct();
	}
	
	function get_data_posisi_menu(){
		
		$this->db->select('*');
		$this->db->from(_TBL_MODUL);
		$this->db->order_by('urut');
		$query=$this->db->get();
		$rows=$query->result_array();
		foreach($rows as $row){
			$input[] = array("id" => $row['id'], "title" => $row['title'], "slug" => $row['pid'], "nm_modul" => $row['nm_modul'], "pid" => $row['pid'], "icon" => $row['icon'], "posisi" => $row['posisi'], "urut" => $row['urut'], "aktif" => $row['aktif']);
		}
		
		$result = _tree($input);
		return $result;
	}
	
	function simpan_data($data){
		$output_data = stripslashes($data['nestable-output']);
		$rows = json_decode($output_data);
		$type='update';
		$n = 0;
		foreach($rows as $row) { 
			$n++; 
			$n1 = 0;
			$update_id = $row->id;
			$upd['pid']=0;
			$upd['urut']=$n;
			$where['id']=$row->id;
			// Doi::dump($upd);
			$result=$this->crud->crud_data(array('table'=>_TBL_MODUL, 'field'=>$upd,'where'=>$where,'type'=>$type));
			if(!empty($row->children)){
			foreach ($row->children as $vchild){ 
				$n1++; 
				$n2 = 0;
				$upd['pid']=$row->id;
				$upd['urut']=$n1;
				$where['id']=$vchild->id;
				// Doi::dump($upd);
				$result=$this->crud->crud_data(array('table'=>_TBL_MODUL, 'field'=>$upd,'where'=>$where,'type'=>$type));
				if(!empty($vchild->children)){
				foreach ($vchild->children as $vchild1){ 
					$n2++; 
					$n3 = 0;
					$upd['pid']=$vchild->id;
					$upd['urut']=$n2;
					$where['id']=$vchild1->id;
					// Doi::dump($upd);
					$result=$this->crud->crud_data(array('table'=>_TBL_MODUL, 'field'=>$upd,'where'=>$where,'type'=>$type));
					if(!empty($vchild1->children)){
					foreach ($vchild1->children as $vchild2){ 
						$n3++; 
						$n4 = 0;
						$upd['pid']=$vchild1->id;
						$upd['urut']=$n3;
						$where['id']=$vchild2->id;
						// Doi::dump($upd);
						$result=$this->crud->crud_data(array('table'=>_TBL_MODUL, 'field'=>$upd,'where'=>$where,'type'=>$type));
						if(!empty($vchild2->children)){
						foreach ($vchild2->children as $vchild3){ 
							$n4++;
							$n5=0;
							$upd['pid']=$vchild2->id;
							$upd['urut']=$n4;
							$where['id']=$vchild3->id;
							// Doi::dump($upd);
							$result=$this->crud->crud_data(array('table'=>_TBL_MODUL, 'field'=>$upd,'where'=>$where,'type'=>$type));
							if(!empty($vchild3->children)){
							foreach ($vchild3->children as $vchild4){ 
								$n5++;
								$n6=0;
								$upd['pid']=$vchild3->id;
								$upd['urut']=$n5;
								$where['id']=$vchild4->id;
								// Doi::dump($upd);
								$result=$this->crud->crud_data(array('table'=>_TBL_MODUL, 'field'=>$upd,'where'=>$where,'type'=>$type));
							}
							}
						}
						}
					}
					}
				}
				}
			}
			}
		}
		
		foreach($data['id_edit'] as $key=>$row){
			$upd=array();
			$upd['title']=$data['title'][$key];
			$upd['nm_modul']=$data['nm_modul'][$key];
			$upd['icon']=$data['icon'][$key];
			$upd['posisi']=$data['posisi'][$key];
			$upd['aktif']=$data['aktif'][$key];
			$where['id']=$row;
			$result=$this->crud->crud_data(array('table'=>_TBL_MODUL, 'field'=>$upd,'where'=>$where,'type'=>$type));
		}
		
		$this->authentication->set_Menu_Navigator();
		
		return TRUE ;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */