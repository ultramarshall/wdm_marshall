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
class MY_Exceptions extends CI_Exceptions {
    /**
     * Constructor
     *
     * @access  public
     */
    function MY_Exceptions()
    {
        parent::__construct();
    }

   public function show_php_error($severity, $message, $filepath, $line)
	{
		// die("siapa ya");
		$templates_path = config_item('error_views_path');
		if (empty($templates_path))
		{
			$templates_path = VIEWPATH.'errors'.DIRECTORY_SEPARATOR;
		}

		$severity = isset($this->levels[$severity]) ? $this->levels[$severity] : $severity;

		// For safety reasons we don't show the full file path in non-CLI requests
		if ( ! is_cli())
		{
			$filepath = str_replace('\\', '/', $filepath);
			if (FALSE !== strpos($filepath, '/'))
			{
				$x = explode('/', $filepath);
				$filepath = $x[count($x)-2].'/'.end($x);
			}

			$template = 'html'.DIRECTORY_SEPARATOR.'error_php';
		}
		else
		{
			$template = 'cli'.DIRECTORY_SEPARATOR.'error_php';
		}

		if (ob_get_level() > $this->ob_level + 1)
		{
			ob_end_flush();
		}
		ob_start();
		require_once($templates_path.$template.'.php');
		$buffer = ob_get_contents();
		ob_end_clean();
		
		// $msg = 'Severity: '.$severity.'  --> '.$message. ' '.$filepath.' '.$line;
		
		$msg = '<p>PHP Error </p>';
		$msg .= $message . '<br/>';
		$msg .= 'severity : ' . $severity . '<br/>';
		$msg .= 'message : ' . $message . '<br/>';
		$msg .= 'filepath : ' . $filepath . '<br/>';
		$msg .= 'line : ' . $line . '<br/>';
		
		// echo $msg;
		
		$sql['message']=$msg;
		$sql['type']=$template;			
		$sql['priority']=1;
		$sql['priority_name']='A PHP Error was encountered';
		save_debug($sql);
		
		echo $buffer;
	}
	
	/**
	 * General Error Page
	 *
	 * Takes an error message as input (either as a string or an array)
	 * and displays it using the specified template.
	 *
	 * @param	string		$heading	Page heading
	 * @param	string|string[]	$message	Error message
	 * @param	string		$template	Template name
	 * @param 	int		$status_code	(default: 500)
	 *
	 * @return	string	Error page output
	 */
	public function show_error($heading, $message, $template = 'error_general', $status_code = 500)
	{
		
		$this->ci =& get_instance();
		$this->ci->db->trans_rollback();

		$error_heading=$template;
		$templates_path = config_item('error_views_path');
		if (empty($templates_path))
		{
			$templates_path = VIEWPATH.'errors'.DIRECTORY_SEPARATOR;
		}

		if (is_cli())
		{
			// $message = "\t".(is_array($message) ? implode("\n\t", $message) : $message);
			$template = 'cli'.DIRECTORY_SEPARATOR.$template;
		}
		else
		{
			set_status_header($status_code);
			// $message = '<p>'.(is_array($message) ? implode('</p><p>', $message) : $message).'</p>';
			$template = 'html'.DIRECTORY_SEPARATOR.$template;
		}

		if (ob_get_level() > $this->ob_level + 1)
		{
			ob_end_flush();
		}
		ob_start();
		include($templates_path.$template.'.php');
		$buffer = ob_get_contents();
		ob_end_clean();
		// $msg = $heading;
		// $msg .= $message;
		// $msg .= 'Page ' . current_url();
		
		$sql['message']=$msg;
		$sql['type']=$error_heading;			
		$sql['priority']=$status_code;
		$sql['priority_name']=$heading;
		save_debug($sql);
		
		echo $buffer;
	}
}