<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * MY_Log Class
 *
 * This library extends the native Log library.
 * It adds the function to have the log messages being emailed when they have
 * been outputted to the log file.
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Logging
 * @author      Johan Steen
 * @link        https://johansteen.se/
 */
class MY_Log extends CI_Log {
    /**
     * Constructor
     *
     * @access  public
     */
    function MY_Log()
    {
        parent::__construct();
		// $obj = & get_instance();
		// $CI->load->library('doi');
    }

    /**
     * Write Log File
     *
     * Calls the native write_log() method and then sends an email if a log
     * message was generated.
     *
     * @access  public
     * @param   string  the error level
     * @param   string  the error message
     * @param   bool    whether the error is a native PHP error
     * @return  bool
     */
    function write_log($level = 'error', $msg, $php_error = FALSE)
    {
        if (strtoupper($level) == 'ERROR') {
			$sql['message']=$msg;
			$sql['type']=$level;			
			$sql['priority']=1;
			$sql['priority_name']=$level;
			// show_404('error_404','Gagal');
			save_debug($sql);
			$result=false;
        }else{
			$result = parent::write_log($level, $msg);
        }
		return $result;
    }
}