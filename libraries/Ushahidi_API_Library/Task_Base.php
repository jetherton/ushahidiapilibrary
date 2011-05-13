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
 	public static $ERROR_INDEX = "error";
	public static $ERROR_CODE_INDEX = "code";
	public static $ERROR_MESSAGE_INDEX = "message";
 	
 	
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
		//set the parameters we're sending
		$parameters = $this->task_parameter->get_query_string();
		
		
		
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$this->json = curl_exec($ch);
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
   
    	
    	$response = new Task_Response_Base($data_array[Task_Base::$ERROR_INDEX][Task_Base::$ERROR_CODE_INDEX], 
    		$data_array[Task_Base::$ERROR_INDEX][Task_Base::$ERROR_MESSAGE_INDEX]);
    	
    	return $response;
    	
    } 
    
    
    
 }