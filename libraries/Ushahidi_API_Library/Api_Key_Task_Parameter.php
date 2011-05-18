<?php namespace Ushahidi_API_Library;  defined('SYSPATH') or die('No direct script access allowed');
/**
 * This class is used to encapuslate the parameters needed to execute the API Keys task on the Ushahidi API
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




 class Api_Key_Task_Parameter extends Task_Parameter_Base 
 {
 	
 	///////////////////////////////////////////////////////////////////////////////////////////////////////
 	// INSTANCE VARIABLES
 	///////////////////////////////////////////////////////////////////////////////////////////////////////
    
 	// A string representing the name of the map service  in question. Like "Google" or "Yahoo"
 	private $by = null;
 	
 	
 	/////////////////////////////////////////////////////////////////////////////////////////////////////////
 	// CONSTRUCTORS
 	///////////////////////////////////////////////////////////////////////////////////////////////////////
 	
 	
 	/**
 	 * Constructor. For the parameters you need to run the api keys task.
 	 * This will url encode all the strings. So no worries about that. 
 	 * We got ya covered.
 	 * 
 	 * @param String $by
 	 */
 	public function __construct($by)
    {
    	parent::__construct("apikeys");
    	
    	$this->by = $by;    	
        
    }
    
    
 	
 	
    
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
 	// GETTERS AND SETTERS
 	///////////////////////////////////////////////////////////////////////////////////////////////////////
    
    /**
     * 
     * Gets the by parameter
     */
    public function getBy() { return $this->by; }
    /**
     * Sets the By parameter
     * @param String $x
     */
	public function setBy($x) { $this->by = $x; }

	
	 	
 	/**
 	 * Creates the POST/GET query string
 	 * (non-PHPdoc)
 	 * @see Ushahidi_API_Library.Task_Parameter_Base::get_query_string()
 	 */
 	public function get_query_string()
 	{
 		$queryStr = array();
 		$queryStr["task"] = $this->task_name;
 		
		$queryStr["by"] = $this->by;
		
		return $queryStr;
 		
 	}
    
    
 	
 }    