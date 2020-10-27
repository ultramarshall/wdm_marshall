<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends MX_Model {

	
	public function __construct()
    {
        parent::__construct();
	}

	public function SaveForm($table,$form_data) {
        $this->db->insert($table, $form_data);
        if ($this->db->affected_rows() == '1') {
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function GetAllInfo($data) {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        $result = $this->db->where('email', $data['email'])->get(_TBL_USERS)->row();
        doi::dump($result);
    }

    public function Delete($table,$data) {
        if ($this->db->delete($table, $data))
            return "successfully removed";
        else
            return "deletion unsuccessful";
    }

    public function GetInfoByRow($table,$order_by,$data = null) {
        $this->db->order_by($order_by, 'DESC');
        $this->db->where($data);
        $query = $this->db->get($table)->row();
        if (empty($query)){
          throw new Exception("No result found");
        }else{
            return $query;
        }
        
    }
    
    public function Manage($table,$data, $where, $type) {
        $this->db->where($where);
        if ($this->db->update($table, $data))
            return True;
        else
            return False;
    }
	
}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */