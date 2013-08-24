<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2003 - 2011, EllisLab, Inc.
 * @license		http://expressionengine.com/user_guide/license.html
 * @link		http://expressionengine.com
 * @since		Version 2.0
 * @filesource
 */
 
// ------------------------------------------------------------------------

/**
 * Safecracker HTML5 Attributes Extension
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Extension
 * @author		Jason Varga
 * @link		http://pixelfear.com
 */

class Safecracker_data_attributes_ext {
	
	public $settings 		= array();
	public $description		= 'Add HTML5 data attributes to the available Safecracker Parameters.';
	public $docs_url		= '';
	public $name			= 'Safecracker Data Attributes';
	public $settings_exist	= 'n';
	public $version			= '1.0';
	
	private $EE, $obj, $params;
	
	/**
	 * Constructor
	 *
	 * @param 	mixed	Settings array or empty string if none exist.
	 */
	public function __construct($settings = '')
	{
		$this->EE =& get_instance();
		$this->settings = $settings;
	}// ----------------------------------------------------------------------
	
	/**
	 * Activate Extension
	 *
	 * This function enters the extension into the exp_extensions table
	 *
	 * @see http://codeigniter.com/user_guide/database/index.html for
	 * more information on the db class.
	 *
	 * @return void
	 */
	public function activate_extension()
	{
		// Setup custom settings in this array.
		$this->settings = array();

		$data = array(
			'class'		=> __CLASS__,
			'method'	=> 'safecracker_entry_form_tagdata_end',
			'hook'		=> 'safecracker_entry_form_tagdata_end',
			'settings'	=> serialize($this->settings),
			'version'	=> $this->version,
			'enabled'	=> 'y'
		);

		$this->EE->db->insert('extensions', $data);	
	}	

	// ----------------------------------------------------------------------

	/**
	 * Disable Extension
	 *
	 * This method removes information from the exp_extensions table
	 *
	 * @return void
	 */
	function disable_extension()
	{
		$this->EE->db->where('class', __CLASS__);
		$this->EE->db->delete('extensions');
	}

	// ----------------------------------------------------------------------

	/**
	 * Update Extension
	 *
	 * This function performs any necessary db updates when the extension
	 * page is visited
	 *
	 * @return 	mixed	void on update / false if none
	 */
	function update_extension($current = '')
	{
		if ($current == '' OR $current == $this->version)
		{
			return FALSE;
		}
	}	
	
	// ----------------------------------------------------------------------

	public function safecracker_entry_form_tagdata_end($tagdata, &$obj)
	{
		$this->obj =& $obj;

		$params = $this->obj->EE->TMPL->tagparams;
		$data_params = array();

		$data_string = '';
		foreach ($params as $attr => $val)
		{
			if (preg_match('/^data-/', $attr)) {
				$data_string .= $attr . '="'.$val.'" ';
			}
		}

		$tagdata = str_replace('<form ', '<form '.$data_string , $tagdata);

		return $tagdata;
	}
}

/* End of file ext.safecracker_data_attributes.php */
/* Location: /system/expressionengine/third_party/safecracker_data_attributes/ext.safecracker_data_attributes.php */