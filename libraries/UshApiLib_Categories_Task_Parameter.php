<?php 
defined('SYSPATH') or die('No direct script access allowed');
/**
 * This class is used to encapuslate the parameters needed to execute the Categories task on the Ushahidi API
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




 class UshApiLib_Categories_Task_Parameter extends UshApiLib_Task_Parameter_Base
 {
 	
 	///////////////////////////////////////////////////////////////////////////////////////////////////////
 	// INSTANCE VARIABLES
 	///////////////////////////////////////////////////////////////////////////////////////////////////////
    
 	// A string representing the id of the category in question
 	private $id = null;
 	
 	
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
 	public function __construct($id = null)
    {
    	parent::__construct("categories");
    	
    	$this->id = $id;    	
        
    }
    
    
 	
 	
    
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
 	// GETTERS AND SETTERS
 	///////////////////////////////////////////////////////////////////////////////////////////////////////
    
    /**
     * 
     * Gets the by parameter
     */
    public function getId() { return $this->id; }
    /**
     * Sets the Id parameter
     * @param String $x
     */
	public function setId($x) { $this->id = $x; }

	
	 	
 	/**
 	 * Creates the POST/GET query string
 	 * (non-PHPdoc)
 	 * @see Ushahidi_API_Library.Task_Parameter_Base::get_query_string()
 	 */
 	public function get_query_string()
 	{
 		$queryStr = array();
 		$queryStr["task"] = $this->task_name;
 		
 		if($this->id != null)
 		{
 			$queryStr["by"] = "catid";
			$queryStr["id"] = $this->id;
 		}
		
		return $queryStr;
 		
 	}
    
    
 	
 }    