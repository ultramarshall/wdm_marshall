<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/* load the MX_Router class */
// require APPPATH."third_party/MX/Controller.php";

class FrontendController extends MX_Controller
{
    protected $_data_menu = array();
    public function __construct()
    {
        parent::__construct();
        $this->template->set_layout('frontend');
        $this->get_script_template();
    }

    public function get_script_template($nm_modul = '')
    {

        // $this->template->prepend_metadata("<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>");
        $this->template->set_partial('loader', 'loader');
        $this->template->set_partial('css_frontend', 'css_frontend');
        $this->template->set_partial('js_frontend', 'js_frontend');
        $this->template->set_partial('js_frontend_bottom', 'js_frontend_bottom');
        $this->template->set_partial('header_frontend', 'header_frontend');
        $this->template->set_partial('footer_frontend', 'footer_frontend');
        $this->template->set_partial('sidebar_frontend_left', 'sidebar_frontend_left');
    }

    public function get_combo($kel, $param = array())
    {
        $result = $this->data->get_combo_model($kel, $param);
        return $result;
    }

    public function get_combo_no_select($kel, $param = array())
    {
        $result = $this->data->get_combo_model($kel, $param);
        unset($result[0]);
        return $result;
    }
    public function product_img($id) {
        return $this->data->product_img($id);
    }
}
class BackendController extends MX_Controller
{
    public $autoload      = array();
    public $tmp_data      = array();
    public $_tombol       = array();
    public $data_fields   = array();
    public $_Snippets_    = array();
    public $_Action_Input = array();
    public $_Action_List  = array();
    public $_param_list_  = array();
    public $_data_menu    = array();
    public $prefix        = "cimut_";
    public $tbl_preference;
    public $_pesan_error        = array();
    public $__arrSearch         = array();
    public $post                = array();
    public $msg_log_perda       = array();
    public $save_log            = false;
    public $sts_open_tab        = false;
    protected $arr_header_tab   = array();
    protected $modul_by_pass    = array();
    protected $mode_save        = "";
    protected $tbl_master       = "";
    protected $tbl_master_child = "";
    protected $i_left           = 0;
    protected $id_param_owner;
    protected $tbl_simpan  = "";
    protected $_STS_UPDATE = true;
    protected $_STS_INSERT = true;

    public function __construct()
    {
        parent::__construct();

        $this->save_log       = true;
        $this->prefix         = $this->db->dbprefix;
        $this->tbl_preference = $this->prefix . "preference";

        $this->modul_by_pass = array('profile', 'change-password');

        $this->remap = array('add' => '__add', 'edit' => '__edit', 'delete' => '__delete', 'cetak' => '__cetak', 'view' => '__edit', 'print' => '__print');

        $this->config->load('template');
        $this->tbl_suffix = $this->config->item('tbl_suffix');

        $lock_screen = $this->session->userdata('lock_screen');
        if ($lock_screen && $this->router->fetch_module() !== 'lock_screen') {
            header('location:' . base_url() . 'lock-screen');
        }

        if (isset($_GET['cs'])) {
            unset($_POST);
            $search['_' . $this->_Snippets_['modul'] . '_search_'] = array();
            $this->session->set_userdata($search);
            header('location:' . base_url($this->_Snippets_['modul']));
        }

        if (isset($_POST['sts_query'])) {
            $search['_' . $this->_Snippets_['modul'] . '_search_'] = $this->input->post();
            $this->session->set_userdata($search);
            $this->post = $this->input->post();
        } else {
            $this->post = $this->session->userdata('_' . $this->_Snippets_['modul'] . '_search_');
        }

        if (empty($this->post)) {
            $this->post = array();
        }

        $jml = 0;
        if ($x = $this->session->userdata('_' . $this->_Snippets_['modul'] . '_search_')) {
            foreach ($this->session->userdata('_' . $this->_Snippets_['modul'] . '_search_') as $key => $qs) {
                if ($key !== 'sts_query') {
                    if (!empty($qs)) {++$jml;}
                }
            }
        }

        $this->_Snippets_['jml_search'] = $jml;
        if (!$this->authentication->is_loggedin() && $this->router->fetch_module() !== 'auth') {
            $redirect_to            = urlencode(current_url());
            $redirect['last_visit'] = $redirect_to;
            $this->session->set_userdata($redirect);
            header('location:' . base_url('auth'));
            exit();
        }

        $angkatan     = $this->authentication->get_Info_Cabang('angkatan');
        $nil_angkatan = 1;
        if (is_array($angkatan)) {
            if (array_key_exists('angkatan', $angkatan)) {
                $nil_angkatan = $angkatan['angkatan'];
            }

        }

        $this->id_param_owner = $this->authentication->get_info_user('group_owner');

        $this->logdata->_log_data('modul', $this->_Snippets_['modul']);
        $this->_variabel();
        $this->reg_var();
        $this->get_script($this->router->fetch_module());
        $this->save_Activity();
    }

    public function _remap($method, $param)
    {
        $this->_Custom_Search();
        $method_cek = $method;
        $method_cek = str_replace('_', '-', $this->router->fetch_module());
        if (array_key_exists($method, $this->remap)) {
            $x   = $this->remap[$method];
            $cek = ($this->authentication->get_Privilege($method_cek, $method));

            if ($cek || $this->authentication->is_admin() || is_array($this->modul_by_pass)) {
                $this->$x();
            } else {
                $this->session->set_userdata('result_proses_error', 'Anda tidak memiliki hak akses untuk perintah ini');
                header('location:' . base_url($this->router->fetch_module()));
            }
        } elseif ($this->router->fetch_module() == 'auth') {
            $this->$method($param);
        } elseif ($method == 'index') {
            $cek = ($this->authentication->get_Privilege($method_cek, 'view'));
            if ($cek || $this->authentication->is_admin() || $this->router->fetch_module() == 'dashboard' || in_array($method_cek, $this->modul_by_pass)) {
                if (method_exists($this->router->fetch_class(), 'index')) {
                    $this->$method($param);
                } elseif (method_exists($this->router->fetch_class(), 'index_default')) {
                    $x = 'index_default';
                    $this->$x();
                } else {
                    show_404('error_404', 'Gagal');
                }
            } else {
                $this->template->build('page_error/error_auth');
                // header('location:'.base_url('page_error/error_auth'));
            }
        } elseif (method_exists($this->router->fetch_class(), $method)) {
            $this->$method($param);
        } elseif (method_exists($this->router->fetch_class(), 'index')) {
            $this->index();
        } else {
            show_404('error_404', 'Gagal');
        }
    }

    public function __get($class)
    {
        return CI::$APP->$class;
    }

    public function get_script($nm_modul = '')
    {
        // $data_left=$this->DATA_SIDEBAR_LEFT();
        $data_left['moduls'] = $this->_Snippets_['modul'];
        if (method_exists($this->router->fetch_class(), 'SIDEBAR_LEFT')) {$this->template->var_tmp('posisi', $this->SIDEBAR_LEFT());}

        if (method_exists($this->router->fetch_class(), 'SIDEBAR_RIGHT')) {$this->template->var_tmp('menukanan', $this->SIDEBAR_RIGHT());}

        // $this->template->prepend_metadata("<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>");
        $this->template->set_partial('preloader', 'preloader');
        $this->template->set_partial('css_login', 'css_login');
        $this->template->set_partial('css', 'css');
        $this->template->set_partial('js_login', 'js_login');
        $this->template->set_partial('js', 'js');
        $this->template->set_partial('footer', 'footer');
        $this->template->set_partial('js_bottom', 'js_bottom');
        $this->template->set_partial('header', 'header', $this->_data_menu);
        $this->template->set_partial('sidebar_left', 'sidebar_left', $data_left);
        $this->template->set_partial('sidebar_right', 'sidebar_right');
    }

    public function _variabel()
    {
        $this->tmp_data['action_width']['size']  = 10;
        $this->tmp_data['action_width']['align'] = 'center';
        $this->tmp_data['setSearchprivilege']    = true;
        $this->tmp_data['setActionprivilege']    = true;

        $sts_add   = "primary";
        $sts_del   = "info";
        $sts_cetak = "success";

        $sts       = $this->authentication->get_Privilege("icon_tombol");
        $txt_add   = "";
        $txt_del   = "";
        $txt_print = "";
        if ($sts) {
            $txt_add   = lang("msg_tombol_add");
            $txt_del   = lang("msg_tombol_del");
            $txt_print = lang("msg_tombol_print");
        }

        $this->_tombol['list']['add'] = '<a class="add btn btn-sm btn-' . $sts_add . ' btn-flat btn-success" href="' . base_url($this->_Snippets_['modul']) . '/add" data-toggle="popover" data-content="' . lang("msg_prop_tombol_add") . '"><i class="fa fa-plus"></i> ' . $txt_add . '</a>&nbsp;&nbsp;';
        $this->_tombol['list']['del'] = '<button type="submit" class="delete btn btn-sm btn-' . $sts_del . ' btn-flat btn-danger" value="Delete" name="delete_category" data-toggle="popover" data-content="' . lang("msg_prop_tombol_del") . '"><i class="fa fa-trash"></i> &nbsp;' . $txt_del . '</button>&nbsp;';

        $this->_tombol['list']['print'] = $this->_TOMBOL_PRINT(array('pdf', 'excel'));

        // $cetak=tombol_cetak(array('pdf','excel','word','csv','email'));
        // $cetak=tombol_cetak(array('pdf','excel'));
        // if ($cetak>0){
        // $li='';
        // foreach($cetak as $tombol){
        // $lang=lang("msg_tombol_print_".$tombol['type']);
        // if (!empty($lang)){
        // $title=lang("msg_tombol_print_".$tombol['type']);
        // }else{
        // $title=$tombol['label'];
        // }
        // $li .='<li><a href="#" onClick="cetak_lap(\''.$tombol['type'].'\')">'.$tombol['icon'].$title.'</a></li>';
        // }

        // $this->_tombol['list']['print']='
        // <div class="btn-group">
        // <button type="button" class="btn btn-'.$sts_cetak.' btn-flat"  data-toggle="popover" data-content="'.lang("msg_prop_tombol_print").'"><i class="fa fa-print"></i> '.$txt_print.'</button>
        // <button type="button" class="btn btn-'.$sts_cetak.' btn-flat dropdown-toggle" data-toggle="dropdown">
        // <span class="caret"></span>
        // <span class="sr-only">Toggle Dropdown</span>
        // </button>
        // <ul class="dropdown-menu" role="menu">
        // '.$li.'
        // </ul>
        // </div>';
        // }

        $sq = ucwords(strtolower(lang('msg_tombol_save_quit')));
        $s  = ucwords(strtolower(lang('msg_tombol_save')));
        $a  = ucwords(strtolower(lang('msg_tombol_add')));
        $l  = ucwords(strtolower(lang('msg_tombol_back_to_list')));

        $this->_tombol['input']['save']      = array('tbl_open' => "<button type='submit' class='delete btn btn-success btn-flat btn-sm' value='Simpan' name='l_save' data-toggle='popover' data-content='" . ucwords(strtolower(lang("msg_prop_tombol_save"))) . "'>", 'icon' => "<i class='fa fa-floppy-o'></i> ", 'label' => $s, 'tbl_close' => "</button>");
        $this->_tombol['input']['savequit']  = array('tbl_open' => "<button type='submit' class='btn btn-warning btn-flat btn-sm' name='l_save' value='Simpan_Quit' data-toggle='popover' data-content='" . ucwords(strtolower(lang("msg_prop_tombol_save_quit"))) . "'>", 'icon' => "<i class='fa fa-floppy-o'></i> ", 'label' => $sq, 'tbl_close' => "</button>");
        $this->_tombol['input']['add_input'] = array('tbl_open' => '<a class="add btn btn-' . $sts_add . ' btn-flat btn-sm" href="' . base_url($this->_Snippets_['modul']) . '/add" data-toggle="popover" data-content="' . ucwords(strtolower(lang("msg_prop_tombol_add"))) . '">', 'icon' => '<i class="fa fa-plus"></i>', 'label' => $a, 'tbl_close' => '</a>&nbsp;&nbsp;');
        $this->_tombol['input']['quit']      = array('tbl_open' => "<a class='danger btn btn-default  btn-flat btn-sm' href='" . base_url($this->_Snippets_['modul']) . "' data-toggle='popover' data-content='" . ucwords(strtolower(lang("msg_tombol_back_to_list"))) . "'>", 'icon' => "<i class='fa fa-sign-out'></i>", 'label' => $l, 'tbl_close' => "</a>");

        $this->_tombol['act_personal']['tombol']['edit']   = array('default' => true, 'url' => base_url($this->_Snippets_['modul'] . '/edit'), 'label' => 'Edit');
        $this->_tombol['act_personal']['tombol']['view']   = array('default' => false, 'url' => base_url($this->_Snippets_['modul'] . '/view'), 'label' => 'View');
        $this->_tombol['act_personal']['tombol']['print']  = array('default' => false, 'url' => base_url($this->_Snippets_['modul'] . '/print'), 'label' => 'Print', 'target' => '_blank');
        $this->_tombol['act_personal']['tombol']['delete'] = array('default' => false, 'url' => base_url($this->_Snippets_['modul'] . '/delete'), 'label' => 'Delete', 'class' => 'delete');
    }

    public function reg_var()
    {
        $this->tmp_data['tabs'] = array();

        $sts_add   = "primary";
        $sts_del   = "info";
        $sts_cetak = "success";

        if (!$this->authentication->is_admin() && !in_array($this->_Snippets_['modul'], $this->modul_by_pass)) {
            $privilege = $this->authentication->get_Privilege($this->_Snippets_['modul']);
            $key       = array('view' => $privilege['view'],
                'add'                     => $privilege['add'],
                'edit'                    => $privilege['edit'],
                'delete'                  => $privilege['delete'],
                'cetak'                   => $privilege['cetak']);

            // Doi::dump($key);die();
            if (intval($key['add']) == 0) {
                $sts_add = "default";
            }

            if (intval($key['delete']) == 0) {
                $sts_del = "default";
            }

            if (intval($key['cetak']) == 0) {
                $sts_cetak = "default";
            }

        } else if (in_array($this->_Snippets_['modul'], $this->modul_by_pass)) {
            $key = array('view' => 1, 'add' => 0, 'edit' => 1, 'delete' => 0, 'cetak' => 1, 'send' => 1);
        } else {
            $key = array('view' => 1, 'add' => 1, 'edit' => 1, 'delete' => 1, 'cetak' => 1, 'send' => 1);
        }

        $key['tombol_save']      = 1;
        $key['tombol_save_quit'] = 1;
        $key['tombol_add']       = 1;
        $key['tombol_quit']      = 1;

        $this->data_fields['url_data_table'] = $this->_Snippets_['modul'] . '/get_data_list';
        $this->data_fields['privilege']      = $key;
        $this->_param_list_['snippets']      = $this->_Snippets_;
        $this->GET_TOOLTIPS();
        if (method_exists($this->router->fetch_class(), 'BEFORE_LIST_RENDER')) {$this->_param_list_['header'] = $this->BEFORE_LIST_RENDER();}
        if (method_exists($this->router->fetch_class(), 'AFTER_LIST_RENDER')) {$this->_param_list_['footer'] = $this->AFTER_LIST_RENDER();}

        if (method_exists($this->router->fetch_class(), 'list_MANIPULATE_ACTION')) {
            $this->_tombol['list']['other'] = $this->list_MANIPULATE_ACTION();
        }

        $this->data_fields['action'] = $this->_tombol['list'];
    }

    public function _Custom_Search()
    {
        $post                                      = $this->post;
        $this->data_fields['master']['ket_search'] = array();
        // Doi::dump($post);die();
        $db = $this->db->database . ".";
        if (array_key_exists('fields', $this->tmp_data)) {
            foreach ($this->tmp_data['fields'] as $row) {
                if (array_key_exists('search', $row)) {
                    if ($row['search']) {
                        $alias = strtoupper(str_replace($db, "", $row['nmtbl'])) . "_";
                        if (array_key_exists('tbl_alias', $this->tmp_data)) {
                            if (array_key_exists($row['nmtbl'], $this->tmp_data['tbl_alias'])) {
                                $alias = strtoupper($this->tmp_data['tbl_alias'][$row['nmtbl']]) . "_";
                            }
                        }

                        $method_name = 'searchBox_' . $alias . strtoupper($row['field']);
                        if (method_exists($this->router->fetch_class(), $method_name)) {
                            $x                                 = $this->$method_name($row, $post);
                            $this->tmp_data['manual_search'][] = array('nmtbl' => $row['nmtbl'], 'field' => $row['field'], 'value' => $x);
                        }

                        $this->data_fields['master']['__search'] = $this->__Set_Search();

                        if (array_key_exists('q_' . $row['field'], $post)) {
                            if ($post['q_' . $row['field']] !== "" && $post['q_' . $row['field']] !== "-" && $post['q_' . $row['field']] !== "0") {
                                $ket                                         = $row['title'];
                                $value                                       = $this->__Get_value_Search('q_' . $row['field']);
                                $this->data_fields['master']['ket_search'][] = array('text' => $ket, 'value' => $value);
                            }
                        }
                    }
                }
            }
        }

    }

    public function __Get_value_Search($key)
    {
        $result = "";
        if (array_key_exists($key, $this->__arrSearch)) {
            $result = $this->__arrSearch[$key];
        }
        return $result;
    }

    public function __Set_value_Search($name, $isi)
    {
        $this->__arrSearch[$name] = $isi;
    }

    public function __Set_Search()
    {
        $this->data_fields['dat_edit']['fields'] = $this->post;
        $data                                    = $this->post;
        $arr_search                              = array();
        foreach ($this->tmp_data['fields'] as $key => $row) {
            $isi              = "";
            $style            = "";
            $onClick          = "";
            $onChange         = "";
            $span_left_addon  = '';
            $span_right_addon = '';
            $span_left        = '';
            $span_right       = '';
            $align            = 'text-left';

            if (array_key_exists('search', $row)) {
                if ($row['search']) {
                    if (isset($data['q_' . $row['field']])) {
                        if (!empty($data['q_' . $row['field']]) || $data['q_' . $row['field']] == '0') {
                            $isi = $data['q_' . $row['field']];
                        }

                    }
                    $title = $row['title'];
                    $type  = $row['input']['input'];

                    if (array_key_exists('align', $row['input'])) {
                        $align = 'text-' . $row['input']['align'];
                    } else {
                        switch ($type) {
                            case 'int':
                            case 'integer':
                            case 'intdot':
                            case 'integerdot':
                            case 'float':
                                $align = 'text-right';
                                break;
                            default:
                                $align = 'text-left';
                                break;
                        }
                    }

                    if (array_key_exists('bind', $this->tmp_data)) {
                        foreach ($this->tmp_data['bind'] as $bd) {
                            if ($bd['nmtbl'] == $row['nmtbl'] && $bd['field'] == $row['field']) {
                                if (array_key_exists('style', $bd)) {$style = $bd['style'];}
                                if (array_key_exists('onClick', $bd)) {$onClick = 'onClick="' . $bd['onClick'] . '"';}
                                if (array_key_exists('onChange', $bd)) {$onChange = 'onChange="' . $bd['onChange'] . '"';}
                                if (array_key_exists('value', $bd)) {$isi = $bd['value'];}
                                if (array_key_exists('align', $bd)) {$align = 'text-' . $bd['align'];}
                                if (array_key_exists('span_left_addon', $bd)) {$span_left_addon = '<span class="input-group-addon">' . $bd['span_left_addon'] . '</span>';}
                                if (array_key_exists('span_right_addon', $bd)) {$span_right_addon = '<span class="input-group-addon">' . $bd['span_right_addon'] . '</span>';}
                                if (array_key_exists('span_help', $bd)) {$span_help = '<span class="help-block">' . $bd['span_help'] . '</span>';}
                                if (array_key_exists('span_left', $bd)) {$span_left = $bd['span_left'];}
                                if (array_key_exists('span_right', $bd)) {$span_right = $bd['span_right'];}

                                break;
                            }
                        }
                    }

                    $type = $row['input']['input'];

                    if (array_key_exists('manual_search', $this->tmp_data)) {
                        foreach ($this->tmp_data['manual_search'] as $bd) {
                            if ($bd['nmtbl'] == $row['nmtbl'] && $bd['field'] == $row['field']) {
                                $manual_search = $bd['value'];
                                $type          = "manual_search";
                                break;
                            }
                        }
                    }

                    if (array_key_exists('label', $row)) {
                        $label = 'q_' . $row['label'];
                    } else {
                        $label = 'q_' . $row['field'];
                    }
                    $name = 'q_' . $row['field'];
                    switch ($type) {
                        case "manual_search":
                            $content = $manual_search;
                            break;
                        case 'string':
                        case 'text':
                            $content = form_input($name, $isi, " class='form-control wauto' id='" . $label . "' ");
                            break;
                        case 'multitext':
                            $content = form_textarea($name, $isi, " rows='2' cols='5' style='overflow: hidden; width: 410px; height: 104px;' class='form-control wauto'   id='" . $label . "' ");
                            break;
                        case 'int':
                        case 'integer':
                            $content = form_input($name, $isi, " class='numeric form-control wauto' id='" . $label . "'  ");
                            break;
                        case 'intdot':
                        case 'integerdot':
                            $content = form_input($name, $isi, " class='numericdot form-control wauto'  id='" . $label . "' ");
                            break;
                        case 'updown':
                            $content = form_input(array('type' => 'number', 'name' => $name), $isi, " class='numeric form-control wauto' id='" . $label . "'  ");
                            break;
                        case 'boolean:num':
                            $combo   = array('' => '-', '0' => 'No', '1' => 'Yes');
                            $content = form_dropdown($name, $combo, $isi, " style='height:30px;width:60px'  class='form-control wauto' id='" . $label . "'  ");
                            if (array_key_exists($isi, $combo)) {
                                $isi = $combo[$isi];
                            }

                            break;
                        case 'boolean':
                            $combo   = array('' => '-', 'N' => 'No', 'Y' => 'Yes');
                            $content = form_dropdown($name, $combo, $isi, " style='height:30px;width:60px'  class='form-control wauto' id='" . $label . "'  ");
                            if (array_key_exists($isi, $combo)) {
                                $isi = $combo[$isi];
                            }

                            break;
                        case 'combo':
                        case 'combo:search':
                            if (array_key_exists('combo', $row['input'])) {
                                $combo = $row['input']['combo'];
                            } else {
                                $combo = array();
                            }

                            $content = form_dropdown($name, $combo, $isi, "class='form-control wauto' style='width:100%!important;' id='" . $label . "'  ");
                            if (array_key_exists($isi, $combo)) {
                                $isi = $row['input']['combo'][$isi];
                            }

                            break;
                        case 'date':
                            $tgl = date('d-m-Y');
                            if (!empty($isi)) {
                                $tgl = date('d-m-Y', strtotime($isi));
                            }

                            $content = form_input($name, $isi, " class='datepicker form-control wauto' style='width:130px;'  id='" . $label . "' ");
                            break;
                        case 'datetime':
                            $tgl = date('d-m-Y');
                            if (!empty($isi)) {
                                $tgl = date('d-m-Y', strtotime($isi));
                            }

                            $format = json_encode([
                                "timepicker" => false,
                                "format"     => "d-m-Y",
                            ]);
                            $content = form_input($name, $isi, " class='date-time-picker form-control wauto' data-options='" . $format . "' style='width:130px;'  id='" . $label . "' ");
                            if (!empty($disabled)) {
                                $content .= form_hidden($label, $isi);
                            }

                            break;
                        case 'float':
                            $isi     = number_format(str_replace(',', '', floatval($isi)));
                            $content = form_input($label, $isi, " class='form-control numeric rupiah $align'  size=$row[size] $onChange id=$label ");
                            if (!empty($disabled)) {
                                $content .= form_hidden($label, $isi);
                            }

                            break;
                    }
                    if ($type !== 'manual_search') {
                        $this->__Set_value_Search($name, $isi);
                    }

                    $arr_search[] = array('title' => $title, 'value' => $span_right . $span_right_addon . $content . $span_left_addon . $span_left);
                }
            }
        }
        return $arr_search;
    }

    public function __delete()
    {
        $this->data_fields['mode_aksi'] = $this->mode_action;
        $this->mode_save                = "delete";
        if (isset($_POST['check_item'])) {
            $id = $_POST['check_item'];
        } elseif (intval($this->uri->segment(3)) > 0) {
            $id[] = intval($this->uri->segment(3));
        } else {
            header('location:' . base_url($this->_Snippets_['modul']));
        }
        $check_before = true;
        if (method_exists($this->router->fetch_class(), 'POST_DELETE_MANUAL')) {
            $check_before = $this->POST_DELETE_MANUAL($id);
        } else {
            if (method_exists($this->router->fetch_class(), 'POST_CHECK_BEFORE_DELETE')) {
                $check_before = $this->POST_CHECK_BEFORE_DELETE($id);
            }

            if ($check_before) {
                /* mulai melakukan proses simpan */
                $this->db->trans_begin();
                //die("tabel ".$this->tmp_data['primary']);
                $result = $this->crud->delete_data($this->tmp_data['primary'], $id);
                if ($result) {
                    if (method_exists($this->router->fetch_class(), 'POST_DELETE_PROCESSOR')) {
                        // $old=$this->crud->get_data($id, $this->tmp_data);
                        $result = $this->POST_DELETE_PROCESSOR($id, $old);
                    }
                }
                if ($result) {
                    $this->db->trans_commit();
                    if ($this->save_log) {
                        $this->logdata->_save_log_data();
                    }

                } else {
                    $this->db->trans_rollback();
                }
            } else {
                $msg = $this->_get_pesan();
                $this->session->set_userdata(array('result_proses_error' => $msg));
                // die($this->session->userdata('result_proses_error'));
            }
        }
        header('location:' . base_url($this->_Snippets_['modul']));
    }

    public function __edit($id = '')
    {
        $this->mode_save = "edit";
        $_GET['id']      = ($id == '') ? $this->uri->segment(3) : $id;
        if ($_GET['id'] == '') {
            header('location:' . base_url($this->_Snippets_['modul']));
        }

        $this->logdata->_log_data('kel', 'Update');

        if (method_exists($this->router->fetch_class(), 'MASTER_DATA_INPUT')) {
            $this->MASTER_DATA_INPUT();
        }

        $this->data_fields['mode_aksi'] = $this->mode_action;
        $this->data_fields['action']    = $this->_tombol['input'];
        if (method_exists($this->router->fetch_class(), 'update_MANIPULATE_ACTION')) {$this->data_fields['action'] = $this->update_MANIPULATE_ACTION($this->_tombol['input']);}

        if (!empty($save)) {
            $this->data_fields['dat_edit']['fields'] = $this->input->post();
        } elseif (method_exists($this->router->fetch_class(), 'postData_SOURCE_UPDATE')) {
            $this->data_fields['dat_edit'] = $this->postData_SOURCE_UPDATE();
        } else {
            $this->data_fields['dat_edit'] = $this->crud->get_data($_GET['id'], $this->tmp_data);
        }
        $this->_param_list_['header'] = "";
        $this->_param_list_['footer'] = "";
        if (method_exists($this->router->fetch_class(), 'BEFORE_INPUT_RENDER')) {$this->_param_list_['header'] = $this->BEFORE_INPUT_RENDER($this->data_fields['dat_edit']['fields']);}
        if (method_exists($this->router->fetch_class(), 'AFTER_INPUT_RENDER')) {$this->_param_list_['footer'] = $this->AFTER_INPUT_RENDER($this->data_fields['dat_edit']['fields']);}
        if (method_exists($this->router->fetch_class(), 'CHANGE_PRIVILEGE')) {$this->data_fields['privilege'] = $this->CHANGE_PRIVILEGE($_GET['id'], $this->data_fields['privilege']);}

        if (method_exists($this->router->fetch_class(), 'update_OPTIONAL_CMD')) {$this->data_fields['optional_cmd'] = $this->update_OPTIONAL_CMD($_GET['id'], $this->data_fields['dat_edit']['fields']);}

        $save = $this->input->post('l_save');
        $this->data_fields['dat_edit']['sts'] = 'edit';
        if (!empty($save)) {
            $sts_form_validation                     = cek_form_validation($this->tmp_data['fields']);
            $this->data_fields['dat_edit']['fields'] = $this->input->post();
            if ($sts_form_validation == false) {

                foreach ($this->tmp_data['fields'] as $row) {
                    $method_name = 'updateBox_' . strtoupper($row['field']);
                    if (method_exists($this->router->fetch_class(), $method_name)) {
                        if (array_key_exists('label', $row)) {
                            $label = $row['label'];
                        } else {
                            $label = $row['l_' . $row['field']];
                        }

                        $free = false;
                        if (array_key_exists('input', $row)) {
                            if (array_key_exists('type', $row['input'])) {
                                if (strtolower($row['input']['type']) == 'free') {
                                    $free = true;
                                }
                            }
                        }
                        if ($free) {
                            $value = '';
                        } else {
                            $value = $this->data_fields['dat_edit']['fields'][$label];
                        }

                        $x                                             = $this->$method_name($row, $this->data_fields['dat_edit']['fields'], $value);
                        $this->data_fields['master']['manual_input'][] = array('nmtbl' => $row['nmtbl'], 'field' => $row['field'], 'value' => $x);
                    }
                }
                $this->_param_list_['content'] = $this->load->view('statis/tmp_input', $this->data_fields, true);
                $this->template->build('statis/table', $this->_param_list_);
            } else {
                $this->tmp_data['data'] = $this->input->post();

                /* mulai melakukan proses simpan */
                $this->db->trans_begin();

                /* Ambil data lama */
                if (method_exists($this->router->fetch_class(), 'postData_SOURCE_UPDATE')) {
                    $this->tmp_data['old_data'] = $this->postData_SOURCE_UPDATE();
                } else {
                    $this->tmp_data['old_data'] = $this->crud->get_data($_GET['id'], $this->tmp_data);
                }

                /* Cek apakah data inputa akan dirubah sebelum disimpan ? */
                foreach ($this->tmp_data['fields'] as $field) {
                    if (array_key_exists('show', $field)) {
                        if ($field['show'] || $field['save']) {
                            if (array_key_exists('label', $field)) {
                                $label = $field['label'];
                            } else {
                                $label = 'l_' . $field['field'];
                            }
                            $method_name = 'updateValue_' . strtoupper($field['field']);
                            if (method_exists($this->router->fetch_class(), $method_name)) {
                                $this->tmp_data['data'][$label] = $this->$method_name($this->tmp_data['data'][$label], $this->tmp_data['data'], $this->tmp_data['old_data']);
                            }
                        }
                    }
                }

                /* Fungsi POST_CHECK_BEFORE_UPDATE melakukan pengecekan data sebelum disimpan ke database, return true/false */
                $check_before = true;
                if (method_exists($this->router->fetch_class(), 'POST_CHECK_BEFORE_UPDATE')) {
                    $check_before = $this->POST_CHECK_BEFORE_UPDATE($this->tmp_data['data'], $this->tmp_data['old_data']['fields']);
                }

                /* Jika Hasil pengecekan bernilai False, lakukan Roolback, dan kembalikan ke mode input */
                if (!$check_before) {
                    $this->session->set_userdata(array('result_proses_error' => $this->_get_pesan()));
                    $this->db->trans_rollback();
                    $this->_param_list_['content'] = $this->load->view('statis/tmp_input', $this->data_fields, true);
                    $this->template->build('statis/table', $this->_param_list_);
                } else {
                    /* jika pengecekan berilai True, selanjutnya cek apakah ada fungsi yang akan melakukan penimpanan secara manual ? POST_UPDATE_HANDLE
                    Jika ada lakukan penyimpanan secara manual */
                    if (method_exists($this->router->fetch_class(), 'POST_UPDATE_HANDLE')) {
                        $id_new = $this->POST_UPDATE_HANDLE($this->tmp_data, $this->tmp_data['old_data']['fields']);
                    } else {
                        if ($this->_STS_UPDATE) {
                            if (!empty($this->tbl_simpan)) {$this->tbl_master = $this->tbl_simpan;}
                            $id_new = $this->crud->simpan_data($this->tmp_data, $this->tbl_master, $this->tmp_data['old_data']['fields']);
                        } else {
                            $id_new = $_GET['id'];
                        }
                    }

                    if (method_exists($this->router->fetch_class(), 'DEBUG_UPDATE_QUERY')) {
                        $this->DEBUG_UPDATE_QUERY($this->db->last_query());
                        die();
                    }

                    /* Jika hasil penyimpanan berhasil, maka selanjutnya cek apakah ada fungsi yang memanggil yang akan melakukan penyimpanan selanjutnya ? */
                    $result = true;
                    if ($id_new > 0) {
                        if (method_exists($this->router->fetch_class(), 'POST_UPDATE_PROCESSOR')) {
                            $result = $this->POST_UPDATE_PROCESSOR($id_new, $this->tmp_data['data'], $this->tmp_data['old_data']);
                            if (!$result) {
                                $this->db->trans_rollback();
                                $msg = "Gagal memproses data<br>" . $this->session->userdata('result_proses_error') . "<br>" . $this->db->error()['message'];
                                $this->session->set_userdata(array('result_proses_error' => $msg));
                            } else {
                                $this->db->trans_commit();
                            }
                        } else {
                            $this->db->trans_commit();
                        }

                        $this->logdata->_log_data('new_data', $this->tmp_data['data']);
                        $this->logdata->_log_data('old_data', $this->tmp_data['old_data']['fields']);
                        if ($this->save_log) {
                            $this->logdata->_save_log_data();
                        }

                    } else {
                        $result = false;
                        $this->db->trans_rollback();
                    }

                    if ($id_new && $result) {
                        $method_name = 'POST_AFTER_UPDATE';
                        if (method_exists($this->router->fetch_class(), $method_name)) {
                            $this->$method_name($id_new, $this->tmp_data['data']);
                        }

                        unset($_POST);
                        $method_name = 'POST_UPDATE_REDIRECT_URL';
                        if ($save == 'Simpan') {
                            if (method_exists($this->router->fetch_class(), $method_name)) {
                                $url = $this->$method_name(base_url($this->_Snippets_['modul'] . '/edit/' . $id_new, $id_new));
                            } else {
                                $url = base_url($this->_Snippets_['modul'] . '/edit/' . $id_new);
                            }
                        } else {
                            $url = base_url($this->_Snippets_['modul']);
                        }
                        header('location:' . $url);
                    } else {
                        $this->db->trans_rollback();
                        $this->_param_list_['content'] = $this->load->view('statis/tmp_input', $this->data_fields, true);
                        $this->template->build('statis/table', $this->_param_list_);
                    }
                }
            }
        } else {
            foreach ($this->tmp_data['fields'] as $key => $row) {
                $method_name = 'updateBox_' . strtoupper($row['field']);
                if (method_exists($this->router->fetch_class(), $method_name)) {
                    if (array_key_exists('label', $row)) {
                        $label = $row['label'];
                    } else {
                        $label = 'l_' . $row['field'];
                    }
                    $free = false;
                    if (array_key_exists('input', $row)) {
                        if (array_key_exists('type', $row['input'])) {
                            if (strtolower($row['input']['type']) == 'free') {
                                $free = true;
                            }
                        }
                    }
                    if ($free) {
                        $value = '';
                    } else {
                        $value = $this->data_fields['dat_edit']['fields'][$label];
                    }

                    $x = $this->$method_name($row, $this->data_fields['dat_edit']['fields'], $value);
                    if (is_array($x)) {
                        foreach ($x as $key_x => $xx) {
                            if (is_array($xx)) {
                                foreach ($xx as $key_y => $yy) {
                                    $this->data_fields['master']['fields'][$key][$key_x][$key_y] = $yy;
                                }
                            } else {
                                $this->data_fields['master']['fields'][$key][$key_x] = $xx;
                            }
                        }
                        // $this->data_fields['master']['fields'][$x]=array('nmtbl'=>$row['nmtbl'],'field'=>$row['field'],'value'=>$x);
                    } else {
                        $this->data_fields['master']['manual_input'][] = array('nmtbl' => $row['nmtbl'], 'field' => $row['field'], 'value' => $x);
                    }
                }
            }
            // unset($row);
            // Doi::dump($this->data_fields['master']['fields']);die();
            if (count($this->data_fields['dat_edit']['fields']) > 0) {
                $this->data_fields['dat_edit']['sts'] = 'edit';
                $this->_param_list_['content']        = $this->load->view('statis/tmp_input', $this->data_fields, true);
                $this->template->build('statis/table', $this->_param_list_);
            } else {
                $this->template->build('errors/html/error_505', $this->_param_list_);
            }
        }
    }

    public function __add()
    {
        $this->mode_save = "add";
        // Doi::dump($this->input->post);
        $save                                 = $this->input->post('l_save');
        $this->data_fields['dat_edit']['sts'] = 'add';

        $this->logdata->_log_data('kel', 'Insert');

        $this->data_fields['mode_aksi'] = $this->mode_action;
        $this->data_fields['action']    = $this->_tombol['input'];
        if (method_exists($this->router->fetch_class(), 'insert_MANIPULATE_ACTION')) {$this->data_fields['action'] = $this->insert_MANIPULATE_ACTION($this->_tombol['input']);}

        $this->_param_list_['header'] = "";
        $this->_param_list_['footer'] = "";

        if (method_exists($this->router->fetch_class(), 'BEFORE_INPUT_RENDER')) {$this->_param_list_['header'] = $this->BEFORE_INPUT_RENDER();}
        if (method_exists($this->router->fetch_class(), 'AFTER_INPUT_RENDER')) {$this->_param_list_['footer'] = $this->AFTER_INPUT_RENDER(array());}

        if (method_exists($this->router->fetch_class(), 'BEFORE_SUB_INPUT_RENDER')) {$this->data_fields['sub_header'] = $this->BEFORE_SUB_INPUT_RENDER();}
        if (method_exists($this->router->fetch_class(), 'AFTER_SUB_INPUT_RENDER')) {$this->data_fields['sub_footer'] = $this->AFTER_SUB_INPUT_RENDER();}

        if (method_exists($this->router->fetch_class(), 'insert_OPTIONAL_CMD')) {$this->data_fields['optional_cmd'] = $this->insert_OPTIONAL_CMD();}

        // Doi::dump($save);
        // die("okes");
        if (!empty($save)) {
            $sts_form_validation = cek_form_validation($this->tmp_data['fields']);

            if ($sts_form_validation) {
                if (method_exists($this->router->fetch_class(), 'POST_CHECK_BEFORE_INSERT')) {
                    $sts_form_validation = $this->POST_CHECK_BEFORE_INSERT($this->input->post());
                }
            }

            // Doi::dump($this->input->post());
            if ($sts_form_validation == false) {
                $this->data_fields['dat_edit']['fields'] = $this->input->post();

                foreach ($this->tmp_data['fields'] as $row) {
                    $method_name = 'insertBox_' . strtoupper($row['field']);
                    if (method_exists($this->router->fetch_class(), $method_name)) {
                        $x                                             = $this->$method_name($row);
                        $this->data_fields['master']['manual_input'][] = array('nmtbl' => $row['nmtbl'], 'field' => $row['field'], 'value' => $x);
                    }
                }
                $this->session->set_userdata(array('result_proses_error' => $this->_get_pesan()));
                $this->_param_list_['content'] = $this->load->view('statis/tmp_input', $this->data_fields, true);

                $this->template->build('statis/table', $this->_param_list_);
            } else {
                $this->tmp_data['data'] = $this->input->post();
                $check_before           = true;
                // if (method_exists($this->router->fetch_class(),'POST_CHECK_BEFORE_INSERT'))
                // {
                // $check_before=$this->POST_CHECK_BEFORE_INSERT($this->tmp_data['data']);
                // }

                if (!$check_before) {
                    $this->data_fields['dat_edit']['fields'] = $this->input->post();
                    $this->_param_list_['content']           = $this->load->view('statis/tmp_input', $this->data_fields, true);
                    $this->template->build('statis/table', $this->_param_list_);
                } else {
                    /* Mu;ai melakukan proses penyimpanan */
                    $this->db->trans_begin();

                    /* Cek apakah data inputa akan dirubah sebelum disimpan ? */
                    foreach ($this->tmp_data['fields'] as $field) {
                        if (array_key_exists('show', $field)) {
                            if ($field['show'] || $field['save']) {
                                if (array_key_exists('label', $field)) {
                                    $label = $field['label'];
                                } else {
                                    $label = 'l_' . $field['field'];
                                }
                                $method_name = 'insertValue_' . strtoupper($field['field']);

                                if (method_exists($this->router->fetch_class(), $method_name)) {
                                    $this->tmp_data['data'][$label] = $this->$method_name($this->tmp_data['data'][$label], $this->tmp_data['data']);
                                }
                            }
                        }
                    }
                    if (method_exists($this->router->fetch_class(), 'POST_INSERT_HANDLE')) {
                        $id_new = $this->POST_INSERT_HANDLE($this->tmp_data, $this->tbl_master);
                    } else {
                        if ($this->_STS_INSERT) {
                            if (!empty($this->tbl_simpan)) {$this->tbl_master = $this->tbl_simpan;};
                            $id_new = $this->crud->simpan_data($this->tmp_data, $this->tbl_master);
                        } else {
                            $id_new = 1;
                        }
                    }
                    // die("kesini ".$id_new);

                    if (method_exists($this->router->fetch_class(), 'DEBUG_INSERT_QUERY')) {
                        $this->DEBUG_INSERT_QUERY($this->db->last_query());
                        die();
                    }

                    $id = true;
                    if ($id_new > 0) {
                        if (method_exists($this->router->fetch_class(), 'POST_INSERT_PROCESSOR')) {
                            $id = $this->POST_INSERT_PROCESSOR($id_new, $this->tmp_data['data']);
                            if (!$id) {
                                $this->db->trans_rollback();
                                $msg = "Gagal memproses data<br>" . $this->db->error()['message'];
                                $this->session->set_userdata(array('result_proses_error' => 'Gagal memproses data'));
                                $id = false;
                            } else {
                                $this->db->trans_commit();
                            }
                        } else {
                            $this->db->trans_commit();
                        }

                        $this->logdata->_log_data('new_data', $this->tmp_data['data']);
                        if ($this->save_log) {
                            $this->logdata->_save_log_data();
                        }

                    } else {
                        $this->db->trans_rollback();
                        $id = false;
                    }
                    // echo " kode savenya ".$save;
                    // die(" id newnya ".$id_new.' dan id nya '.$id);
                    if ($id_new && $id) {
                        $method_name = 'POST_AFTER_INSERT';
                        if (method_exists($this->router->fetch_class(), $method_name)) {
                            $this->$method_name($id_new, $this->tmp_data['data']);
                        }

                        unset($_POST);
                        $method_name = 'POST_INSERT_REDIRECT_URL';
                        if ($save == 'Simpan') {
                            if (method_exists($this->router->fetch_class(), $method_name)) {
                                $url = $this->$method_name(base_url($this->_Snippets_['modul'] . '/edit/' . $id_new), $id_new);
                            } else {
                                $url = base_url($this->_Snippets_['modul'] . '/edit/' . $id_new);
                            }
                        } else {
                            $url = base_url($this->_Snippets_['modul']);
                        }
                        header('location:' . $url);
                    } else {
                        $this->data_fields['dat_edit']['fields'] = $this->input->post();
                        $this->_param_list_['content']           = $this->load->view('statis/tmp_input', $this->data_fields, true);
                        $this->template->build('statis/table', $this->_param_list_);
                    }
                }
            }
        } else {
            foreach ($this->tmp_data['fields'] as $row) {
                $method_name = 'insertBox_' . strtoupper($row['field']);
                if (method_exists($this->router->fetch_class(), $method_name)) {
                    $x                                             = $this->$method_name($row);
                    $this->data_fields['master']['manual_input'][] = array('nmtbl' => $row['nmtbl'], 'field' => $row['field'], 'value' => $x);
                }
            }
            $this->_param_list_['content'] = $this->load->view('statis/tmp_input', $this->data_fields, true);
            $this->template->build('statis/table', $this->_param_list_);
        }
    }

    public function get_data_list()
    {
        $rows = $this->crud->get_all_data($this->tmp_data, $this->post, $this->_Snippets_, $this->input->get());

        $label_id = 'l_id';
        foreach ($this->tmp_data['fields'] as $key2 => $fld) {
            if ($fld['field'] == $this->tmp_data['primary']['id']) {
                if (array_key_exists('label', $fld)) {
                    $label_id = $fld['label'];
                } else {
                    $label_id = 'l_' . $fld['field'];
                }

                break;
            }
        }

        if (method_exists($this->router->fetch_class(), 'MASTER_DATA_LIST')) {
            $arr_id = array('0');
            foreach ($rows['fields'] as $row) {
                $arr_id[] = $row[$label_id];
            }
            // Doi::dump("siap");
            $this->MASTER_DATA_LIST($arr_id, $rows);
            // die("oke");
        }

        if (method_exists($this->router->fetch_class(), 'DEBUG_LIST_QUERY')) {
            $this->DEBUG_LIST_QUERY($rows['sql']);
            die();
        }

        $output = array(
            "sEcho"                => intval(@$_GET['sEcho']),
            "iTotalRecords"        => $rows['iTotal']['iTotal'],
            "iTotalDisplayRecords" => $rows['iFilteredTotal']['iFilteredTotal'],
            "aaData"               => array());

        $i = floatval($this->input->get('iDisplayStart')) + 1;
        foreach ($rows['fields'] as $row) {
            $privilege = $this->data_fields['privilege'];
            if (method_exists($this->router->fetch_class(), 'CHANGE_PRIVILEGE') && !$this->authentication->is_admin()) {$privilege = $this->CHANGE_PRIVILEGE($row['l_id'], $this->data_fields['privilege']);}

            $id_edit       = $row[$label_id];
            $tombol_detail = $this->_tombol['act_personal']['tombol'];
            if (method_exists($this->router->fetch_class(), 'list_MANIPULATE_PERSONAL_ACTION')) {$tombol_detail = $this->list_MANIPULATE_PERSONAL_ACTION($this->_tombol['act_personal']['tombol'], $row);}

            $brs      = array();
            $chek_del = '';
            if ($privilege['delete']) {
                if (array_key_exists('delete', $tombol_detail)) {
                    if ($tombol_detail['delete']) {
                        $chek_del = '<input type="checkbox" name="check_item[]" value="' . $row['l_' . $this->tmp_data['primary']['id']] . '">';
                    }
                }

            }

            $brs[] = $chek_del;

            foreach ($this->tmp_data['title'] as $field) {
                $show = true;
                if (array_key_exists(5, $field)) {
                    $show = $field[5];
                }

                if ($show) {

                    $nl2br = false;
                    $free  = false;
                    $label = 'l_' . $field[1];

                    foreach ($this->tmp_data['fields'] as $key2 => $fld) {
                        $type = "string";
                        if ($fld['field'] == $field[1] && $fld['nmtbl'] == $field[0]) {
                            if (array_key_exists('input', $fld)) {
                                if ($fld['input']['input'] == "multitext") {
                                    $nl2br = true;
                                } elseif ($fld['input']['input'] == "free" || $fld['input']['type'] == "free") {
                                    $free = true;
                                }
                                $type = $fld['input']['input'];
                            }

                            if (array_key_exists('label', $fld)) {
                                $label = $fld['label'];
                            } else {
                                $label = 'l_' . $fld['field'];
                            }

                            break;
                        }
                    }

                    $align = "left";

                    if ($free) {
                        $isi = "";
                    } else {
                        $isi = $row[$label];
                    }
                    $method_name = 'listBox_' . strtoupper($field[1]);
                    if (method_exists($this->router->fetch_class(), $method_name)) {
                        $tampil = $this->$method_name($row, $isi, 'web');
                    } else {
                        $tampil = $isi;
                    }
                    if ($type == 'float') {
                        if (is_decimal($tampil)) {
                            $tampil = number_format($tampil, intval($fld['decimal']));
                        } else {
                            $tampil = number_format($tampil);
                        }

                        if ($tampil == 0) {
                            $tampil = "";
                        }

                        $align = "right";
                    } elseif ($type == 'date') {
                        if (!empty($tampil) && $tampil !== '00-00-0000') {
                            $tampil = date('d-m-Y', strtotime($tampil));
                        }

                    }

                    if (array_key_exists(4, $field)) {
                        if (!empty($field[4])) {
                            $align = $field[4];
                        }

                    }

                    if ($nl2br) {
                        $tampil = nl2br($tampil);
                    }
                    $brs[] = '<div class="text-' . $align . '">' . $tampil . '</div>';
                }
            }

            $li             = '';
            $first          = true;
            $target_default = "";
            $key_default    = "";
            if ($this->tmp_data['setActionprivilege']) {
                foreach ($tombol_detail as $key => $tbl) {
                    $class = '';
                    $att   = '';
                    if (array_key_exists('default', $tbl)) {
                        if (!$tbl['default']) {
                            $oke = true;
                            if ($key == 'delete' && !$privilege['delete']) {$oke = false;}
                            if ($key == 'edit' && !$privilege['edit']) {$oke = false;}
                            if ($key == 'print' && !$privilege['cetak']) {$oke = false;}

                            if (array_key_exists('att', $tbl)) {$att = $tbl['att'];}

                            if (!empty($tbl) && $oke) {
                                $target = "";
                                if (array_key_exists('target', $tbl)) {
                                    $target = " target='{$tbl['target']}'";
                                }

                                if (array_key_exists('class', $tbl)) {
                                    $li .= '<li url="' . $tbl['url'] . '/' . $id_edit . '" ' . $att . ' class="dropdown-item ' . $tbl['class'] . ' pointer"><a>' . $tbl['label'] . '</a></li>';
                                } else {
                                    $li .= '<li><a class="dropdown-item" href="' . $tbl['url'] . '/' . $id_edit . '"' . $target . ' ' . $att . '>' . $tbl['label'] . '</a></li>';
                                }
                                if ($first) {
                                    $key_default    = ucwords($key);
                                    $target_default = $tbl['url'] . '/' . $id_edit;
                                }
                                $first = false;
                            }
                        }
                    }
                }

                $tombol = '<div class="text-' . $this->tmp_data['action_width']['align'] . '"><div class="btn-group">';

                foreach ($tombol_detail as $key => $tbl) {
                    $att = '';
                    if (array_key_exists('default', $tbl)) {
                        if ($tbl['default']) {
                            $oke = true;
                            if ($key == 'delete' && !$privilege['delete']) {$oke = false;}
                            if ($key == 'edit' && !$privilege['edit']) {$oke = false;}
                            if ($key == 'send' && !$privilege['send']) {$oke = false;}
                            if ($key == 'view' && !$privilege['view']) {$oke = false;}
                            if ($key == 'print' && !$privilege['cetak']) {$oke = false;}

                            $target = "";
                            if (array_key_exists('target', $tbl)) {
                                $target = " target='{$tbl['target']}'";
                            }

                            if (array_key_exists('att', $tbl)) {$att = $tbl['att'];}
                            if (array_key_exists('span', $tbl) && $oke) {
                                $tombol .= $tbl['source'];
                            } elseif (array_key_exists('class', $tbl) && $oke) {
                                $tombol .= '<a style="-webkit-appearance: none;" class="btn btn-flat btn-sm btn-app text-white ' . $tbl['class'] . '" type="button" href="' . $tbl['url'] . '/' . $id_edit . '" ' . $att . '>' . $tbl['label'] . '</a>';
                            } elseif ($oke) {
                                $tombol .= '<a style="-webkit-appearance: none;" class="btn btn-flat btn-sm btn-app text-white" type="button" href="' . $tbl['url'] . '/' . $id_edit . '" ' . $att . ' ' . $target . '>' . $tbl['label'] . '</a>';
                            } else {
                                $tombol .= '<a style="-webkit-appearance: none;" class="btn btn-flat btn-sm btn-app text-white" type="button" href=' . $target_default . '>' . $key_default . '</a>';
                            }

                            if (!empty($li)) {
                                $tombol .= '
												<button class="btn btn-sm btn-flat dropdown-toggle btn-app text-white" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown">
													<span class="caret"></span>
												</button>
												<ul class="dropdown-menu">' . $li . '
												</ul>
											';
                            }
                            break;
                        }
                    }
                }
                $tombol .= '</div></div>';

                $brs[] = $tombol;
            }

            $output['aaData'][] = $brs;

            ++$i;
        }

        echo json_encode($output);
    }

    public function __print()
    {

        $id   = intval($this->uri->segment(3));
        $rows = $this->crud->get_data($id, $this->tmp_data);
        if (method_exists($this->router->fetch_class(), 'PRINT_CUSTOM')) {
            $this->PRINT_CUSTOM($rows['fields']);
            // exit();
        } else {
            $this->load->library('cetak');
            $arr_id = array($rows['fields']['l_id']);

            if (method_exists($this->router->fetch_class(), 'MASTER_DATA_LIST')) {
                $this->MASTER_DATA_LIST($arr_id, $rows);
            }

            $arr_title = array();
            $data      = array();
            foreach ($this->tmp_data['fields'] as $field) {
                $method_name_cetak = 'PrintBox_' . strtoupper($field['field']);
                $method_name       = 'listBox_' . strtoupper($field['field']);

                if (array_key_exists('label', $field)) {
                    $label = $field['label'];
                } else { $label = 'l_' . $field['field'];}
                if (method_exists($this->router->fetch_class(), $method_name_cetak)) {
                    $row = $rows['fields'];
                    $isi = '';
                    if (array_key_exists('input', $field)) {
                        if ($field['input']['type'] !== 'free') {
                            $isi = $row[$label];
                        }

                    }
                    $data[$label] = $this->$method_name_cetak($row, $isi);

                } else if (method_exists($this->router->fetch_class(), $method_name)) {
                    $row = $rows['fields'];
                    $isi = '';
                    if (array_key_exists('input', $field)) {
                        if ($field['input']['type'] !== 'free') {
                            $isi = $row[$label];
                        }

                    }
                    $data[$label] = $this->$method_name($row, $isi, 'pdf');
                } else {
                    $data[$label] = $rows['fields'][$label];
                }
            }

            foreach ($this->tmp_data['title'] as $key => $field) {
                $show = true;
                if (array_key_exists(6, $field)) {
                    $show = $field[6];
                }

                if ($show) {
                    $arr_title[] = $field[1];
                }

                $jdl = lang('msg_field_' . $field[1]);
                if (!empty($field[2])) {
                    $this->tmp_data['title'][$key]['judul'] = $field[2];
                } elseif (!empty($jdl)) {
                    $this->tmp_data['title'][$key]['judul'] = $jdl;
                } else {
                    $this->tmp_data['title'][$key]['judul'] = $field[1];
                }

            }

            $nmfile    = $this->_Snippets_['modul'];
            $sts_cetak = $this->cetak->cetak_pdf_satu($data, $this->tmp_data['title'], $nmfile, array(), $arr_title, true, $this->tmp_data['fields']);
        }

    }

    public function __cetak()
    {
        $rows = $this->crud->get_all_data($this->tmp_data, $this->post, $this->_Snippets_, $x = array(), true);

        if (method_exists($this->router->fetch_class(), 'PRINT_ALL_CUSTOM')) {
            $this->PRINT_ALL_CUSTOM($rows['fields']);
            exit();
        }

        $this->load->library('cetak');

        $label_id = 'l_id';
        foreach ($this->tmp_data['fields'] as $key2 => $fld) {
            if ($fld['field'] == $this->tmp_data['primary']['id']) {
                if (array_key_exists('label', $fld)) {
                    $label_id = $fld['label'];
                } else {
                    $label_id = 'l_' . $fld['field'];
                }

                break;
            }
        }

        $arr_id = array();
        foreach ($rows['fields'] as $row) {
            $arr_id[] = $row[$label_id];
        }

        if (method_exists($this->router->fetch_class(), 'MASTER_DATA_LIST')) {
            $this->MASTER_DATA_LIST($arr_id, $rows);
        }

        foreach ($this->tmp_data['fields'] as $field) {
            $method_name_cetak = 'PrintBox_' . strtoupper($field['field']);
            $method_name       = 'listBox_' . strtoupper($field['field']);
            if (method_exists($this->router->fetch_class(), $method_name_cetak)) {
                if (array_key_exists('label', $field)) {
                    $label = $field['label'];
                } else { $label = 'l_' . $field['field'];}
                foreach ($rows['fields'] as &$row) {
                    $isi = '';
                    if (array_key_exists('input', $field)) {
                        if ($field['input']['type'] !== 'free') {
                            $isi = $row[$label];
                        }

                    }
                    $row[$label] = $this->$method_name_cetak($row, $isi);
                }
                unset($row);
            } else if (method_exists($this->router->fetch_class(), $method_name)) {
                if (array_key_exists('label', $field)) {
                    $label = $field['label'];
                } else { $label = 'l_' . $field['field'];}
                foreach ($rows['fields'] as &$row) {
                    $isi = '';
                    if (array_key_exists('input', $field)) {
                        if ($field['input']['type'] !== 'free') {
                            $isi = $row[$label];
                        }

                    }
                    $row[$label] = $this->$method_name($row, $isi, $_GET['tipe']);
                }
                unset($row);
            }
        }

        $arr_title = array();
        foreach ($this->tmp_data['title'] as $key => $field) {
            $show = true;
            if (array_key_exists(6, $field)) {
                $show = $field[6];
            }

            if ($show) {
                $arr_title[] = $field;
            }

            $jdl = lang('msg_field_' . $field[1]);
            if (!empty($field[2])) {
                $this->tmp_data['title'][$key]['judul'] = $field[2];
            } elseif (!empty($jdl)) {
                $this->tmp_data['title'][$key]['judul'] = $jdl;
            } else {
                $this->tmp_data['title'][$key]['judul'] = $field[1];
            }

        }
        // Doi::dump($arr_title);
        // die();
        $format = array('size' => array(21, 47, 16, 12, 14, 15));
        if (method_exists($this->router->fetch_class(), 'PrintBox_FORMAT')) {
            $format = $this->PrintBox_FORMAT();
        }

        $nmfile = $this->_Snippets_['modul'];
        if (method_exists($this->router->fetch_class(), 'PRINT_MANUAL')) {
            $this->PRINT_MANUAL($rows, $_GET['tipe']);
            $sts_cetak = true;
        } else {
            switch ($_GET['tipe']) {
                case "pdf":
                    $sts_cetak = $this->cetak->cetak_pdf($rows, $this->tmp_data['title'], $nmfile, $format, $arr_title);
                    break;
                case "excel":
                    $sts_cetak = $this->cetak->cetak_excel($rows, $arr_title, $nmfile, $format, $arr_title);
                    break;
                case "word":
                    $sts_cetak = $this->cetak->cetak_word($rows, $this->tmp_data['title'], $nmfile, $format, $arr_title);
                    break;
                case "email":
                    $sts_cetak = $this->cetak->kirim_email($rows, $this->tmp_data, $nmfile, $format, $arr_title);
                    break;
            }
        }
        if (!$sts_cetak) {
            $this->session->set_flashdata('err_desc', 'Function Cetak ' . $_GET['tipe'] . ' tidak ada');
            header('location:' . base_url('error'));
        }
    }

    public function _set_pesan($pesan = '')
    {
        if (!empty($pesan)) {
            $this->_pesan_error[] = $pesan;
        }

    }

    public function _get_pesan()
    {
        $msg = '';
        if (count($this->_pesan_error) > 0) {
            $msg = implode('<br>', $this->_pesan_error);
        }
        return $msg;
    }

    public function listBox_AKTIF($row, $value)
    {
        if ($value == '1') {
            $result = '<span class="label label-primary"> ' . lang('msg_cbo_yes') . '</span>';
        } else {
            $result = '<span class="label label-danger"> ' . lang('msg_cbo_no') . '</span>';
        }

        return $result;
    }

    public function listBox_STATUS($row, $value)
    {
        if ($value == '1') {
            $result = '<span class="label label-primary"> ' . lang('msg_cbo_yes') . '</span>';
        } else {
            $result = '<span class="label label-danger"> ' . lang('msg_cbo_no') . '</span>';
        }

        return $result;
    }

    public function listBox_SORT($row, $value)
    {
        $result = '<span class="label label-success"> ' . $value . '</span>';

        return $result;
    }

    public function printBox_AKTIF($row, $value)
    {
        if ($value == 'Y') {
            $result = lang('msg_cbo_yes');
        } else {
            $result = lang('msg_cbo_no');
        }

        return $result;
    }

    public function get_combo($kel, $param = array())
    {
        // Doi::dump($kel);
        // Doi::dump($param);
        $result = $this->data->get_combo_model($kel, $param);
        return $result;
    }

    public function get_combo_no_select($kel, $param = array())
    {
        $result = $this->data->get_combo_model($kel, $param);
        unset($result[0]);
        return $result;
    }

    public function index_default()
    {
        $this->data_fields['dat_edit']['fields'] = $this->post;
        $this->data_fields['search']             = $this->load->view('statis/tmp_search', $this->data_fields, true);
        $this->_param_list_['content']           = $this->load->view('statis/tmp_table', $this->data_fields, true);
        $this->template->build('statis/table', $this->_param_list_);
    }

    public function _SET_PRIVILEGE($type, $value)
    {
        $this->data_fields['privilege'][$type] = $value;
        // Doi::dump($this->data_fields['privilege'],false,true);
    }

    public function _SET_TOMBOL_ATTRIBUTE($type, $att, $value)
    {
        $this->_tombol['input'][$type][$att] = $value;
    }

    public function _SET_ACTION_WIDTH($key = '', $value = 10)
    {
        // die("Nilainya  : " . $value);
        $this->tmp_data['action_width'][$key] = $value;
    }

    public function __search_Combo_Custom($fields, $post, $combo = array(), $type = 'combo')
    {
        $name = 'q_' . $fields['field'];
        if (array_key_exists('label', $fields)) {
            $label = 'q_' . $fields['label'];
        } else {
            $label = 'q_' . $fields['field'];
        }

        $isi = 0;
        if (is_array($post)) {
            if (array_key_exists($name, $post)) {
                $isi = $post[$name];
            }

        }
        if ($type == 'combo') {
            $content = form_dropdown($name, $combo, $isi, "class='form-control wauto' style='width:350px;' id='" . $label . "'  ");
            if (array_key_exists($isi, $combo)) {
                $isi = $combo[$isi];
            }

        } elseif ($type == 'string' || $type == 'text') {

        }

        $this->__Set_value_Search($name, $isi);

        return $content;
    }

    public function set_Label($value)
    {
        if (empty($value)) {
            $value = 'FALSE';
        }

        if ($value == 'FALSE') {
            $label = 'danger';
        } elseif ($value == 'TRUE') {
            $label = 'primary';
        } else {
            $label = 'default';
        }
        return _label($value, $label);
    }

    public function del_Child()
    {
        $result    = array('sts' => 0, "ket" => "gagal proses");
        $kel       = $this->input->post('kel');
        $id        = $this->input->post('iddel');
        $nm_method = "subDelete_PROCESSOR";
        if (!empty($kel)) {
            $nm_method .= "_" . strtoupper($kel);
        }

        if (method_exists($this->router->fetch_class(), $nm_method)) {
            $result = $this->$nm_method($id);
        } else {
            $result = $this->data->delete_data_child($id, $this->tbl_master_child);
        }

        echo json_encode($result);
    }

    public function addField($data = array())
    {

        $tmp_data = $this->addField_tmp($data);
        $field    = "";
        if (array_key_exists('field', $data)) {
            $field = $data['field'];
        }

        $this->tmp_data['fields'][] = $tmp_data;

        if ($this->sts_open_tab) {
            $this->tmp_data['tabs'][$this->jml_tabs]['field'][] = $field;
        }
    }

    public function addField_tmp($data = array())
    {

        $nmtbl = $this->tbl_master;
        if (array_key_exists('nmtbl', $data)) {
            $nmtbl = $data['nmtbl'];
        }

        $tmp_data['nmtbl'] = $nmtbl;

        $field = "";
        if (array_key_exists('field', $data)) {
            $field = $data['field'];
        }

        $tmp_data['field'] = $field;

        $title = lang('msg_field_' . $data['field'] . '_' . strtolower(_MODULE_NAME_));
        if (empty($title)) {
            $title = lang('msg_field_' . $data['field']);
        }

        if (empty($title)) {
            if (!array_key_exists('title', $data)) {
                $title = ucwords(str_replace('_', ' ', $data['field']));
            } else {
                $title = $data['title'];
            }
        }
        $tmp_data['title'] = $title;

        if (defined(strtoupper('_' . $nmtbl . '_' . $field . '_'))) {
            define(strtoupper('_' . $nmtbl . '_' . $field . '_2'), $title);
        } else {
            define(strtoupper('_' . $nmtbl . '_' . $field . '_'), $title);
        }

        if (array_key_exists('input', $data)) {
            $tmp_data['input']['input'] = $data['input'];
        }
        $type = "string";
        if (array_key_exists('type', $data)) {
            $type = $data['type'];
            if ($type == 'int') {
                $tmp_data['input']['input'] = 'int';
            } elseif ($type == 'date') {
                $tmp_data['input']['input'] = 'date';
            }
        } elseif (array_key_exists('input', $data)) {
            if ($data['input'] == 'combo') {
                $type = "int";
            }
        }

        $tmp_data['input']['type'] = $type;
        if (!array_key_exists('input', $tmp_data['input'])) {
            $input = "text";
            if (array_key_exists('input', $data)) {
                $input = $data['input'];
            }
            $tmp_data['input']['input'] = $input;
        } else {
            if (array_key_exists('input', $data)) {
                if ($data['input'] == 'updown' || $data['input'] == 'combo' || $data['input'] == 'combo:search' || $data['input'] == 'boolean' || $data['input'] == 'boolean:num') {
                    $input                      = $data['input'];
                    $tmp_data['input']['input'] = $input;
                    if ($data['input'] == 'boolean' && _MODE_ == 'add') {
                        $tmp_data['input']['default'] = '1';
                    } elseif ($data['input'] == 'boolean:string' && _MODE_ == 'add') {
                        $tmp_data['input']['default'] = 'Y';
                    }
                }
            }
        }
        if (array_key_exists('combo', $data)) {
            $tmp_data['input']['combo'] = $data['combo'];
        }

        if (array_key_exists('default', $data)) {
            $tmp_data['input']['default'] = $data['default'];
        }

        $decimal = true;
        if (array_key_exists('decimal', $data)) {
            $decimal = $data['decimal'];
        }

        $tmp_data['decimal'] = $decimal;
        $show                = true;
        if (array_key_exists('show', $data)) {
            $show = $data['show'];
        }

        $tmp_data['show'] = $show;
        if ($show) {
            $tmp_data['save'] = true;
        } else {
            $tmp_data['save'] = false;
        }

        if (array_key_exists('save', $data)) {
            $tmp_data['save'] = $data['save'];
        }

        if (array_key_exists('multiselect', $data)) {
            $tmp_data['multiselect'] = $data['multiselect'];
        }

        $mode = 'a';
        if (array_key_exists('mode', $data)) {
            $mode = $data['mode'];
        }

        $tmp_data['input']['mode'] = $mode;

        $vertical = false;
        if (array_key_exists('vertical', $data)) {
            $vertical = $data['vertical'];
        }

        $tmp_data['vertical'] = $vertical;

        $inline = false;
        if (array_key_exists('inline', $data)) {
            $inline = $data['inline'];
        }

        $tmp_data['inline'] = $inline;

        $hide = false;
        if (array_key_exists('hide', $data)) {
            $hide = $data['hide'];
        }

        $tmp_data['hide'] = $hide;

        $required = false;
        if (array_key_exists('required', $data)) {
            $required = $data['required'];
        }

        $tmp_data['required'] = $required;

        $path = 'upload';
        if (array_key_exists('path', $data)) {
            $path = $data['path'];
        }

        $tmp_data['path'] = $path;

        $file_type = 'gif|jpg|png';
        if (array_key_exists('file_type', $data)) {
            $file_type = $data['file_type'];
        }

        $tmp_data['file_type'] = $file_type;

        $file_thumb = false;
        if (array_key_exists('file_thumb', $data)) {
            $file_thumb = $data['file_thumb'];
        }

        $tmp_data['file_thumb'] = $file_thumb;

        $file_size = '1000000';
        if (array_key_exists('file_size', $data)) {
            $file_size = $data['file_size'];
        }

        $tmp_data['file_size'] = $file_size;

        $file_random = true;
        if (array_key_exists('file_random', $data)) {
            $file_random = $data['file_random'];
        }

        $tmp_data['file_random'] = $file_random;

        $search = false;
        if (array_key_exists('search', $data)) {
            $search = $data['search'];
        }

        $tmp_data['search'] = $search;

        $help = true;
        if (array_key_exists('help', $data)) {
            $help = $data['help'];
        }

        $tmp_data['help'] = $help;

        $size = 20;
        if (array_key_exists('size', $data)) {
            $size = $data['size'];
        }

        $tmp_data['size'] = $size;

        $label = 'l_' . $data['field'];
        if (array_key_exists('label', $data)) {
            $label = $data['label'];
        }

        $tmp_data['label'] = $label;

        return $tmp_data;
    }

    public function set_Tbl_Master($tbl, $db = "", $prefix = true)
    {
        if (empty($db)) {$db = $this->db->database;}

        $tbl = str_replace($this->db->dbprefix, '', $tbl);

        if ($prefix) {
            $this->tbl_master = $db . '.' . $this->db->dbprefix($tbl);
        } else {
            $this->tbl_master = $db . '.' . $tbl;
        }

        $this->set_Attr_Table('size', '100%');
    }

    public function set_Tbl_Master_Child($tbl)
    {
        $tbl                    = str_replace($this->db->dbprefix, '', $tbl);
        $this->tbl_master_child = $this->db->dbprefix($tbl);
    }

    public function set_Table($tbl)
    {
        $tblx         = str_replace($this->db->dbprefix, '', $tbl);
        $tbl_x        = 'tbl_' . $tblx;
        $this->$tbl_x = $this->db->dbprefix($tblx);
    }

    public function set_Field_Primary($field, $info = true)
    {
        $this->tmp_data['primary'] = array('tbl' => $this->tbl_master, 'id' => $field, 'info' => $info);
    }

    public function set_Close_Setting()
    {
        $this->data_fields['master'] = $this->tmp_data;
    }

    public function set_Attr_Table($attr, $nilai, $type = "style")
    {
        $this->tmp_data['attrTable'][$attr] = $nilai;
    }

    public function set_Join_Table($data = array())
    {
        $arr_tmp['master'] = 1;
        $arr_tmp['pk']     = $data['pk'];
        if (array_key_exists('id_pk', $data)) {
            $arr_tmp['id_pk'] = $data['id_pk'];
        }

        if (array_key_exists('sp', $data)) {
            $arr_tmp['sp'] = $data['sp'];
        }

        if (array_key_exists('id_sp', $data)) {
            $arr_tmp['id_sp'] = $data['id_sp'];
        }

        if (array_key_exists('type', $data)) {
            $arr_tmp['type'] = $data['type'];
        }

        $this->tmp_data['m_tbl'][] = $arr_tmp;
    }

    public function set_Sort_Table($nmtbl, $field, $type = 'asc')
    {
        $this->tmp_data['sort'][] = array('tbl' => $nmtbl, 'id' => $field, 'type' => $type);
    }

    public function set_Where_Table($nmtbl, $field, $op = '=', $value = '')
    {
        $this->tmp_data['where'][] = array('tbl' => $nmtbl, 'id' => $field, 'op' => $op, 'value' => $value);
    }

    public function addDontUpdateField($nmtbl, $field)
    {
        $this->tmp_data['dontupdate'][] = array($nmtbl, $field);
    }

    public function addDontInsertField($nmtbl, $field)
    {
        $this->tmp_data['dontinsert'][] = array($nmtbl, $field);
    }

    public function set_Open_Tab($title, $icon = "list")
    {
        $this->sts_open_tab = true;
        // $this->arr_header_tab=array('title'=>$title,'id'=>'tab-01', 'icon'=>$icon);
        $this->jml_tabs                          = count($this->tmp_data['tabs']);
        $this->tmp_data['tabs'][$this->jml_tabs] = array('title' => $title, 'id' => 'tab-0' . count($this->tmp_data['tabs']), 'icon' => $icon);
    }

    public function set_Close_Tab()
    {
        $this->sts_open_tab = false;
    }

    public function set_Bid($data = array())
    {
        $sts_access       = true;
        $arr_tmp['nmtbl'] = $data['nmtbl'];
        $arr_tmp['field'] = $data['field'];
        if (array_key_exists('span_left_addon', $data)) {
            $arr_tmp['span_left_addon'] = $data['span_left_addon'];
        }

        if (array_key_exists('span_right_addon', $data)) {
            $arr_tmp['span_right_addon'] = $data['span_right_addon'];
        }

        if (array_key_exists('readonly', $data)) {
            $arr_tmp['readonly'] = $data['readonly'];
        }

        if (array_key_exists('btn_add', $data)) {
            $arr_tmp['btn_add'] = $data['btn_add'];
            if (array_key_exists('modul', $data)) {
                $sts_access = $this->authentication->get_Privilege($data['modul'], 'add');
            }
        }
        if (array_key_exists('target', $data)) {
            $arr_tmp['target'] = $data['target'];
        }

        if (array_key_exists('fld', $data)) {
            $arr_tmp['fld'] = $data['fld'];
        }

        if (array_key_exists('align', $data)) {
            $arr_tmp['align'] = $data['align'];
        }

        if (array_key_exists('group', $data)) {
            $arr_tmp['group'] = $data['group'];
        }

        if (array_key_exists('upper', $data)) {
            $arr_tmp['upper'] = $data['upper'];
        }

        if (array_key_exists('inline', $data)) {
            $arr_tmp['inline'] = $data['inline'];
        }

        if (array_key_exists('disabled', $data)) {
            if ($data['disabled']) {
                $arr_tmp['disabled'] = $data['disabled'];
            }

        }
        if ($sts_access) {
            $this->tmp_data['bind'][] = $arr_tmp;
        }

    }

    public function set_Accordion($data = array())
    {
        $arr_tmp['nmtbl'] = $this->tbl_master;
        if (array_key_exists('nmtbl', $data)) {
            $arr_tmp['nmtbl'] = $data['nmtbl'];
        }

        $arr_tmp['field'] = $data['field'];
        if (array_key_exists('label', $data)) {
            $arr_tmp['label'] = $data['label'];
        }

        $level = 0;
        if (array_key_exists('level', $data)) {
            $level = $data['level'];
        }

        $arr_tmp['level'] = $level;

        if (array_key_exists('icon', $data)) {
            $icon = $data['icon'];
        } else {
            if ($level == 0) {
                $icon = '<i class="fa fa-folder"></i> ';
            } elseif ($level == 1) {
                $icon = '<i class="fa fa-list"></i> ';
            } elseif ($level == 2) {
                $icon = '<i class="fa fa-plus"></i> ';
            }
        }
        $arr_tmp['icon'] = $icon;

        $class = 'pointer';
        if (array_key_exists('class', $data)) {
            $class .= ' ' . $data['class'];
        }

        if (array_key_exists('bg', $data)) {
            $class .= ' ' . $data['bg'];
        } else {
            $class .= ' bg-green';
        }

        $arr_tmp['class'] = $class;

        if (array_key_exists('sub-title', $data)) {
            $arr_tmp['sub-title'] = $data['sub-title'];
        }

        $this->tmp_data['accordion'][] = $arr_tmp;
    }

    public function set_Table_List($nmtbl, $field, $title = '', $size = 0, $align = 'left', $show = true, $print = true)
    {
        if (empty($title)) {
            if (defined(strtoupper('_' . $nmtbl . '_' . $field . '_'))) {
                $title = constant(strtoupper('_' . $nmtbl . '_' . $field . '_'));
            }
        }
        $this->tmp_data['title'][] = array($nmtbl, $field, $title, $size, $align, $show, $print);
    }

    public function _set_ACTION($ket = 'view')
    {
        $this->mode_action = $ket;
    }

    public function _DONT_UPDATE()
    {
        $this->_STS_UPDATE = false;
    }

    public function _DONT_INSERT()
    {
        $this->_STS_INSERT = false;
    }

    public function _CHANGE_TABLE_MASTER($tbl)
    {
        $this->tbl_simpan = $tbl;
    }

    public function _get_list_action_button($id = 0)
    {
        $optional_cmd = array();
        if (method_exists($this->router->fetch_class(), 'update_OPTIONAL_CMD')) {$optional_cmd = $this->update_OPTIONAL_CMD($id);}

        $action    = $this->_tombol['input'];
        $privilege = $this->data_fields['privilege'];
        $tombol    = '';
        $tbl_tml   = '';
        foreach ($action as $key => $tbl) {
            if (is_array($tbl)) {
                $tbl_tml = $tbl['tbl_open'] . $tbl['icon'] . $tbl['label'] . $tbl['tbl_close'];
            } else {
                $tbl_tml = $tbl;
            }
            if ($key == 'save' && ($privilege['add'] == '1' || $privilege['edit'] == '1') && $privilege['tombol_save']) {
                $tombol .= $tbl_tml . "&nbsp;&nbsp;";
            } elseif ($key == 'savequit' && ($privilege['add'] == '1' || $privilege['edit'] == '1') && $privilege['tombol_save_quit']) {
                $tombol .= $tbl_tml . "&nbsp;&nbsp;";
            } elseif ($key == 'add_input' && $privilege['add'] == '1' && $privilege['tombol_add']) {
                $tombol .= $tbl_tml . "";
            } elseif ($key == 'quit' && $privilege['tombol_quit']) {
                $tombol .= $tbl_tml . "&nbsp;&nbsp;";
            }

        }

        if ($optional_cmd) {
            $tombol .= '<span class="pull-right">';
            foreach ($optional_cmd as $key => $tbl) {
                $tombol .= $tbl . "&nbsp;&nbsp;";
            }
            $tombol .= '</span>';
        }

        return $tombol;
    }

    public function SET_PARAM_($nama, $value)
    {
        $this->_param_list_[$nama] = $value;
    }

    public function _SET_LOG_($value = false)
    {
        $this->save_log = $value;
    }

    public function add_Box_Input($type = "text", $row = array(), $isi = "")
    {
        $required            = "";
        $help                = "";
        $span_help           = "";
        $style               = "";
        $onClick             = "";
        $onChange            = "";
        $class_upper         = "";
        $mode                = 'a';
        $error               = "";
        $placeholder         = '';
        $disabled            = '';
        $align               = 'text-left';
        $typeahead           = '';
        $readOnly            = '';
        $span_start          = '';
        $span_end            = '';
        $span_left_addon     = '';
        $span_right_addon    = '';
        $span_right          = '';
        $span_left           = '';
        $btn_add             = '';
        $group               = "";
        $content             = '';
        $width               = "20%";
        $width_multi         = "510px";
        $btn_label_accordion = '';
        $autofocus           = '';

        if (array_key_exists('align', $row['input'])) {
            $align = 'text-' . $row['input']['align'];
        } else {
            switch ($type) {
                case 'int':
                case 'integer':
                case 'intdot':
                case 'integerdot':
                case 'float':
                    $align = 'text-right';
                    break;
                default:
                    $align = 'text-left';
                    break;
            }
        }

        if (array_key_exists('label', $row)) {
            $label = $row['label'];
        } else {
            $label = 'l_' . $row['field'];
        }

        if (array_key_exists('bind', $this->tmp_data)) {
            foreach ($this->tmp_data['bind'] as $bd) {
                if ($bd['nmtbl'] == $row['nmtbl'] && $bd['field'] == $row['field']) {
                    if (array_key_exists('style', $bd)) {$style = $bd['style'];}
                    if (array_key_exists('onClick', $bd)) {$onClick = 'onClick="' . $bd['onClick'] . '"';}
                    if (array_key_exists('onChange', $bd)) {$onChange = 'onChange="' . $bd['onChange'] . '"';}
                    if (array_key_exists('value', $bd) && $aksi == 'add') {$isi = $bd['value'];}
                    if (array_key_exists('span_left_addon', $bd)) {
                        $span_left_addon = '<span id="span_' . $label . '" class="input-group-addon">' . $bd['span_left_addon'] . ' ' . $help . '</span>';
                        $help            = '';}
                    if (array_key_exists('span_right_addon', $bd)) {$span_right_addon = '<span  id="span_' . $label . '" class="input-group-addon">' . $bd['span_right_addon'] . '</span>';}
                    if (array_key_exists('span_help', $bd)) {$span_help = '<span class="help-block">' . $bd['span_help'] . '</span>';}
                    if (array_key_exists('span_left', $bd)) {$span_left = $bd['span_left'];}
                    if (array_key_exists('span_right', $bd)) {$span_right = $bd['span_right'];}
                    if (array_key_exists('align', $bd)) {$align = 'text-' . $bd['align'];}
                    if (array_key_exists('readonly', $bd)) {$readOnly = 'readonly=""';}
                    if (array_key_exists('disabled', $bd)) {$disabled = 'disabled="disabled"';}
                    if (array_key_exists('group', $bd)) {$group = "input-group";}
                    if (array_key_exists('upper', $bd)) {$class_upper = "text-upper";}
                    if (array_key_exists('btn_add', $bd)) {$btn_add = '<span class="btn btn-flat btn-small btn-default btn-add" data-target="' . $bd['target'] . '" data-combo="' . $label . '" data-label="' . $msg_title . '">' . lang('msg_tombol_add_list') . ' ' . $msg_title . '</span>';}

                    break;
                }
            }
        }

        if (array_key_exists('placeholder', $row['input'])) {
            $placeholder = 'placeholder="' . $row['input']['placeholder'] . '"';
        }

        if (array_key_exists('disabled', $row['input'])) {
            $disabled = 'disabled="disabled"';
        }

        if ($row['input']['input'] == 'text_auto') {
            $typeahead = 'typeahead';
        }

        if (_MODE_ == 'view') {
            $disabled = ' disabled="disabled" ';
        }

        $content = "";

        switch ($type) {
            case "manual_input":
                $content = $manual_input;
                break;
            case 'string':
            case 'text':
                $content = $span_start;
                $content .= form_input($label, $isi, " size=$row[size] class='form-control $error $align $typeahead $class_upper' $onChange $disabled $readOnly $placeholder id=$label $autofocus ");
                if (!empty($disabled)) {
                    $content .= form_hidden($label, $isi);
                }
                $content .= $span_end;
                break;
            case 'text_tags':
                $content = $span_start;
                $content .= form_input($label, $isi, " size=$row[size] class='form-control $error $align' $disabled data-role='tagsinput' $placeholder id=$label $autofocus ");
                if (!empty($disabled)) {
                    $content .= form_hidden($label, $isi);
                }
                $content .= $span_end;
                break;
            case 'multitext':
            case 'multitext:sms':
                $jmlhuruf = intval($row['size']) - intval(strlen($isi));
                ++$this->i_left;
                $left    = 'id_sisa_' . $this->i_left;
                $content = form_textarea($label, $isi, " id='$label' maxlength='$row[size]' size=$row[size] $disabled class='form-control $error $align' rows='2' cols='5' style='overflow: hidden; width: $width_multi !important; height: 104px;'  onblur='_maxLength(this , \"$left\")' onkeyup='_maxLength(this , \"$left\")' data-role='tagsinput' $autofocus ");
                if (!empty($disabled)) {
                    $content .= form_hidden($label, $isi);
                }

                $content .= '<br/><span class="text-info">' . lang('msg_chr_left') . ' </span><span style="padding-top:3px;display:inline-block;height:20px;"><input id="' . $left . '" type="hidden" align="right" class="form-control" style="text-align:right;width:60px;" disabled="" name="f1_11_char_left" value="' . $jmlhuruf . '" size="5"><span id="span_' . $left . '"  align="right" class="badge badge-warning text-white" name="f1_11_char_left">' . $jmlhuruf . '</span></span>';
                break;
            case 'html':
                $content = $span_start;
                $content .= "<textarea name='$label'  id='editor1' class='form-control p100' rows='10' $autofocus>$isi</textarea>";
                if (!empty($disabled)) {
                    $content .= form_hidden($label, $isi);
                }

                $content .= $span_end;
                break;
            case 'pass':
                $id_pass     = 'password' . ++$nopass;
                $result_pass = "result" . $nopass;
                $content     = form_password($label, '', " size=$row[size] $disabled class='form-control $error $align' autocomplete='off' id='$id_pass' $autofocus ");
                if (!empty($disabled)) {
                    $content .= form_hidden($label, '');
                }

                $content .= " &nbsp;<span id='$result_pass'></span>";
                break;
            case 'int':
            case 'integer':
                $content = form_input($label, $isi, " class='form-control numeric $error $align'  $disabled size=$row[size] $onChange id=$label $autofocus ");
                if (!empty($disabled)) {
                    $content .= form_hidden($label, $isi);
                }

                break;
            case 'float':
                $isi     = number_format(str_replace(',', '', floatval($isi)));
                $content = form_input($label, $isi, " class='form-control numeric rupiah $error $align'  $disabled size=$row[size] $onChange id=$label $autofocus ");
                if (!empty($disabled)) {
                    $content .= form_hidden($label, $isi);
                }

                break;
            case 'intdot':
            case 'integerdot':
                $content = form_input($label, $isi, " class='form-control numericdot $error $align'  $disabled size=$row[size] $onChange id=$label $autofocus ");
                if (!empty($disabled)) {
                    $content .= form_hidden($label, $isi);
                }

                break;
            case 'updown':
                if (empty($isi)) {
                    $isi = 0;
                }
                $content = form_input(array('type' => 'number', 'name' => $label), $isi, " $disabled class='form-control numeric $error $align' size=$row[size] style='width:$row[size]px !important;' id=$label $autofocus ");
                if (!empty($disabled)) {
                    $content .= form_hidden($label, $isi);
                }

                break;
            case 'color':
                $content = form_input(array('type' => 'text', 'name' => $label), $isi, " $disabled class='$error colorpicker-default form-control' size=$row[size] style='height:30px;width:80px;background-color:$isi;' id=$label $autofocus ");
                if (!empty($disabled)) {
                    $content .= form_hidden($label, $isi);
                }

                break;
            case 'boolean:num':
                $content = form_dropdown($label, array('' => '-', '0' => lang('msg_cbo_no'), '1' => lang('msg_cbo_yes')), $isi, "id=$label $disabled style='height:30px;width:60px' class='form-control' $autofocus ");
                if (!empty($disabled)) {
                    $content .= form_hidden($label, $isi);
                }

            case 'boolean':
                $content = form_dropdown($label, array('' => '-', 'N' => lang('msg_cbo_no'), 'Y' => lang('msg_cbo_yes')), $isi, "id=$label $disabled style='height:30px;width:60px' class='form-control' $autofocus ");
                if (!empty($disabled)) {
                    $content .= form_hidden($label, $isi);
                }

                break;
            case 'combo':
                // $size=$row['size'].'px';
                $size = 'auto';
                if ($row['size'] == 100) {
                    $size = '100%';
                } elseif ($row['size'] == 0) {
                    $size = 'auto';
                }
                $content = '<div id="loadingmessage" class="waitting" style="display: none;"></div>';
                $content .= form_dropdown($label, $row['input']['combo'], $isi, "id=$label $disabled class='$error form-control' style='$style width:$size  !important;' $onChange $autofocus $readOnly ");
                if (!empty($disabled)) {
                    $content .= form_hidden($label, $isi);
                }

                break;

            case 'combo:search':
                $multi = '';
                // $size = $row['size'] . 'px'[]
                $size = $row['size'] * 5;
                $size .= 'px';
                if (array_key_exists('multiselect', $row)) {
                    $size  = '100%';
                    $multi = ' multiple="multiple" ';
                    $label = $label . '[]';
                    if (!is_array($isi)) {
                        $isi = explode(',', $isi);
                    }

                } elseif ($row['size'] == 100) {
                    $size = '100% !important';
                }
                // Doi::dump($row);
                // die("kesini");

                $content = form_dropdown($label, $row['input']['combo'], $isi, "id=$label $disabled class='$error form-control select2' style='$style width:$size;' $onChange $autofocus $multi ");
                if (!empty($disabled)) {
                    $content .= form_hidden($label, $isi);
                }

                break;
            case 'tags':
                $content = form_input($label, $isi, " id=$label size=$row[size] class='form-control $error $align tokenfield' $disabled $autofocus ");
                if (!empty($disabled)) {
                    $content .= form_hidden($label, $isi);
                }

                break;
                if (!empty($disabled)) {
                    $content .= form_hidden($label, $isi);
                }

                break;

            case 'date':
                ++$nodate;
                $tgl = date('d-m-Y');
                if (!empty($isi)) {
                    if ($isi == '01-01-1970') {
                        $isi = date('d-m-Y');
                    } else {
                        $isi = date('d-m-Y', strtotime($isi));
                    }

                }
                $content = form_input($label, $isi, " id=$label size=$row[size] class='form-control $error datepicker' $disabled style='width:130px;' $autofocus ");
                if (!empty($disabled)) {
                    $content .= form_hidden($label, $isi);
                }

                break;

            case 'datetime':
                ++$nodate;
                $tgl = date('d-m-Y');
                if (!empty($isi)) {
                    $tgl = date('d-m-Y', strtotime($isi));
                }

                $content = form_input($label, $isi, " id=$label size=$row[size] class='form-control $error datetimepicker' $disabled style='width:130px;' $autofocus ");
                if (!empty($disabled)) {
                    $content .= form_hidden($label, $isi);
                }

                break;
            case 'upload':
                $content = '';
                if (!empty($isi)) {
                    $content = '<span class="well">' . $isi . '</span><br/>';
                }
                $content .= form_upload($label);
                break;
            case 'free':
                if (array_key_exists('value', $row['input'])) {
                    $content = $row['input']['value'];
                } else {
                    $content = form_input($label, $isi, " size=$row[size] class='form-control $error $align $typeahead $class_upper' $onChange $disabled $readOnly $placeholder id=$label $autofocus ");
                }
                break;
        }
        return $content;
    }

    public function _CHECK_PRIVILEGE_($aksi = 'add', $modul = '')
    {
        if (empty($modul)) {
            $modul = $this->_Snippets_['modul'];
        }

        $privilege = $this->authentication->get_Privilege($modul, $aksi);
        return $privilege;
    }

    public function insertBox_USED($field)
    {
        $result = '<span class="label label-warning"> E M P T Y </span>';
        return $result;
    }

    public function save_Activity()
    {
        $id = "";
        if ($this->authentication->is_loggedin()) {
            if ($this->uri->segment(1) !== 'themes') {
                $id                        = $this->authentication->get_Info_User('identifier');
                $upd['session_id']         = session_id();
                $upd['last_visit']         = uri_string();
                $upd['last_activity_date'] = Doi::now();
                $no_inventori              = $this->crud->crud_data(array('table' => _TBL_USERS, 'field' => $upd, 'where' => array('id' => $id), 'type' => 'update', 'pesan' => false));
                $data['type']              = "view";
                save_log($data);
            }
        }
        define('_USER_NO_', $id);
        define('_USER_NAME_', $this->authentication->get_Info_User('username'));
        define('_USER_NAME_COMPLETE_', $this->authentication->get_Info_User('nama_lengkap'));
    }

    public function _getPrivilege($aksi = 'add')
    {
        $result = $this->authentication->get_Privilege($this->_Snippets_['modul'], $aksi);
        return $result;
    }

    public function _isAdmin()
    {
        $result = $this->authentication->is_admin();
        return $result;
    }

    public function set_Map($sts = true)
    {
        if ($sts) {
            $this->load->library('googlemaps');
            $this->addField(array('field' => 'lat', 'size' => 30));
            $this->addField(array('field' => 'lng', 'size' => 30));
            $this->addField(array('field' => 'peta', 'type' => 'free', 'input' => 'free', 'mode' => 'o', 'size' => 20));
            $this->set_Bid(array('nmtbl' => $this->tbl_master, 'field' => 'lat', 'readonly' => true));
            $this->set_Bid(array('nmtbl' => $this->tbl_master, 'field' => 'lng', 'readonly' => true));
        }
    }

    public function _CHECK_PRIVILEGE_OWNER($tbl = 'form_individu', $field = "owner_no")
    {
        $group = $this->authentication->get_Info_User('group');
        if ($group['privilege_owner']['id'] >= 2) {
            $this->set_Where_Table($tbl, $field, 'in', $group['owner_child']);
        }
    }

    public function insertBox_PETA($field)
    {
        $result = $this->data_peta();
        return $result;
    }

    public function updateBox_PETA($field, $row, $value)
    {
        $result = $this->data_peta($row);
        return $result;
    }

    public function data_peta($data = array())
    {
        $ada            = false;
        $config['zoom'] = '5';
        if (count($data) == 0) {
            $config['center'] = '-1.362176,117.817383';
        } elseif (floatval($data['l_lat']) == 0 || floatval($data['l_lng']) == 0) {
            $config['center'] = '-1.362176,117.817383';
        } else {
            $ada              = true;
            $config['center'] = $data['l_lat'] . ',' . $data['l_lng'];
            $config['zoom']   = '13';
        }

        $config['sensor']                      = true;
        $config['apiKey']                      = 'AIzaSyD-9SGqwku28lZF3C9wwwaD0JK2pUXPVwo';
        $config['disableMapTypeControl']       = true;
        $config['disableNavigationControl']    = true;
        $config['disableScaleControl']         = true;
        $config['disableStreetViewControl']    = true;
        $config['places']                      = true;
        $config['placesAutocompleteInputID']   = 'myPlaceTextBox';
        $config['placesAutocompleteBoundsMap'] = true; // set results biased towards the maps viewport
        $config['placesAutocompleteOnChange']  = "var place = placesAutocomplete.getPlace();
             if (place.geometry.viewport) {
                 map.fitBounds(place.geometry.viewport);
             } else {
                 map.setCenter(place.geometry.location);
                 map.setZoom(17);
             }";
        $config['onclick'] = 'clearOverlays();createMarker_map({ map: map, position:event.latLng });get_position_map(event.latLng.lat() ,event.latLng.lng());';
        $this->googlemaps->initialize($config);

        if ($ada) {
            $marker             = array();
            $marker['position'] = $data['l_lat'] . ',' . $data['l_lng'];
            $this->googlemaps->add_marker($marker);
        }
        $data['map'] = $this->googlemaps->create_map();

        $data['view_map'] = $this->load->view('statis/map', $data, true);
        return $data['view_map'];
    }

    public function get_csrf()
    {
        $error['csrf_name']  = $this->security->get_csrf_token_name();
        $error['csrf_token'] = $this->security->get_csrf_hash();
        echo json_encode($error);
        die();
    }

    public function GET_TOOLTIPS()
    {
        $this->_param_list_['tooltips'] = array();
        $rows                           = $this->db->where('nm_modul', strtolower(_MODULE_NAME_))->get(_TBL_MODUL)->row();
        if ($rows) {
            $id = $rows->id;
            if (_MODE_ == 'add') {
                $rows = $this->db->where('modul_no', $id)->where_in('aksi_no', array(0, 2, 3))->get(_TBL_TOOLTIPS)->result_array();
            } elseif (_MODE_ == 'edit') {
                $rows = $this->db->where('modul_no', $id)->where_in('aksi_no', array(0, 2, 4))->get(_TBL_TOOLTIPS)->result_array();
            } else {
                $rows = $this->db->where('modul_no', $id)->where_in('aksi_no', array(0, 1))->get(_TBL_TOOLTIPS)->result_array();
            }
            if ($rows) {
                foreach ($rows as $row) {
                    $this->_param_list_['tooltips'][] = $row['isi'];
                }
            }
            if (_MODE_ == 'add') {
                $rows = $this->db->where('modul_no', 0)->where_in('aksi_no', array(0, 2, 3))->get(_TBL_TOOLTIPS)->result_array();
            } elseif (_MODE_ == 'edit') {
                $rows = $this->db->where('modul_no', 0)->where_in('aksi_no', array(0, 2, 4))->get(_TBL_TOOLTIPS)->result_array();
            } else {
                $rows = $this->db->where('modul_no', 0)->where_in('aksi_no', array(0, 1))->get(_TBL_TOOLTIPS)->result_array();
            }
            if ($rows) {
                foreach ($rows as $row) {
                    $this->_param_list_['tooltips'][] = $row['isi'];
                }
            }
        }
    }
}
