<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends BackendController {

	 
	public function __construct()
	{
        parent::__construct();
    }
	
	public function index()
	{
		if (!$this->authentication->is_loggedin())
		{
			$data['google_login_url']=$this->google->get_login_url();
			$this->template->set_layout('login');
			$data['latar']=json_decode($this->_Preference_['gambar_background'], true);
			$this->template->build('auth', $data); 
		}else{
			header('location:'.base_url().'home');
		}
	}
	
	public function login()
	{
			
		if (!$this->authentication->is_loggedin())
		{
			$x=$this->input->post();
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$hasil=$this->form_validation->run();
			// Doi::dump($data);die();
			if ($hasil == FALSE)
			{
				header('location:'.base_url().'auth');
				$this->template->set_layout('login');
				$this->template->build('auth', $data); 
			}
			else
			{
				if ($this->authentication->login($this->input->post('username'), $this->input->post('password'))){
					$default_modul=$this->authentication->get_Info_User('default_modul');
					$x=$this->session->userdata('user_info');
					if (empty($default_modul)){
						// header('location:'.base_url('home'));
						header('location:'.$this->agent->referrer());
					}else{
						// header('location:'.base_url('home'));
						header('location:'.$this->agent->referrer());
					}
				} else {
					header('location:'.base_url('auth'));
				}
			}
		}else{
			header('location:'.base_url('auth'));
		}
	}
	
	public function logout()
	{
		$redirect_to = isset($_GET["redirect_to"])?$_GET["redirect_to"]:uri_string();
		if(!empty($redirect_to)){
			$redirect_to = urldecode($redirect_to);
		}else{
			$redirect_to = 'home';
		}
		
		
		$this->logdata->_save_log_data();
		if ($this->authentication->logout($redirect_to))
		{
			header('location:'.base_url());
		}
	}
	
	public function language()
	{
		$redirect_to = isset($_GET["redirect_to"])?$_GET["redirect_to"]:"";
		if(!empty($redirect_to)){
			$redirect_to = urldecode($redirect_to);
		}else{
			$redirect_to = base_url();
		}
	
		$bahasa=$this->_Snippets_['uri'][2];;
		$this->session->set_userdata(array('bahasa' => $bahasa));
		
		header('location:'.$redirect_to);
	}
	
	public function faq()
	{
		$this->template->set_layout('login');
		$this->template->build('auth_faq'); 
	}
	
	public function daftar()
	{

		if (!$this->authentication->is_loggedin())
		{

			$user=$this->input->post('username');
			if (!empty($user))
			{
				if ($this->authentication->create_buyer($this->input->post()) )
				{
					header('location:'.base_url('home'));
				}else{
					$this->template->set_layout('login');
					$this->template->build('auth_daftar'); 
				}
			}else{
				$this->template->set_layout('login');
				$this->template->build('auth_daftar'); 
			}
		}else{
			header('location:'.base_url('home'));
		}
	}

	public function forget()
	{
		$email='ugd24jam@gmail.com';
		$data['email']=$email;
		$data['subject']="Send Email";
		$data['content']= "test";
		$result=Doi::kirim_email($data);
		doi::dump($result);
	}

	public function google_authentication() {

		

		if (!$this->authentication->is_loggedin()) {
			$user = $this->google->validate();
			$username = str_replace(' ', '', strtolower($user['name']));
			if (!$this->authentication->username_check($username)) {
				$this->authentication->login($username, $user['id']);
				header('location:'.base_url('home'));
			} else {
				$this->authentication->create_buyer_with_google_account($user);
				header('location:'.base_url('home'));
			}
		} else {
				header('location:'.base_url('home'));
		}



	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */