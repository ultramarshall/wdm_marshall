<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance{

    private $CI;

    public function __construct() {

        $this->CI =& get_instance();

        // flag on and off
        $this->flag($this->CI->uri->segment(1));

        // get the flag status
        $check_maintenance = $this->CI->db->select('value')->where(array('uri_title' => 'sts_app'))->get('preference')->row();
		
        //display view if true
        if($check_maintenance->value == '0'){
			$check_waktu = $this->CI->db->select('value')->where(array('uri_title' => 'sts_app_waktu'))->get('preference')->row();			
			$data['waktu']['tahun']=date('Y');
			$data['waktu']['bulan']=date('m');
			$data['waktu']['tanggal']=date('d');
			$data['waktu']['jam']=1;
			$data['waktu']['menit']=0;
			if ($check_waktu){
				$hsl = explode('#',$check_waktu->value);
				$data['waktu']['tahun']=$hsl[0];
				$data['waktu']['bulan']=$hsl[1];
				$data['waktu']['tanggal']=$hsl[2];
				$data['waktu']['jam']=$hsl[3];
				$data['waktu']['menit']=$hsl[4];
			}
			$this->CI->load->view('maintenance', $data);
		}
    }

    private function flag(){

		$command = $this->CI->uri->segment(1);
		$year = intval($this->CI->uri->segment(2));
		$month = intval($this->CI->uri->segment(3));
		$day = intval($this->CI->uri->segment(4));
		$hour = intval($this->CI->uri->segment(5));
		$minute = intval($this->CI->uri->segment(6));
		if (empty($year)){$year=date('Y');}
		if (empty($month)){$month=date('m');}
		if (empty($day)){$day=date('d');}
		if (empty($hour)){$hour=23;}
		if (empty($minute)){$minute=59;}
		
        $waktu = $year .'#'. $month .'#'. $day .'#'. $hour .'#'. $minute;
		$this->CI->db->where('uri_title', 'sts_app');
		
        switch($command){
            case "activate":                
                $this->CI->db->update('preference', array('value' => 1)); 
				redirect(site_url('auth'));
            break;

            case "maintenance":
                $this->CI->db->update('preference', array('value' => 0));
				$this->CI->db->where('uri_title', 'sts_app_waktu');
                $this->CI->db->update('preference', array('value' => $waktu));
                redirect(site_url('/'));
            break;

        }
    }

}