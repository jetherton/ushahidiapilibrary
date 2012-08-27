<?php 
defined('SYSPATH') or die('No direct script access allowed'); 
/**
 * This class is used to execute the Categories Incidents in the Ushahidi API
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


class UshApiLib_Incidents_Task extends UshApiLib_Task_Base
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
		$this->task_name = "incidents"; 
        
		//make sure task name and paramter type match
		if($this->task_name != $task_parameter->get_task_name())
		{
			Throw new Exception("Task type and task paramter type don't match. Trying create a task of type ". $this->task_name ." with a paramter of type ". $task_parameter->get_task_name()."." );
		}
		 
    }

    
    
    
    /**
     * Finds the json from the query and parses it
     */
    protected function parse_json()
    {
    	$incidents = array();
    	
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
    		return new UshApiLib_Incidents_Response("U1", "Unable to parse JSON string. use getJson() on the task object to see what was returned", array());
    	}
    	else if(!isset($data_array[UshApiLib_Task_Base::PAYLOAD_INDEX][UshApiLib_Task_Base::INCIDENTS_INDEX]))
    	{
    		return new UshApiLib_Incidents_Response("U1", "Unable to parse JSON string. use getJson() on the task object to see what was returned", array());
    		
    	}
    	else 
    	{    		
    		foreach($data_array[UshApiLib_Task_Base::PAYLOAD_INDEX][UshApiLib_Task_Base::INCIDENTS_INDEX] as $inc)
    		{
	    			$incident = ORM::Factory("incident");
	    			$incident->incident_title = $inc[UshApiLib_Task_Base::INCIDENT_INDEX][UshApiLib_Task_Base::INCIDENT_TITLE_INDEX];
	    			$incident->incident_description = $inc[UshApiLib_Task_Base::INCIDENT_INDEX][UshApiLib_Task_Base::INCIDENT_DESCRIPTION_INDEX];
	    			$incident->incident_date = $inc[UshApiLib_Task_Base::INCIDENT_INDEX][UshApiLib_Task_Base::INCIDENT_DATE_INDEX];
	    			$incident->incident_mode = $inc[UshApiLib_Task_Base::INCIDENT_INDEX][UshApiLib_Task_Base::INCIDENT_MODE_INDEX];
	    			$incident->incident_active = $inc[UshApiLib_Task_Base::INCIDENT_INDEX][UshApiLib_Task_Base::INCIDENT_ACTIVE_INDEX];
	    			$incident->incident_verified = $inc[UshApiLib_Task_Base::INCIDENT_INDEX][UshApiLib_Task_Base::INCIDENT_VERIFIED_INDEX];
	    			//handle the location
	    			$location = ORM::Factory("location");
	    			$location->location_name = $inc[UshApiLib_Task_Base::INCIDENT_INDEX][UshApiLib_Task_Base::LOCATION_NAME_INDEX];
	    			$location->latitude = $inc[UshApiLib_Task_Base::INCIDENT_INDEX][UshApiLib_Task_Base::LOCATION_LATITUDE_INDEX];
	    			$location->longitude = $inc[UshApiLib_Task_Base::INCIDENT_INDEX][UshApiLib_Task_Base::LOCATION_LONGITUDE_INDEX];
	    			
	    			//handle the categories
	    			$categories = array();
	    			if(isset($inc[UshApiLib_Task_Base::CATEGORIES_INDEX]))
	    			{
		    			foreach($inc[UshApiLib_Task_Base::CATEGORIES_INDEX] as $cat)
		    			{
							$category = ORM::Factory("category");
			    			$category->parent_id = 0;
			    			$category->category_visible = 1;
			    			$category->category_title = $cat[UshApiLib_Task_Base::CATEGORY_INDEX][UshApiLib_Task_Base::TITLE_INDEX];
			    			$categories[] = $category;
		    			}
	    			}
	    			
	    			//hanlde media
	    			$medias = array();
	    			if(isset($inc[UshApiLib_Task_Base::MEDIA_INDEX]))
	    			{
		    			foreach($inc[UshApiLib_Task_Base::MEDIA_INDEX] as $med)
		    			{
							$media = ORM::Factory("media");
							$media->media_type = $med[UshApiLib_Task_Base::TYPE_INDEX];
							$media->media_link = $med[UshApiLib_Task_Base::LINK_INDEX];
							$media->media_thumb = $med[UshApiLib_Task_Base::THUMB_INDEX];
			    			$medias[] = $media;
		    			}
	    			}
	    			$incident_info_array =array(UshApiLib_Task_Base::INCIDENT_INDEX=>$incident, UshApiLib_Task_Base::CATEGORIES_INDEX=>$categories, 
	    				UshApiLib_Task_Base::LOCATION_INDEX=>$location, UshApiLib_Task_Base::MEDIA_INDEX=>$medias);
	    			$incidents[$inc[UshApiLib_Task_Base::INCIDENT_INDEX][UshApiLib_Task_Base::INCIDENT_ID_INDEX]] = $incident_info_array;
	    		
    		}
    		
	    	$response = new UshApiLib_Incidents_Response($data_array[UshApiLib_Task_Base::ERROR_INDEX][UshApiLib_Task_Base::ERROR_CODE_INDEX], 
	    		$data_array[UshApiLib_Task_Base::ERROR_INDEX][UshApiLib_Task_Base::ERROR_MESSAGE_INDEX], $incidents);
    	}
    	
    	return $response;
    	
    }
 	
}
