<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	
	public function __construct()
    {
        parent::__construct();
		
	}
	
	function get_data(){
		$this->db->select('*');
		$this->db->from(_TBL_PREFERENCE);
		$query=$this->db->get();
		$result=array();
		if($query){
			$rows=$query->result();
			$data=array('l_id'=>0);
			foreach($rows as $key=>$row){
				$data['l_'.$row->uri_title]=$row->value;
			}
			$result['fields']=$data;
		}
		return $result;
	}
	
	function save_data($data, $old_data){
		// Doi::dump($old_data,false,true);
		// doi::dump($data['data'], false, true);
		// doi::dump($old_data, false, true);
		foreach($data['fields'] as $key=>$row)
		{
			// doi::dump($data, false, true);
			if ($row['show']){
				// echo $data['data']['l_'.$row['field']] . '!==' . $old_data['l_'.$row['field']] . "<br/>";
				if ($row['save']){
					if ($data['data']['l_'.$row['field']] !== $old_data['l_'.$row['field']]){
						$old_upd['value'] = $old_data['l_'.$row['field']];
						$upd['value'] = $data['data']['l_'.$row['field']];
						$where['uri_title'] = $row['field'];
						$this->crud->crud_data(array('table'=>_TBL_PREFERENCE, 'field'=>$upd, 'old_field'=>$old_upd, 'where'=>$where,'type'=>'update'));
						$upd=array();
					}
				}
			}
		}
		
		$files = $_FILES;
		$post = $this->input->post();
		if ($files){
			$cpt = count($_FILES['latar_img']['name']);
			if ($cpt>0){
				$hasil=array();
				for($i=0; $i<$cpt; $i++)
				{
					$upd=array();
					if (!empty($_FILES['latar_img']['name'][$i])){
						$nmFile = $files['latar_img']['name'][$i];
						$_FILES['userfile']['name']= $files['latar_img']['name'][$i];
						$_FILES['userfile']['type']= $files['latar_img']['type'][$i];
						$_FILES['userfile']['tmp_name']= $files['latar_img']['tmp_name'][$i];
						$_FILES['userfile']['error']= $files['latar_img']['error'][$i];
						$_FILES['userfile']['size']= $files['latar_img']['size'][$i]; 
						// Doi::dump($_FILES['userfile']);
						$upload=upload_image_new(array('nm_file'=>'userfile', 'size'=>10000000, 'path'=>'slide','thumb'=>true, 'type'=>'*'), TRUE, $i);
						// Doi::dump($upload);
						if($upload){
							
							$upd['nama']=$upload['file_name'];
							$upd['judul']=$nmFile;
							$upd['size']=$upload['file_size'];
							$upd['aktif']=$post['aktif'][$i];
						}
					}elseif(!empty($post['judul'][$i])){
						$upd['nama']=$post['nama'][$i];
						$upd['judul']=$post['judul'][$i];
						$upd['size']=$post['size'][$i];
						$upd['aktif']=$post['aktif'][$i];
					}
					$hasil[]=$upd;
				}
				if ($hasil){
					$latar=json_encode($hasil);
					$this->crud->crud_data(array('table'=>_TBL_PREFERENCE, 'field'=>array('value'=>$latar), 'where'=>array('uri_title'=>'gambar_background'),'type'=>'update'));
				}
			}
		}
		// die();
		$this->session->set_userdata(array('result_proses'=>lang('msg_success_save_edit')));
		$this->authentication->set_Preference();
		return true;
	}
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */