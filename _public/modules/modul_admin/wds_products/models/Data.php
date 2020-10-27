<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {
	public function __construct()
	{
		parent::__construct();
	}

	function update_data($data, $old_data){
		$id = (int)$this->uri->segment(3);
		$upd = [];
		foreach($data['fields'] as $key=>$row)
		{
			if ($row['show']){
				if ($row['save']){
					if ($data['data']['l_'.$row['field']] !== $old_data['l_'.$row['field']]){
						if($row['input']['type'] == "float"){
							$upd[$row['field']] = (int)str_replace(',', '', $data['data']['l_'.$row['field']]);
						}
						else{
							$upd[$row['field']] = $data['data']['l_'.$row['field']];
						}
					}
				}
			}
		}
		if(count($upd)!= 0) {
			$arr['update_user'] = $this->authentication->get_Info_User('username');
			$this->db->where('id', $id)->update(_TBL_PRODUK, $upd);	
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
					$this->crud->crud_data(array('table'=>_TBL_PRODUK, 'field'=>array('product_logo'=>$latar), 'where'=>array('id'=>$id),'type'=>'update'));
				}
			}
		}
		$this->session->set_userdata(array('result_proses'=>lang('msg_success_save_edit')));
		return true;
	}

	function insert_data($data) {

		$dt = $data['fields'];
		$arr = [];
		foreach ($dt as $row) {
			$type = $row['input']['type'];

			if($row['save']) { 
				if($type == "int" || $type == "float") {
					$arr[$row['field']] = (int)str_replace(',', '', $data['data']['l_'.$row['field']]);
				} else {
					$arr[$row['field']] = $data['data']['l_'.$row['field']];
				}
			}

		}
		$arr['create_user'] = $this->authentication->get_Info_User('username');
		if ($this->db->insert(_TBL_PRODUK, $arr)) {
			
			$files = $_FILES;
			$post = $this->input->post();
			if ($files){
				$cpt = count($_FILES['latar_img']['name']);
				if ($cpt>0){
					$hasil=array();
					for($i=0; $i<$cpt; $i++)
					{
						if (!empty($_FILES['latar_img']['name'][$i])){
							$nmFile = $files['latar_img']['name'][$i];
							$_FILES['userfile']['name']= $files['latar_img']['name'][$i];
							$_FILES['userfile']['type']= $files['latar_img']['type'][$i];
							$_FILES['userfile']['tmp_name']= $files['latar_img']['tmp_name'][$i];
							$_FILES['userfile']['error']= $files['latar_img']['error'][$i];
							$_FILES['userfile']['size']= $files['latar_img']['size'][$i]; 
							// Doi::dump($_FILES['userfile']);
							$upload=upload_image_new(array('nm_file'=>'userfile', 'size'=>10000000, 'path'=>'slide','thumb'=>true, 'type'=>'*'), TRUE, $i);
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

						$return = $this->crud->crud_data(array('table'=>_TBL_PRODUK, 'field'=>array('product_logo'=>$latar), 'where'=>array('id'=>$this->db->insert_id()),'type'=>'update'));
					}
				}
			}
			$this->session->set_userdata(array('result_proses'=>lang('msg_success_save_edit')));
			return true;
		} else {
			return false;
		}
		
	}

}
