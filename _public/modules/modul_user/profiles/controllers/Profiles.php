<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profiles extends FrontendController {
	public function __construct()
	{
    	parent::__construct();
	}

	public function index()
	{
		$this->template->build('index');
	}

	public function save() {
		$post = $this->input->post();
		$user = $this->authentication->get_Info_User();
		$id = (int)$user['id'];
		$save = $this->db->where('id', $id)->update(_TBL_USERS, $post);
		if ($save) {
			$user['nama_lengkap'] = $post['nama_lengkap'];
			$user['hp'] = $post['hp'];
			$user['gender'] = $post['gender'];
			$user['tgl_lahir'] = $post['tgl_lahir'];
			$this->authentication->set_Info_User($user);
		}
		if ($_FILES["file"]["error"] == 0){
			$nmFile = $_FILES['file']['name'];
			$_FILES['userfile']['name']= $_FILES['file']['name'];
			$_FILES['userfile']['type']= $_FILES['file']['type'];
			$_FILES['userfile']['tmp_name']= $_FILES['file']['tmp_name'];
			$_FILES['userfile']['error']= $_FILES['file']['error'];
			$_FILES['userfile']['size']= $_FILES['file']['size']; 
			$upload=upload_image_new([
				'nm_file'=>'userfile', 
				'size'=>10000000, 
				'path'=>'staft',
				'thumb'=>true, 
				'type'=>'*'
			], TRUE);

			$photo = ['photo'=>$upload['file_name']];
			$this->db->where('id', $id)->update(_TBL_USERS, $photo);
			$user['photo'] = $upload['file_name'];
			$this->authentication->set_Info_User($user);
		}
		header('location:'.base_url('profiles'));
	}
}
