<?php 
defined('SYSPATH') or die('No direct script access allowed'); 
/**
 * This class is used as the class to encapuslate the response from running the task Categories on the Ushahidi API
 *
 * @version 01 - John Etherton 2011-05-13
 *
 * PHP version 5.3.0
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     John Etherton <john@ethertontech.com>
 * @package    Ushahidi API Library - http://source.ushahididev.com
 * @module     Ushahidi API Library
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */


class UshApiLib_Categories_Response extends UshApiLib_Task_Response_Base
{

	//The returned categories
	protected $categories;
	

	
	/**
	 * Parameterized constructor
	 * 
	 * @param String $error_code
	 * @param String $error_message
	 */
	public function __construct($error_code, $error_message, $categories)
	{
		parent::__construct($error_code, $error_message);
		
		$this->categories = $categories;
	}
	
	/**
	 * Returns the error code
	 */
	public function getCategories() { return $this->categories; }

	 
}