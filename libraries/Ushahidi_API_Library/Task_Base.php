<?php namespace Ushahidi_API_Library;
defined('SYSPATH') or die('No direct script access allowed'); 
/**
 * This class is used as the base class to encapuslate the execution of a task on the Ushahidi API
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


class Task_Base extends Ushahidi_API_Library_Base
 {
 	
 	// The parameters we're going to use when executing
 	protected  $task_parameter = null;

 	// The name of the task to execute
 	protected $task_name = null;
 	
 	//the low down on the site we're executing API calls on
 	protected $site_info = null;
 	
 	//json response string
 	protected $json = null;
 	
 	
 	//"Constants" that define the index to find stuff in the JSON. I know they aren't real constants, 
 	//but I don't want to flood the global name space
 	const ERROR_INDEX = "error";
	const ERROR_CODE_INDEX = "code";
	const ERROR_MESSAGE_INDEX = "message";
	const PAYLOAD_INDEX = "payload";
	
	const SERVICE_INDEX = "service";
	const SERVICES_INDEX = "services";
	const ID_INDEX = "id";
	const API_KEY_INDEX = "apikey";
	
	const CATEGORIES_INDEX = "categories";
	const CATEGORY_INDEX = "category";
	const TITLE_INDEX = "category_title";
	const DESCRIPTION_INDEX = "category_description";
	const COLOR_INDEX = "category_color";
	
	const INCIDENTS_INDEX = "incidents";
	const INCIDENT_INDEX = "incident";
	const INCIDENT_ID_INDEX = "incidentid";
	const INCIDENT_TITLE_INDEX = "incidenttitle";
	const INCIDENT_DESCRIPTION_INDEX = "incidentdescription";
	const INCIDENT_DATE_INDEX = "incidentdate";
	const INCIDENT_MODE_INDEX = "incidentmode";
	const INCIDENT_ACTIVE_INDEX = "incidentactive";
	const INCIDENT_VERIFIED_INDEX = "incidentverified";
	const LOCATION_ID_INDEX = "locationid";
	const LOCATION_NAME_INDEX = "locationname";
	const LOCATION_LATITUDE_INDEX = "locationlatitude";
	const LOCATION_LONGITUDE_INDEX = "locationlongitude";
	const MEDIA_INDEX = "media";
	const TYPE_INDEX = "type";
	const LINK_INDEX = "link";
	const THUMB_INDEX = "thumb";
	const LINK_URL_INDEX = "link_url";
	const THUMB_URL_INDEX = "thumb_url";
	const LOCATION_INDEX = "location";
	
 	
 	
 	/**
 	 * Constructor
 	 * 
 	 * @param The parameters of the task at hand $task_parameter
 	 */
 	public function __construct($task_parameter, $site_info)
    {
        parent::__construct();

        $this->task_parameter = $task_parameter;
        $this->site_info = $site_info; 
    }
    
    /**
     * Returns the raw json string returned, null if there was a problem
     */
    public function getJson()
    {
    	return $this->json;
    }
    
    /**
     * Runs the API task against the specified site with the given paramters
     * Returns the 
     */
    public function execute()
    {
    	$this->query_site();
    	return $this->parse_json();
    }
    
    /**
     * Runs the Curl call to pass in the paramters to specified site and stores the returned json
     */
    protected function query_site()
    {
    	//reset this
    	$this->json = null;
    	
    	//set the url and initialize curl
		$url = $this->site_info->geturl();		
		$ch = curl_init($url);
				
		if(!$ch)
		{
			$this->json = '{"error":{"code":"1000","message":"Malformed URL"}}';
			return $this->json;
		}
		//set the parameters we're sending
		$parameters = $this->task_parameter->get_query_string();
		
		
		//use post
		curl_setopt($ch, CURLOPT_POST, 1);
    	if(($error = curl_error($ch)) != "")
		{
			$error_code = curl_errno($ch);
			$this->json = json_encode(array("error"=>array("code"=>"C".$error_code, "message"=>$error)));
			return $this->json;
		}
		
		//set post parameters
		curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
    	if(($error = curl_error($ch)) != "")
		{
			$error_code = curl_errno($ch);
			$this->json = json_encode(array("error"=>array("code"=>"C".$error_code, "message"=>$error)));
			return $this->json;
		}
		
		//set return transfer true
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	if(($error = curl_error($ch)) != "")
		{
			$error_code = curl_errno($ch);
			$this->json = json_encode(array("error"=>array("code"=>"C".$error_code, "message"=>$error)));
			return $this->json;
		}
		
		// set follow location
	    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
    	if(($error = curl_error($ch)) != "")
		{
			$error_code = curl_errno($ch);
			$this->json = json_encode(array("error"=>array("code"=>"C".$error_code, "message"=>$error)));
			return $this->json;
		}
		// set auto referer
	    curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
    	if(($error = curl_error($ch)) != "")
		{
			$error_code = curl_errno($ch);
			$this->json = json_encode(array("error"=>array("code"=>"C".$error_code, "message"=>$error)));
			return $this->json;
		}
		//set max redirects
	    curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
    	if(($error = curl_error($ch)) != "")
		{
			$error_code = curl_errno($ch);
			$this->json = json_encode(array("error"=>array("code"=>"C".$error_code, "message"=>$error)));
			return $this->json;
		}
		
		$this->json = curl_exec($ch);
		
    	if(($error = curl_error($ch)) != "")
		{
			$error_code = curl_errno($ch);
			$this->json = json_encode(array("error"=>array("code"=>"C".$error_code, "message"=>$error)));
			return $this->json;
		}
		
		$http_error = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if(intval($http_error) >= 400)
		{
			$error_code = $http_error;
			$this->json = json_encode(array("error"=>array("code"=>"H".$error_code, "message"=>"HTTP Error: ".$error_code)));
			return $this->json;
		}
		
		curl_close($ch);
		return $this->json;
    }
    
    
    /**
     * Finds the json from the query and parses it
     * Since this is the base class this just looks for the error object and parses that
     */
    protected function parse_json()
    {
    	if($this->json == null)
    	{
    		return null;
    	}
    	
    	$data_array = json_decode($this->json, true);
   
    	if(!isset($data_array[Task_Base::ERROR_INDEX]))
    	{
    		return new Task_Response_Base("U1", "Unable to parse JSON string. use getJson() on the task object to see what was returned");
    	}
    	if(!isset($data_array[Task_Base::ERROR_INDEX][Task_Base::ERROR_CODE_INDEX]))
    	{
    		return new Task_Response_Base("U1", "Unable to parse JSON string. use getJson() on the task object to see what was returned");
    	}
    	if(!isset($data_array[Task_Base::ERROR_INDEX][Task_Base::ERROR_MESSAGE_INDEX]))
    	{
    		return new Task_Response_Base("U1", "Unable to parse JSON string. use getJson() on the task object to see what was returned");
    	}
    	
    	
    	$response = new Task_Response_Base($data_array[Task_Base::ERROR_INDEX][Task_Base::ERROR_CODE_INDEX], 
    		$data_array[Task_Base::ERROR_INDEX][Task_Base::ERROR_MESSAGE_INDEX]);
    	
    	return $response;
    	
    } 
    
    
    
 }