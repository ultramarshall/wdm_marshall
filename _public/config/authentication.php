<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * User table
 *
 * This table should contain the username and password fields specified below. It can contain any other fields, such as "first_name"
 */
$config['authentication']['user_table'] = 'users';


/**
 * User identifier field
 *
 * This field will usually be "id" or "user_id" but you could use something like "username"
 */
$config['authentication']['identifier_field'] = 'id';

$config['authentication']['menu']=array('header'=>'Header', 'footer'=>'footer', 'atas-kiri'=>'atas-kiri', 'atas-kanan'=>'atas-kanan', 'bawah-kiri'=>'bawah-kiri', 'bawah-kanan'=>'bawah-kanan', 'kiri'=>'kiri', 'kanan'=>'kanan', 'atas'=>'atas', 'bawah'=>'bawah');

/**
 * Username field
 *
 * This field can be named what ever you like, an example would be "email"
 */
$config['authentication']['username_field'] = 'username';
$config['authentication']['hp_field'] = 'hp';
$config['authentication']['email_field'] = 'email';

/**
 * Password field
 */
$config['authentication']['password_field'] = 'password';

/**
 * Save Log User
 */
$config['authentication']['save_log_user'] = TRUE;

$config['authentication']['buyer'] = 'guest';

/* End of file authentication.php */
/* Location: ./application/config/authentication.php */