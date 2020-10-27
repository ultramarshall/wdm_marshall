<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	
	public function __construct()
    {
        parent::__construct();
	}
	
	function get_modul($id=0)
	{
		$this->db->select('*');
		$this->db->from(_TBL_MODUL);
		$this->db->where('aktif',1);
		$this->db->where('pid',0);
		$this->db->order_by('urut');
		
		$query=$this->db->get();
		$x=$query->result();
		$menu=array();
		foreach($x as $row)
		{	
			$idgroup=$row->id;
			$sub_menu=$this->get_data_submenu1($id, $idgroup);
			$menu[]=array('label'=>$row->title,'id'=>$row->id,'link'=>$row->nm_modul,'submenu'=>$sub_menu,'posisi'=>$row->posisi,'sts'=>$this->cari_privilage($row->id,$id));
		}
		$result['field']=$menu;
		
		return $result;
	}
	
	public function get_data_submenu1($id=0, $idgroup=0)
	{
		$this->db->select('*');
		$this->db->from(_TBL_MODUL);
		$this->db->where('aktif',1);
		$this->db->where('pid',$idgroup);
		$this->db->where('title <>','');
		$this->db->order_by('urut');
		
		$query=$this->db->get();
		$menu1=array();
		foreach($query->result() as $row)
		{
			$idnya=$row->id;
			$sub_menu=$this->get_data_submenu2($idnya, $id);
			$menu1[]=array('label'=>$row->title,'id'=>$row->id,'link'=>$row->nm_modul,'submenu'=>$sub_menu,'posisi'=>$row->posisi,'sts'=>$this->cari_privilage($row->id,$id));
		}
		return $menu1;
	}
	
	public function get_data_submenu2($id, $idgroup)
	{
		$this->db->select('*');
		$this->db->from(_TBL_MODUL);
		$this->db->where('aktif',1);
		$this->db->where('pid',$id);
		$this->db->where('title <>','');
		$this->db->order_by('urut');
		
		$query=$this->db->get();
		$menu1=array();
		foreach($query->result() as $row)
		{
			$idnya=$row->id;
			$menu1[]=array('label'=>$row->title,'id'=>$row->id,'link'=>$row->nm_modul,'submenu'=>'','posisi'=>$row->posisi,'sts'=>$this->cari_privilage($row->id,$idgroup));
		}
		return $menu1;
	}
	
	function cari_privilage( $id, $idgroup)
	{
		$result=array('id'=>0,'read'=>0,'add'=>0,'edit'=>0,'delete'=>0,'print'=>0,'send'=>0);
		if ($idgroup>0){
			$this->db->select('*');
			$this->db->from(_TBL_GROUP_PRIVILEGE);
			$this->db->where('group_no',$idgroup);
			$this->db->where('menu_no',$id);
			
			$query=$this->db->get();
			foreach($query->result() as $row)
			{
				$result=array('id'=>$row->id,'read'=>$row->read,'add'=>$row->add,'edit'=>$row->edit,'delete'=>$row->delete,'print'=>$row->print,'send'=>$row->send);
			}
		}
		return $result;
	}
	
	function save_privilege($newid=0,$data=array(), $old_data=array())
	{
		foreach($data['id_menu'] as $key=>$row)
		{
			$upd['group_no'] = $newid;
			$upd['menu_no'] = $row;
			$upd['read'] = $data['read_'.$key];
			$upd['add'] = $data['add_'.$key];
			$upd['edit'] = $data['edit_'.$key];
			$upd['delete'] = $data['delete_'.$key];
			$upd['print'] = $data['print_'.$key];			
		
			if(intval($data['id_edit_group'][$key])>0)
			{
				$upd['update_date'] = Doi::now();
				$upd['update_user'] = $this->authentication->get_Info_User('username');
				$where['id']=$data['id_edit_group'][$key];
				$this->crud->crud_data(array('table'=>_TBL_GROUP_PRIVILEGE, 'field'=>$upd, 'where'=>$where,'type'=>'update'));
			}
			else
			{
				$upd['create_user'] = $this->authentication->get_Info_User('username');
				$this->crud->crud_data(array('table'=>_TBL_GROUP_PRIVILEGE, 'field'=>$upd, 'where'=>$where,'type'=>'add'));
			}
		}
		return true;
	}
	
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */