<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Google_Login extends FrontendController {

	 
	public function __construct()
	{
        parent::__construct();
    }
	
	public function index() {
		$data['google_login_url']=$this->google->get_login_url();
		$this->load->view('home_view',$data);
	}

	public function oauth2(){
		$google_data=$this->google->validate();
		$user=$this->data->GetAllInfo($google_data);
		if(count($user)>0){
			$session_data=array(
				'name'=>$google_data['name'],
				'email'=>$google_data['email'],
				'source'=>'google',
				'profile_pic'=>$google_data['profile_pic'],
				'link'=>$google_data['link'],
				'sess_logged_in'=>1
				);
			$this->session->set_userdata($session_data);
			
		}else{
			
			$session_data=array(
				'name'=>$google_data['name'],
				'email'=>$google_data['email'],
				'source'=>'google',
				'profile_pic'=>$google_data['profile_pic'],
				'link'=>$google_data['link'],
				'sess_logged_in'=>1
				);
			$this->session->set_userdata($session_data);
		}
		redirect(base_url('google-login'));
	}

	public function logout(){
		session_destroy();
		unset($_SESSION['access_token']);
		$session_data=array(
				'sess_logged_in'=>0
				);
		$this->session->set_userdata($session_data);
		redirect(base_url());
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */