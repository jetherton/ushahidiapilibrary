<?php defined('SYSPATH') or die('No direct script access allowed'); 
/**
 * This class is used to hook into ushahidi and include the necesary files for the Ushahidi
 * API Library to work properly
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

class ushahidiapilibrary {
	
	/**
	 * Registers the main event add method
	 */
	public function __construct()
	{	
		// Hook into routing
		Event::add('system.pre_controller', array($this, 'add'));
	}
	
	/**
	 * Adds all the events to the main Ushahidi application
	 */
	public function add()
	{
		//load in that Library goodness
		include Kohana::find_file("libraries/Ushahidi_API_Library", "Ushahidi_API_Library_Base");
		include Kohana::find_file("libraries/Ushahidi_API_Library", "Task_Parameter_Base");
		include Kohana::find_file("libraries/Ushahidi_API_Library", "Task_Response_Base");
		include Kohana::find_file("libraries/Ushahidi_API_Library", "Task_Base");		
		include Kohana::find_file("libraries/Ushahidi_API_Library", "Report_Task_Parameter");
		include Kohana::find_file("libraries/Ushahidi_API_Library", "Report_Task");
		include Kohana::find_file("libraries/Ushahidi_API_Library", "Site_Info");
		
		include Kohana::find_file("libraries/Ushahidi_API_Library", "Api_Key_Task");
		include Kohana::find_file("libraries/Ushahidi_API_Library", "Api_Key_Task_Parameter");
		include Kohana::find_file("libraries/Ushahidi_API_Library", "Api_Key_Response");
		
		include Kohana::find_file("libraries/Ushahidi_API_Library", "Categories_Task");
		include Kohana::find_file("libraries/Ushahidi_API_Library", "Categories_Task_Parameter");
		include Kohana::find_file("libraries/Ushahidi_API_Library", "Categories_Response");
		
		include Kohana::find_file("libraries/Ushahidi_API_Library", "Incidents_Task");
		include Kohana::find_file("libraries/Ushahidi_API_Library", "Incidents_Task_Parameter");
		include Kohana::find_file("libraries/Ushahidi_API_Library", "Incidents_Response");
		include Kohana::find_file("libraries/Ushahidi_API_Library", "Incidents_Bys");
		
		
	}
}

new ushahidiapilibrary;