<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Sekati CodeIgniter Asset Helper
 *
 * @package		Sekati
 * @author		Jason M Horwitz
 * @copyright	Copyright (c) 2013, Sekati LLC.
 * @license		http://www.opensource.org/licenses/mit-license.php
 * @link		http://sekati.com
 * @version		v1.2.7
 * @filesource
 *
 * @usage 		$autoload['config'] = array('asset');
 * 				$autoload['helper'] = array('asset');
 * @example		<img src="<?=asset_url();?>imgs/photo.jpg" />
 * @example		<?=img('photo.jpg')?>
 *
 * @install		Copy config/asset.php to your CI application/config directory
 *				& helpers/asset_helper.php to your application/helpers/ directory.
 * 				Then add both files as autoloads in application/autoload.php:
 *
 *				$autoload['config'] = array('asset');
 * 				$autoload['helper'] = array('asset');
 *
 *				Autoload CodeIgniter's url_helper in application/config/autoload.php:
 *				$autoload['helper'] = array('url');
 *
 * @notes		Organized assets in the top level of your CodeIgniter 2.x app:
 *					- assets/
 *						-- css/
 *						-- download/
 *						-- img/
 *						-- js/
 *						-- less/
 *						-- swf/
 *						-- upload/
 *						-- xml/
 *					- application/
 * 						-- config/asset.php
 * 						-- helpers/asset_helper.php
 */

// ------------------------------------------------------------------------
// URL HELPERS

/**
 * Get asset URL
 *
 * @access  public
 * @return  string
 */
if ( ! function_exists('asset_url'))
{
    function asset_url($value='')
    {
        //get an instance of CI so we can access our configuration
        $CI =& get_instance();
        //return the full asset path
        return base_url()  . 'themes/' .  $CI->config->item('theme') . '/' . $CI->config->item('asset_path') . $value;
    }
}

/**
 * Get css URL
 *
 * @access  public
 * @return  string
 */
if ( ! function_exists('css_url'))
{
    function css_url($value='')
    {
        $CI =& get_instance();
        return base_url() . 'themes/' . $CI->config->item('theme') . '/' . $CI->config->item('css_path') . $value;
    }
}



if ( ! function_exists('css_frontend_url'))
{
    function css_frontend_url($value='')
    {
        $CI =& get_instance();
        return base_url() . 'themes/' . $CI->config->item('theme') . '/' . $CI->config->item('css_frontend_path') . $value;
    }
}
/**
 * Get less URL
 *
 * @access  public
 * @return  string
 */
if ( ! function_exists('less_url'))
{
    function less_url($value='')
    {
        $CI =& get_instance();
        return base_url()  . 'themes/' . $CI->config->item('theme') . '/' . $CI->config->item('less_path') . $value;
    }
}

/**
 * Get js URL
 *
 * @access  public
 * @return  string
 */
if ( ! function_exists('js_url'))
{
    function js_url($value='')
    {
        $CI =& get_instance();
        return base_url()  . 'themes/' . $CI->config->item('theme') . '/' . $CI->config->item('js_path') . $value ;
    }
}

if ( ! function_exists('js_frontend_url'))
{
    function js_frontend_url($value='')
    {
        $CI =& get_instance();
        return base_url()  . 'themes/' . $CI->config->item('theme') . '/' . $CI->config->item('js_frontend_path') . $value ;
    }
}

/**
 * Get image URL
 *
 * @access  public
 * @return  string
 */
if ( ! function_exists('img_url'))
{
    function img_url($value='')
    {
		// die($value);
        $CI =& get_instance();
        return base_url()  . 'themes/' . $CI->config->item('theme') . '/' . $CI->config->item('img_path') . $value;
    }
}

if ( ! function_exists('img_frontend_url'))
{
    function img_frontend_url($value='')
    {
		// die($value);
        $CI =& get_instance();
        return base_url()  . 'themes/' . $CI->config->item('theme') . '/' . $CI->config->item('img_frontend_path') . $value;
    }
}

/**
 * Get SWF URL
 *
 * @access  public
 * @return  string
 */
if ( ! function_exists('swf_url'))
{
    function swf_url($value='')
    {
        $CI =& get_instance();
        return base_url()  . 'themes/' . $CI->config->item('theme') . '/' . $CI->config->item('swf_path') . $value;
    }
}

/**
 * Get Upload URL
 *
 * @access  public
 * @return  string
 */
if ( ! function_exists('upload_url'))
{
    function upload_url($value='')
    {
        $CI =& get_instance();
        return base_url()  . 'themes/' . $CI->config->item('upload_path') . $value;
    }
}

/**
 * Get Download URL
 *
 * @access  public
 * @return  string
 */
if ( ! function_exists('download_url'))
{
    function download_url($value='')
    {
        $CI =& get_instance();
        return base_url()  . 'themes/' . $CI->config->item('download_path') . $value;
    }
}

/**
 * Get Download URL
 *
 * @access  public
 * @return  string
 */
if ( ! function_exists('buku_url'))
{
    function buku_url($value='')
    {
        $CI =& get_instance();
        return base_url()  . 'themes/' . $CI->config->item('buku_path') . $value;
    }
}

if ( ! function_exists('maps_url'))
{
    function maps_url($value='')
    {
        $CI =& get_instance();
        return base_url()  . $CI->config->item('maps_path') . $value;
    }
}

if ( ! function_exists('staft_url'))
{
    function staft_url($value='')
    {
        $CI =& get_instance();
        return base_url()  . 'themes/' . $CI->config->item('staft_path') . $value;
    }
}

if ( ! function_exists('slide_url'))
{
    function slide_url($value='')
    {
        $CI =& get_instance();
        return base_url()  . 'themes/' . $CI->config->item('slide_path') . $value;
    }
}


if ( ! function_exists('wilayah_url'))
{
    function wilayah_url($value='')
    {
        $CI =& get_instance();
        return base_url()  . 'themes/' . $CI->config->item('wilayah_path') . $value;
    }
}

if ( ! function_exists('export_url'))
{
    function export_url($value='')
    {
        $CI =& get_instance();
        return base_url()  . 'themes/' . $CI->config->item('export_path') . $value;
    }
}

if ( ! function_exists('events_url'))
{
    function events_url($value='')
    {
        $CI =& get_instance();
        return base_url()  . 'themes/' . $CI->config->item('events_path') . $value;
    }
}

if ( ! function_exists('barcode_url'))
{
    function barcode_url($value='')
    {
        $CI =& get_instance();
        return base_url()  . 'themes/' . $CI->config->item('barcode_path') . $value;
    }
}

if ( ! function_exists('import_url'))
{
    function import_url($value='')
    {
        $CI =& get_instance();
        return base_url()  . 'themes/' . $CI->config->item('import_path') . $value;
    }
}

if ( ! function_exists('report_url'))
{
    function report_url($value='')
    {
        $CI =& get_instance();
        return base_url()  . 'themes/' . $CI->config->item('report_path') . $value;
    }
}

if ( ! function_exists('inbox_url'))
{
    function inbox_url($value='')
    {
        $CI =& get_instance();
        return base_url()  . 'themes/' . $CI->config->item('inbox_path') . $value;
    }
}

if ( ! function_exists('regulasi_url'))
{
    function regulasi_url($value='')
    {
        $CI =& get_instance();
        return base_url()  . 'themes/' . $CI->config->item('regulasi_path') . $value;
    }
}

if ( ! function_exists('rcsa_url'))
{
    function rcsa_url($value='')
    {
        $CI =& get_instance();
        return base_url()  . 'themes/' . $CI->config->item('rcsa_path') . $value;
    }
}
/**
 * Get XML URL
 *
 * @access  public
 * @return  string
 */
if ( ! function_exists('xml_url'))
{
    function xml_url($value='')
    {
        $CI =& get_instance();
        return base_url() . 'themes/' . $CI->config->item('theme') . '/' . $CI->config->item('xml_path') . $value;
    }
}

/**
 * Get XML URL
 *
 * @access  public
 * @return  string
 */
if ( ! function_exists('font_url'))
{
    function font_url($value='')
    {
        $CI =& get_instance();
        return base_url() . 'themes/' . $CI->config->item('theme') . '/' . $CI->config->item('font_path') . $value;
    }
}


/**
 * Get XML URL
 *
 * @access  public
 * @return  string
 */
if ( ! function_exists('plugin_url'))
{
    function plugin_url($value='')
    {
        $CI =& get_instance();
        return base_url() . 'themes/' . $CI->config->item('theme') . '/' . $CI->config->item('plugin_path') . $value;
    }
}

// ------------------------------------------------------------------------
// PATH HELPERS

/**
 * Get asset Path
 *
 * @access  public
 * @return  string
 */
if ( ! function_exists('asset_path'))
{
    function asset_path($value='')
    {
        //get an instance of CI so we can access our configuration
        $CI =& get_instance();
        return FCPATH . 'themes/' . $CI->config->item('theme') . '/' . $CI->config->item('asset_path') . $value;
    }
}

/**
 * Get CSS Path
 *
 * @access  public
 * @return  string
 */
if ( ! function_exists('css_path'))
{
    function css_path($value='')
    {
        //get an instance of CI so we can access our configuration
        $CI =& get_instance();
        return FCPATH . 'themes/' . $CI->config->item('theme') . '/' . $CI->config->item('css_path') . $value;
    }
}

if ( ! function_exists('css_frontend_path'))
{
    function css_frontend_path($value='')
    {
        //get an instance of CI so we can access our configuration
        $CI =& get_instance();
        return FCPATH . 'themes/' . $CI->config->item('theme') . '/' . $CI->config->item('css_frontend_path') . $value;
    }
}

/**
 * Get LESS Path
 *
 * @access  public
 * @return  string
 */
if ( ! function_exists('less_path'))
{
    function less_path($value='')
    {
        //get an instance of CI so we can access our configuration
        $CI =& get_instance();
        return FCPATH . 'themes/' . $CI->config->item('theme') . '/' . $CI->config->item('less_path') . $value;
    }
}

/**
 * Get JS Path
 *
 * @access  public
 * @return  string
 */
if ( ! function_exists('js_path'))
{
    function js_path($value='')
    {
        //get an instance of CI so we can access our configuration
        $CI =& get_instance();
        return FCPATH . 'themes/' . $CI->config->item('theme') . '/' . $CI->config->item('js_path') . $value;
    }
}

if ( ! function_exists('js_frontend_path'))
{
    function js_frontend_path($value='')
    {
        //get an instance of CI so we can access our configuration
        $CI =& get_instance();
        return FCPATH . 'themes/' . $CI->config->item('theme') . '/' . $CI->config->item('js_frontend_path') . $value;
    }
}

/**
 * Get image Path
 *
 * @access  public
 * @return  string
 */
if ( ! function_exists('img_path'))
{
    function img_path($value='')
    {
        //get an instance of CI so we can access our configuration
        $CI =& get_instance();
        return FCPATH . 'themes/' . $CI->config->item('theme') . '/' . $CI->config->item('img_path') . $value;
    }
}

if ( ! function_exists('img_frontend_path'))
{
    function img_frontend_path($value='')
    {
        //get an instance of CI so we can access our configuration
        $CI =& get_instance();
        return FCPATH . 'themes/' . $CI->config->item('theme') . '/' . $CI->config->item('img_frontend_path') . $value;
    }
}

/**
 * Get SWF Path
 *
 * @access  public
 * @return  string
 */
if ( ! function_exists('swf_path'))
{
    function swf_path($halu='')
    {
        $CI =& get_instance();
        return FCPATH . 'themes/' . $CI->config->item('theme') . '/' . $CI->config->item('swf_path') . $value;
    }
}

/**
 * Get XML Path
 *
 * @access  public
 * @return  string
 */
if ( ! function_exists('xml_path'))
{
    function xml_path($value='')
    {
        $CI =& get_instance();
        return FCPATH . 'themes/' . $CI->config->item('theme') . '/' . $CI->config->item('xml_path') . $value;
    }
}

/**
 * Get the Absolute Upload Path
 *
 * @access  public
 * @return  string
 */
if ( ! function_exists('upload_path'))
{
    function upload_path($value='')
    {
        $CI =& get_instance();
		// die(FCPATH . 'themes/' . $CI->config->item('upload_path') . $value);
        return FCPATH . 'themes/' . $CI->config->item('upload_path') . $value;
    }
}

/**
 * Get the Relative (to app root) Upload Path
 *
 * @access  public
 * @return  string
 */
if ( ! function_exists('upload_path_relative'))
{
    function upload_path_relative($value='')
    {
        $CI =& get_instance();
        return './' . 'themes/' . $CI->config->item('upload_path') . $value;
    }
}

/**
 * Get the Absolute Download Path
 *
 * @access  public
 * @return  string
 */
if ( ! function_exists('download_path'))
{
    function download_path($value='')
    {
        $CI =& get_instance();
        return FCPATH . 'themes/' . $CI->config->item('download_path') . $value;
    }
}

/**
 * Get the Absolute Download Path
 *
 * @access  public
 * @return  string
 */
 
 if ( ! function_exists('buku_path'))
{
    function buku_path($value='')
    {
        $CI =& get_instance();
        return FCPATH . 'themes/' . $CI->config->item('buku_path') . $value;
    }
}


if ( ! function_exists('maps_path'))
{
    function maps_path($value='')
    {
        $CI =& get_instance();
        return FCPATH . $CI->config->item('maps_path') . $value;
    }
}

if ( ! function_exists('staft_path'))
{
    function staft_path($value='')
    {
        $CI =& get_instance();
        return FCPATH . 'themes/' . $CI->config->item('staft_path') . $value;
    }
}

if ( ! function_exists('slide_path'))
{
    function slide_path($value='')
    {
        $CI =& get_instance();
        return FCPATH . 'themes/' . $CI->config->item('slide_path') . $value;
    }
}

if ( ! function_exists('wilayah_path'))
{
    function wilayah_path($value='')
    {
        $CI =& get_instance();
        return FCPATH . 'themes/' . $CI->config->item('wilayah_path') . $value;
    }
}

if ( ! function_exists('export_path'))
{
    function export_path($value='')
    {
        $CI =& get_instance();
        return FCPATH . 'themes/' . $CI->config->item('export_path') . $value;
    }
}

if ( ! function_exists('events_path'))
{
    function events_path($value='')
    {
        $CI =& get_instance();
        return FCPATH . 'themes/' . $CI->config->item('events_path') . $value;
    }
}

if ( ! function_exists('barcode_path'))
{
    function barcode_path($value='')
    {
        $CI =& get_instance();
        return FCPATH . 'themes/' . $CI->config->item('barcode_path') . $value;
    }
}

if ( ! function_exists('import_path'))
{
    function import_path($value='')
    {
        $CI =& get_instance();
        return FCPATH . 'themes/' . $CI->config->item('import_path') . $value;
    }
}

if ( ! function_exists('report_path'))
{
    function report_path($value='')
    {
        $CI =& get_instance();
        return FCPATH . 'themes/' . $CI->config->item('report_path') . $value;
    }
}

if ( ! function_exists('inbox_path'))
{
    function inbox_path($value='')
    {
        $CI =& get_instance();
        return FCPATH . 'themes/' . $CI->config->item('inbox_path') . $value;
    }
}

if ( ! function_exists('regulasi_path'))
{
    function regulasi_path($value='')
    {
        $CI =& get_instance();
        return FCPATH . 'themes/' . $CI->config->item('regulasi_path') . $value;
    }
}

if ( ! function_exists('rcsa_path'))
{
    function rcsa_path($value='')
    {
        $CI =& get_instance();
        return FCPATH . 'themes/' . $CI->config->item('rcsa_path') . $value;
    }
}
/**
 * Get the Relative (to app root) Download Path
 *
 * @access  public
 * @return  string
 */
if ( ! function_exists('download_path_relative'))
{
    function download_path_relative($value='')
    {
        $CI =& get_instance();
        return './' . 'themes/' . $CI->config->item('download_path') . $value;
    }
}

/**
 * Get the Relative (to app root) Download Path
 *
 * @access  public
 * @return  string
 */
if ( ! function_exists('buku_path_relative'))
{
    function buku_path_relative($value='')
    {
        $CI =& get_instance();
        return './' . 'themes/' . $CI->config->item('buku_path') . $value;
    }
}


 if ( ! function_exists('maps_path_relative'))
{
    function maps_path_relative($value='')
    {
        $CI =& get_instance();
        return './' . $CI->config->item('maps_path') . $value;
    }
}

 if ( ! function_exists('staft_path_relative'))
{
    function staft_path_relative($value='')
    {
        $CI =& get_instance();
        return './' . 'themes/' . $CI->config->item('staft_path') . $value;
    }
}

 if ( ! function_exists('slide_path_relative'))
{
    function slide_path_relative($value='')
    {
        $CI =& get_instance();
        return './' . 'themes/' . $CI->config->item('slide_path') . $value;
    }
}

if ( ! function_exists('wilayah_path_relative'))
{
    function wilayah_path_relative($value='')
    {
        $CI =& get_instance();
        return './' . 'themes/' . $CI->config->item('wilayah_path') . $value;
    }
}

if ( ! function_exists('img_path_relative'))
{
    function img_path_relative($value='')
    {
        $CI =& get_instance();
        return './' . 'themes/' . $CI->config->item('theme') . '/' . $CI->config->item('img_path') . $value;
    }
}

if ( ! function_exists('export_path_relative'))
{
    function export_path_relative($value='')
    {
        $CI =& get_instance();
        return './' . 'themes/' . $CI->config->item('export_path') . $value;
    }
}

if ( ! function_exists('events_path_relative'))
{
    function events_path_relative($value='')
    {
        $CI =& get_instance();
        return './' . 'themes/' . $CI->config->item('events_path') . $value;
    }
}
if ( ! function_exists('import_path_relative'))
{
    function import_path_relative($value='')
    {
        $CI =& get_instance();
        return './' . 'themes/' . $CI->config->item('import_path') . $value;
    }
}

if ( ! function_exists('barcode_path_relative'))
{
    function barcode_path_relative($value='')
    {
        $CI =& get_instance();
        return './' . 'themes/' . $CI->config->item('barcode_path') . $value;
    }
}

if ( ! function_exists('report_path_relative'))
{
    function report_path_relative($value='')
    {
        $CI =& get_instance();
        return './' . 'themes/' . $CI->config->item('report_path') . $value;
    }
}

if ( ! function_exists('inbox_path_relative'))
{
    function inbox_path_relative($value='')
    {
        $CI =& get_instance();
        return './' . 'themes/' . $CI->config->item('inbox_path') . $value;
    }
}

if ( ! function_exists('regulasi_path_relative'))
{
    function regulasi_path_relative($value='')
    {
        $CI =& get_instance();
        return './' . 'themes/' . $CI->config->item('regulasi_path') . $value;
    }
}

if ( ! function_exists('rcsa_path_relative'))
{
    function rcsa_path_relative($value='')
    {
        $CI =& get_instance();
        return './' . 'themes/' . $CI->config->item('rcsa_path') . $value;
    }
}
// ------------------------------------------------------------------------
// EMBED HELPERS

/**
 * Load CSS
 * Creates the <link> tag that links all requested css file
 * @access  public
 * @param   string
 * @return  string
 */
if ( ! function_exists('css'))
{
    function css($file, $media='all')
    {
        return '<link rel="stylesheet" type="text/css" href="' . css_url() . $file . '" media="' . $media . '">'."\n";
    }
}

if ( ! function_exists('css_frontend'))
{
    function css_frontend($file, $media='all')
    {
        return '<link rel="stylesheet" type="text/css" href="' . css_url() . $file . '" media="' . $media . '">'."\n";
    }
}

/**
 * Load LESS
 * Creates the <link> tag that links all requested LESS file
 * @access  public
 * @param   string
 * @return  string
 */
if ( ! function_exists('less'))
{
    function less($file)
    {
        return '<link rel="stylesheet/less" type="text/css" href="' . less_url() . $file . '">'."\n";
    }
}

/**
 * Load JS
 * Creates the <script> tag that links all requested js file
 * @access  public
 * @param   string
 * @param 	array 	$atts Optional, additional key/value attributes to include in the SCRIPT tag
 * @return  string
 */
if ( ! function_exists('js'))
{
    function js($file, $atts = array())
    {
        $element = '<script type="text/javascript" src="' . js_url() . $file . '"';

		foreach ( $atts as $key => $val )
			$element .= ' ' . $key . '="' . $val . '"';
		$element .= '></script>'."\n";

		return $element;
    }
}

if ( ! function_exists('js_frontend'))
{
    function js_frontend($file, $atts = array())
    {
        $element = '<script type="text/javascript" src="' . js_url() . $file . '"';

		foreach ( $atts as $key => $val )
			$element .= ' ' . $key . '="' . $val . '"';
		$element .= '></script>'."\n";

		return $element;
    }
}

/**
 * Load Image
 * Creates an <img> tag with src and optional attributes
 * @access  public
 * @param   string
 * @param 	array 	$atts Optional, additional key/value attributes to include in the IMG tag
 * @return  string
 */
if ( ! function_exists('img'))
{
    function img($file,  $atts = array())
    {
		$url = '<img src="' . img_url() . $file . '"';
		foreach ( $atts as $key => $val )
			$url .= ' ' . $key . '="' . $val . '"';
		$url .= " />\n";
        return $url;
    }
}

if ( ! function_exists('img_frontend'))
{
    function img_frontend($file,  $atts = array())
    {
		$url = '<img src="' . img_url() . $file . '"';
		foreach ( $atts as $key => $val )
			$url .= ' ' . $key . '="' . $val . '"';
		$url .= " />\n";
        return $url;
    }
}

/**
 * Load Minified JQuery CDN w/ failover
 * Creates the <script> tag that links all requested js file
 * @access  public
 * @param   string
 * @return  string
 */
if ( ! function_exists('jquery'))
{
    function jquery($version='')
    {
    	// Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline
  		$out = '<script src="//ajax.googleapis.com/ajax/libs/jquery/'.$version.'/jquery.min.js"></script>'."\n";
  		$out .= '<script>window.jQuery || document.write(\'<script src="'.js_url().'jquery-'.$version.'.min.js"><\/script>\')</script>'."\n";
        return $out;
    }
}

/**
 * Load Google Analytics
 * Creates the <script> tag that links all requested js file
 * @access  public
 * @param   string
 * @return  string
 */
if ( ! function_exists('google_analytics'))
{
    function google_analytics($ua='')
    {
    	// Change UA-XXXXX-X to be your site's ID
	    $out = "<!-- Google Webmaster Tools & Analytics -->\n";
	    $out .='<script type="text/javascript">';
		$out .='	var _gaq = _gaq || [];';
		$out .="    _gaq.push(['_setAccount', '$ua']);";
		$out .="    _gaq.push(['_trackPageview']);";
		$out .='    (function() {';
		$out .="      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;";
		$out .="      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';";
		$out .="      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);";
		$out .="    })();";
	    $out .="</script>";
        return $out;
    }
}

/**
 * Get XML URL
 *
 * @access  public
 * @return  string
 */
if ( ! function_exists('themes_location_url'))
{
    function themes_location_url($value='')
    {
		// die("apa bu");
        $CI =& get_instance();
		$x=$CI->config->item('theme_locations');
        return base_url() . $x[0] . $value;
    }
}

/* End of file asset_helper.php */
