<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class MX_Model extends CI_Model
{

    protected $cbo_kategori;
    protected $module_name;
    protected $no_select = true;
    protected $id_param_owner;
    protected $owner_child   = array();
    protected $arr_officer   = array();
    protected $arr_eksposure = array();

    public function __construct()
    {
        parent::__construct();
        $prefix = $this->db->dbprefix;

        $this->cbo_kategori   = array();
        $this->id_param_owner = $this->authentication->get_info_user('group');

        $this->module_name = $this->router->fetch_module();
        $this->auth_config = $this->config->item('authentication');

        $this->cbo_kategori = array(0 => ' - Parent - ');

    }

    public function get_combo_model($kel, $param = '')
    {
        $query  = "";
        $result = array();
        switch ($kel) {
            case "bahasa":
                $query = "SELECT  `key` as id, title as name FROM " . _TBL_BAHASA . " where status=1 order by title";
                break;
            case "bahasa_harian":
                $query = "SELECT  id, bahasa_harian as name FROM " . _TBL_BAHASA_HARIAN . " where aktif=1 order by urut";
                break;
            case "icon":
                $query = "SELECT  font as id, title as name FROM " . _TBL_FONT_ICON . " where status=1 order by title";
                break;
            case "product":
                $query = "SELECT  id, product_name as name FROM " . _TBL_PRODUK . " order by id desc";
                break;
            case "customers":
                $query = "SELECT  id, customer_name as name FROM " . _TBL_TEST_CUSTOMERS . " order by id desc";
                break;
            case "products":
                $query = "SELECT  id, concat(item_code, ' - ', item_name) as name FROM " . _TBL_TEST_STOCK . " where item_qty <> 0 order by id desc";
                break;
            case "category":
                $query = "SELECT  id, category_name as name FROM " . _TBL_WDS_PRODUCT_CATEGORY . " order by category_name";
                break;
            case "color":
                $query = "SELECT  id, color_name as name FROM " . _TBL_WDS_PRODUCT_COLOR . " order by color_name";
                break;
            case "brand":
                $query = "SELECT  id, brand_name as name FROM " . _TBL_BRAND . " where aktif=1 order by brand_name";
                break;
            case "fakultas":
                $query = "SELECT  id, nama_fakultas as name FROM " . _TBL_FAKULTAS . " order by id";
            break;
            case "posisi-menu":
                $query = $this->auth_config['menu'];
                return $query;
                break;
            case "data-combo":
                $where = '';
                if (is_array($param)) {
                    $where = " and kelompok='" . $param[0] . "' and id='" . $param[1] . "'";
                } elseif (!empty($param)) {
                    $where = " and kelompok='" . $param . "'";
                }
                $query = "SELECT  id, CASE WHEN kode='' THEN data ELSE concat(kode,'-',data) END as name FROM " . _TBL_DATA_COMBO . " where aktif='1' {$where} order by urut, data";
                break;
            case "groups":
                $query = "SELECT  id, group_name as name FROM " . _TBL_GROUPS . " where aktif=1 order by group_name";
                break;
            case "kelamin":
                $type = array('1' => 'Wanita', '2' => 'Pria');
                return $type;
                break;
            case "aksi-tooltips":
                $type = array('1' => 'Mode List Data', '2' => 'Mode Input', '3' => 'Mode Tambah data', '4' => 'Mode Edit Data');
                return $type;
                break;
            case "mimes":
                // die("okesss");
                $mimes = array(
                    'pdf'  => 'application/pdf',
                    'xls'  => 'application/vnd.ms-excel',
                    'ppt'  => 'application/vnd.ms-powerpoint',
                    'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                    'jpeg' => 'image/jpeg',
                    'jpg'  => 'image/jpg',
                    'png'  => 'image/png',
                    'doc'  => 'application/msword',
                    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'word' => 'application/msword',
                );
                return $mimes;
                break;
        }
        if (!empty($query)) {
            $result = $this->get_cbo($query);
        }

        return $result;
    }

    public function get_cbo($select)
    {
        $query = $select;

        $data = $this->db->query($query);

        $d        = $data->result();
        $combo[0] = " - select - ";
        foreach ($d as $key => $dt) {
            $combo[$dt->id] = ucwords($dt->name);
        }
        return $combo;
    }



    public function format_angka($nil)
    {
        if ($nil == 0) {
            $result = 0;
        } elseif ($nil < 1000000) {
            $nil    = $nil / 100000;
            $result = round($nil) . ' rb';
        } elseif ($nil < 1000000000) {
            $nil    = $nil / 1000000;
            $result = round($nil) . ' jt';
        } elseif ($nil < 1000000000000) {
            $nil    = $nil / 1000000000;
            $result = round($nil) . ' mlr';
        } else {
            $nil    = $nil / 1000000000000;
            $result = round($nil) . ' tr';
        }

        return $result;
    }


    
  

}
/* End of file app_login_model.php */
/* Location: ./application/models/app_login_model.php */
