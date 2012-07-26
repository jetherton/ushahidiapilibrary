<?php 
defined('SYSPATH') or die('No direct script access allowed'); 
/**
 * This class is used to execute the Categories task in the Ushahidi API
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


class UshApiLib_Categories_Task extends UshApiLib_Task_Base
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
		$this->task_name = "categories"; 
        
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
    		(!isset($data_array[UshApiLib_Task_Base::ERROR_INDEX][UshApiLib_Task_Base::ERROR_MESSAGE_INDEX]))    	
    	)
    	{
    		return new Task_Response_Base("U1", "Unable to parse JSON string. use getJson() on the task object to see what was returned");
    	}
    	elseif( (!isset($data_array[UshApiLib_Task_Base::PAYLOAD_INDEX])) ||
    		(!isset($data_array[UshApiLib_Task_Base::PAYLOAD_INDEX][UshApiLib_Task_Base::CATEGORIES_INDEX])) ||
    		(!isset($data_array[UshApiLib_Task_Base::PAYLOAD_INDEX][UshApiLib_Task_Base::CATEGORIES_INDEX]))
    		)
    		{
    			return new Task_Response_Base($data_array[UshApiLib_Task_Base::ERROR_INDEX][UshApiLib_Task_Base::ERROR_CODE_INDEX], 
    				$data_array[UshApiLib_Task_Base::ERROR_INDEX][UshApiLib_Task_Base::ERROR_MESSAGE_INDEX]);
    		}
    	else 
    	{
    		$categories = array();
    		foreach($data_array[UshApiLib_Task_Base::PAYLOAD_INDEX][UshApiLib_Task_Base::CATEGORIES_INDEX] as $cat)
    		{
	    			$category = \ORM::Factory("category");
	    			$category->parent_id = 0;
	    			$category->category_visible = 1;
	    			//accounting for annoying inconsistancies
	    			if(isset($cat[UshApiLib_Task_Base::CATEGORY_INDEX][UshApiLib_Task_Base::TITLE_INDEX]))
	    			{
	    				$category->category_title = $cat[UshApiLib_Task_Base::CATEGORY_INDEX][UshApiLib_Task_Base::TITLE_INDEX];
	    			}
	    			elseif(isset($cat[UshApiLib_Task_Base::CATEGORY_INDEX][UshApiLib_Task_Base::CATEGORY_INDEX. "_". UshApiLib_Task_Base::TITLE_INDEX]))
	    			{
	    				$category->category_title = $cat[UshApiLib_Task_Base::CATEGORY_INDEX][UshApiLib_Task_Base::CATEGORY_INDEX. "_". UshApiLib_Task_Base::TITLE_INDEX];
	    			}
	    			
	    			if(isset($cat[UshApiLib_Task_Base::CATEGORY_INDEX][UshApiLib_Task_Base::DESCRIPTION_INDEX]))
	    			{
	    				$category->category_description = $cat[UshApiLib_Task_Base::CATEGORY_INDEX][UshApiLib_Task_Base::DESCRIPTION_INDEX];
	    			}	    			
	    			elseif(isset($cat[UshApiLib_Task_Base::CATEGORY_INDEX][UshApiLib_Task_Base::CATEGORY_INDEX. "_". UshApiLib_Task_Base::DESCRIPTION_INDEX]))
	    			{
	    				$category->category_description = $cat[UshApiLib_Task_Base::CATEGORY_INDEX][UshApiLib_Task_Base::CATEGORY_INDEX. "_". UshApiLib_Task_Base::DESCRIPTION_INDEX];
	    			}
	    			
	    			if(isset($cat[UshApiLib_Task_Base::CATEGORY_INDEX][UshApiLib_Task_Base::COLOR_INDEX]))
	    			{
	    				$category->category_color = $cat[UshApiLib_Task_Base::CATEGORY_INDEX][UshApiLib_Task_Base::COLOR_INDEX];
	    			}
	    			elseif(isset($cat[UshApiLib_Task_Base::CATEGORY_INDEX][UshApiLib_Task_Base::CATEGORY_INDEX. "_". UshApiLib_Task_Base::COLOR_INDEX]))
	    			{
	    				$category->category_color = $cat[UshApiLib_Task_Base::CATEGORY_INDEX][UshApiLib_Task_Base::CATEGORY_INDEX. "_". UshApiLib_Task_Base::COLOR_INDEX];
	    			}
	    			$categories[] = $category;
    		}
    		
	    	$response = new UshApiLib_Categories_Response($data_array[UshApiLib_Task_Base::ERROR_INDEX][UshApiLib_Task_Base::ERROR_CODE_INDEX], 
	    		$data_array[UshApiLib_Task_Base::ERROR_INDEX][UshApiLib_Task_Base::ERROR_MESSAGE_INDEX], $categories);
    	}
    	
    	return $response;
    	
    }
 	
}
