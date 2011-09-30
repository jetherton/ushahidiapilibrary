<?php 
defined('SYSPATH') or die('No direct script access allowed'); 
/**
 * This class is used as the base class to encapuslate the parameters needed to execute a task on the Ushahidi API
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




 abstract class UshApiLib_Task_Parameter_Base extends UshApiLib_Ushahidi_API_Library_Base
 {
 	//Stores the name of the task we're trying to execute against the API
 	protected $task_name = "";
 	
 	//How we want the data retunred to us. We always want JSON
 	protected $resp = "json";
 	
 	/**
 	 * Constructor that sets the task name
 	 * 
 	 * @param String $task_name
 	 */
    public function __construct($task_name)
    {
        parent::__construct();
    	$this->set_task_name($task_name);        
    }
 	
 	
 	/**
 	 * Retrievies the name of the task that this parameter is for
 	 * Returns a string 	 
 	 */
 	public function get_task_name()
 	{
 		return $this->task_name;
 	}
 	
 	
 	/**
 	 * Sets the name fo the task this parameter is for
 	 * 
 	 * @param String $task_name
 	 */
 	public function set_task_name($task_name)
 	{
 		$this->task_name = $task_name;
 	}
 	
 	
 	/**
 	 * Generates the POST/GET query string
  	 */
 	abstract public function get_query_string();
 
 	
 }    