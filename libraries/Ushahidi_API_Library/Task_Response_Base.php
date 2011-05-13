<?php namespace Ushahidi_API_Library;
defined('SYSPATH') or die('No direct script access allowed'); 
/**
 * This class is used as the base class to encapuslate the response from running a task on the Ushahidi API
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


class Task_Response_Base extends Ushahidi_API_Library_Base
{
	//The error code, 0 if no error
	protected $error_code;	
	
	//The error message, "No Error" if there was no error.
	protected $error_message;
	
	
	
	/**
	 * Parameterized constructor
	 * 
	 * @param String $error_code
	 * @param String $error_message
	 */
	public function __construct($error_code, $error_message)
	{
		parent::__construct();
		$this->error_code = $error_code;
		$this->error_message = $error_message;
	}
	
	/**
	 * Returns the error code
	 */
	public function getError_code() { return $this->error_code; }

	/**
	 * Returns the error message.
	 */
	public function getError_message() { return $this->error_message; } 
}