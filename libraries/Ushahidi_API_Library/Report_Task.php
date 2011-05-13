<?php namespace Ushahidi_API_Library;
defined('SYSPATH') or die('No direct script access allowed'); 
/**
 * This class is used to execute the report task in the Ushahidi API
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


class Report_Task extends Task_Base
{
	
 	/**
 	 * Constructor
 	 * 
 	 * @param Task_Parameter_Base $task_parameter
 	 * @param Site_Info $site_info
 	 */
 	public function __construct($task_parameter, $site_info)
    {
        parent::__construct($task_parameter, $site_info);
		$this->task_name = "report"; 
        
		//make sure task name and paramter type match
		if($this->task_name != $task_parameter->get_task_name())
		{
			Throw new Exception("Task type and task paramter type don't match. Trying create a task of type ". $this->task_name ." with a paramter of type ". $task_parameter->get_task_name()."." );
		}
		 
    }	
 	
}
