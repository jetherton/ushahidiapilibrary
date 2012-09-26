<?php 
defined('SYSPATH') or die('No direct script access allowed'); 
/**
 * This class is used to execute the Api Keys task in the Ushahidi API
 *
 * @version 01 - John Etherton 2011-05-17
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


class UshApiLib_Api_Key_Task extends UshApiLib_Task_Base
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
		$this->task_name = "apikeys"; 
        
		//make sure task name and paramter type match
		if($this->task_name != $task_parameter->get_task_name())
		{
			Throw new \Exception("Task type and task paramter type don't match. Trying create a task of type ". $this->task_name ." with a paramter of type ". $task_parameter->get_task_name()."." );
		}
		 
    }

    
    
    
    /**
     * Finds the json from the query and parses it
     */
    protected function parse_json()
    {
    	if($this->json == null)
    	{
    		return null;
    	}
    	
    	$data_array = json_decode($this->json, true);
   
    	if( (!isset($data_array[UshApiLib_Task_Base::ERROR_INDEX])) || 
    		(!isset($data_array[UshApiLib_Task_Base::ERROR_INDEX][UshApiLib_Task_Base::ERROR_CODE_INDEX])) ||
    		(!isset($data_array[UshApiLib_Task_Base::ERROR_INDEX][UshApiLib_Task_Base::ERROR_MESSAGE_INDEX])) ||
    		(!isset($data_array[UshApiLib_Task_Base::PAYLOAD_INDEX])) )
    		{
    			return new UshApiLib_Task_Response_Base("U1", "Unable to parse JSON string. use getJson() on the task object to see what was returned");	
    		}
    	elseif(
    		(!isset($data_array[UshApiLib_Task_Base::PAYLOAD_INDEX][UshApiLib_Task_Base::SERVICES_INDEX])) ||
    		(!isset($data_array[UshApiLib_Task_Base::PAYLOAD_INDEX][UshApiLib_Task_Base::SERVICES_INDEX][0])) ||
    		(!isset($data_array[UshApiLib_Task_Base::PAYLOAD_INDEX][UshApiLib_Task_Base::SERVICES_INDEX][0][UshApiLib_Task_Base::SERVICE_INDEX])) ||
    		(!isset($data_array[UshApiLib_Task_Base::PAYLOAD_INDEX][UshApiLib_Task_Base::SERVICES_INDEX][0][UshApiLib_Task_Base::SERVICE_INDEX][UshApiLib_Task_Base::ID_INDEX])) ||
    		(!isset($data_array[UshApiLib_Task_Base::PAYLOAD_INDEX][UshApiLib_Task_Base::SERVICES_INDEX][0][UshApiLib_Task_Base::SERVICE_INDEX][UshApiLib_Task_Base::API_KEY_INDEX]))
    	)
    	{
    		return new UshApiLib_Task_Response_Base($data_array[UshApiLib_Task_Base::ERROR_INDEX][UshApiLib_Task_Base::ERROR_CODE_INDEX], 
    		$data_array[UshApiLib_Task_Base::ERROR_INDEX][UshApiLib_Task_Base::ERROR_MESSAGE_INDEX]);
    	}
    	
    	
    	
    	
    	$response = new UshApiLib_Api_Key_Response($data_array[UshApiLib_Task_Base::ERROR_INDEX][UshApiLib_Task_Base::ERROR_CODE_INDEX], 
    		$data_array[UshApiLib_Task_Base::ERROR_INDEX][UshApiLib_Task_Base::ERROR_MESSAGE_INDEX],
    		$data_array[UshApiLib_Task_Base::PAYLOAD_INDEX][UshApiLib_Task_Base::SERVICES_INDEX][0][UshApiLib_Task_Base::SERVICE_INDEX][UshApiLib_Task_Base::ID_INDEX],
    		$data_array[UshApiLib_Task_Base::PAYLOAD_INDEX][UshApiLib_Task_Base::SERVICES_INDEX][0][UshApiLib_Task_Base::SERVICE_INDEX][UshApiLib_Task_Base::API_KEY_INDEX]);
    	
    	return $response;
    	
    }
 	
}
