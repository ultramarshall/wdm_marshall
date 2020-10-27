<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	public function __construct()
    {
        parent::__construct();
	}
	
	function get_data_place($id, $array=false){
		$rows=array();
		if ($id==1){
			$rows=$this->db->select('id, propinsi as nama')->where('aktif', 'Y')->order_by('propinsi')->get(_TBL_PROPINSI)->result_array();
		}elseif ($id==2){
			$rows=$this->db->select('id, concat(propinsi, " - " , kota) as nama')->where('aktif', 'Y')->order_by('propinsi')->get(_TBL_VIEW_KOTA)->result_array();
		}elseif ($id==3){
			$rows=$this->db->select('id, concat(propinsi, " - " , kota, " - " , distrik) as nama')->where('aktif', 'Y')->get(_TBL_VIEW_DISTRIK)->result_array();
		}elseif ($id==4){
			$rows=$this->db->select('id, concat(propinsi, " - " , kota, " - " , distrik, " - " , puskesmas) as nama')->where('aktif', 'Y')->get(_TBL_VIEW_PUSKESMAS)->result_array();
		}elseif ($id==5){
			$rows=$this->db->select('id, concat(propinsi, " - " , rumahsakit) as nama')->where('aktif', 'Y')->get(_TBL_VIEW_RUMAHSAKIT)->result_array();
		}elseif ($id==6){
			$rows=$this->db->select('id, concat(propinsi, " - " , kota, " - " , nama_lab) as nama')->where('aktif', 'Y')->get(_TBL_VIEW_LAB)->result_array();
		}elseif ($id==7){
			$rows=$this->db->select('id, concat(propinsi, " - " , pheoc) as nama')->where('aktif', 'Y')->get(_TBL_VIEW_PHEOC)->result_array();
		}
		
		if ($array){
			$option = array('0'=>' - Pilih - ');
			foreach($rows as $row){
				$option[$row['id']]= $row['nama'];
			}
		}else{
			$option = '<option value="0"> - Pilih - </option>';
			foreach($rows as $row){
				$option .= '<option value="'.$row['id'].'">'.$row['nama'].'</option>';
			}
		}
		return $option;
	}
	
	function get_group($iduser=0){
		$this->db->select('*');
		$this->db->from(_TBL_GROUP_USER);
		$this->db->where('user_no',$iduser);
		
		$query=$this->db->get();
		$result['field']=$query->result_array();
		return $result;
	}
	
	function get_img_file_name($id){
		$query = $this->db->select('*')
				->where('id',$id)
				->get(_TBL_USERS);
		$rows = $query->result();
		$nm='';
		foreach($rows as $row){
			$nm=$row->photo;
		}
		return $nm;
	}
	
	function save_group($newid=0,$data=array(), $img)
	{
		// doi::dump($data,false,true);
		$now = new DateTime();
		$tgl= $now->format('Y-m-d H:i:s');
		$result=1;
		if (! empty($img['file_name'])){
			$upi['photo']=$img['file_name'];
			$this->db->where('id',$newid);
			$this->db->update(_TBL_USERS,$upi);
		}
		
		if (isset($data['id_edit'])){
			if(count($data['id_edit'])>0){
				foreach($data['id_edit'] as $key=>$row)
				{
					$upd['group_no'] = $data['groups_id'][$key];;
					$upd['user_no'] = $newid;
					
					if(intval($data['id_edit'][$key])>0)
					{
						$upd['update_date'] = $tgl;
						$upd['update_user'] = $this->authentication->get_Info_User('username');
						$result=$this->crud->crud_data(array('table'=>_TBL_GROUP_USER, 'field'=>$upd,'where'=>array('id'=>$data['id_edit'][$key]),'type'=>'update'));
					}
					else
					{
						$upd['create_user'] = $this->authentication->get_Info_User('username');
						$result=$this->crud->crud_data(array('table'=>_TBL_GROUP_USER, 'field'=>$upd,'type'=>'add'));
					}
				}
			}
		}
		return $result;
	}
			
	function delete_data($id){
		$this->db->where('id', $id);
		$this->db->delete(_TBL_GROUP_USER);
		$jml=$this->db->affected_rows();
		// die($this->db->last_query());
		$hasil['sts']=0;
		$hasil['ket']='Gagal Mengahapus';
			
		if ($jml>0){
			$hasil['sts']=$jml;
			$hasil['ket']='data berhasil dihapus';
		}
		return $hasil;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */