<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Doi
{	
	private $_ci;
	private $preference=array();
	
	function __construct()
	{
		$this->_ci =& get_instance();

		if ($x=$this->_ci->session->userdata('preference')){
			$this->preference=$this->_ci->session->userdata('preference');
		}
		
	}

	function initialize($config = array())
	{
		
	}
	
	public static function now($type='full', $return=true, $data=''){
		$result="";
		
		if ($data=='')
			$data=time();
		else
			$data=strtotime($data);
			
		switch($type){
			case 'full':
				$result= date('Y-m-d H:i:s',$data);
				break;
		}
		if ($return)
			return $result;
		else	
			echo $result;
	}
	
	public static function dump($expression , $return = false, $die=false){
        /*ob_start();
        var_dump($expression);
        $content = ob_get_contents();
        ob_end_clean();

        if($return){
            return $content;
        }else{
            if(isset($_SERVER['argc']) && isset($_SERVER['argv']))//from cli
                echo $content;
            else{
                echo '<pre class="doi_dump">';
                echo htmlentities($content);
                echo '</pre>';
            }
			if($die)
				die();
        }*/
        echo "<pre class='text-left fs-10'>";
		var_dump($expression);
        echo "</pre>";
		die();
    }
	
	public static function kirim_email($data){
		$_ci =& get_instance();
		$preference = $_ci->db->select('*');
		$preference = $_ci->db->get('preference');
			
		$prefs=$preference->result_array();
		foreach($prefs as $key=>$pref){
			$p[$pref['uri_title']]=$pref['value'];
		}
		
		ini_set('MAX_EXECUTION_TIME', 3);
		$subject=$data['subject'];
		// $email_user=$this->_ci->session->userdata('email_user');
		$email_user = 'ugd24jam@gmail.com';
		$config = Array(
					  'protocol' => $p['email_protocol'],
					  'smtp_host' => $p['email_smtp_host'],
					  'smtp_port' => $p['email_smtp_port'],
					  'smtp_user' => $p['email_smtp_user'],
					  'smtp_pass' => $p['email_smtp_pass'],
					  'mailtype' => $p['email_mailtype'],
					  'charset' => $p['email_charset'],
					  'wordwrap' => $p['email_wordwrap']
					);
		$message = $data['content'];
		// $path = $data['file'];
		if (array_key_exists('file', $data)){
			if (is_array($data['file'])){
				foreach($data['file'] as $row){
					$_ci->email->attach($row);
				}
			}else{
				$_ci->email->attach($data['file']);
			}
		}
		
		$_ci->load->library('email', $config);
		$_ci->email->set_newline("\r\n");
		$_ci->email->set_mailtype("html");
		$_ci->email->from($p['email_smtp_user']); // change it to yours
		$_ci->email->to($data['email']);// change it to yours
		if (array_key_exists('cc', $data)){
			$_ci->email->cc($data['cc']);// change it to yours
		}
		if (array_key_exists('bcc', $data)){
			$_ci->email->bcc($data['bcc']);// change it to yours
		}
		$_ci->email->subject($subject);
		$_ci->email->message($message);
		if($_ci->email->send())
		{
			$hasil= 'Email sent.';
		}
		else
		{
			 $hasil= $_ci->email->print_debugger();
		}
		return $hasil;

	}
}

// END Template class