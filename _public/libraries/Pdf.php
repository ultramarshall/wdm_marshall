<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class pdf {
 
    function pdf()
    {
        $CI = & get_instance();
        log_message('Debug', 'mPDF class is loaded.');
    }
 
    function load($param=NULL)
    {
		/** PHPExcel root directory */
		if (!defined('PDF_ROOT')) {
			define('PDF_ROOT', dirname(__FILE__) . '/');
			require(PDF_ROOT . 'mpdf60/mpdf.php');
		}
		
		// Doi::dump($param);die();
        // include_once APPPATH.'/libraries/mpdf/mpdf.php';
 
        if ($param == NULL)
        {
            $param = '"en-GB-x","legal","","",10,10,10,10,6,3';
        }
        return new mPDF($param);
    }
}