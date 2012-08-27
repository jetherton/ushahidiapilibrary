<?php 
defined('SYSPATH') or die('No direct script access allowed');
/**
 * This class is used to encapuslate the parameters needed to execute the Incidents task on the Ushahidi API
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




 class UshApiLib_Incidents_Task_Parameter extends UshApiLib_Task_Parameter_Base
 {
 	
 	///////////////////////////////////////////////////////////////////////////////////////////////////////
 	// INSTANCE VARIABLES
 	///////////////////////////////////////////////////////////////////////////////////////////////////////
    
 	// Use the Incidents_By class to specify what kind of by is needed
 	private $by;
 	
 	//The ID parameter when the BY is catid, locid, or sinceid, incidentid
 	private $id;

 	//The name parameter when the BY is catname, locname, 
 	private $name;
 	
 	//the category ID paramter when the BY is bounds
 	private $c;
 	
 	//the South West corner parameter when the BY is bounds
 	private $sw;
 	
 	//The North East corner paramter when the BY is bounds
 	private  $ne;
 	
 	//Which field to order the results by
 	private $orderField;
 	
 	//The number of incidents the user wants back
 	private $limit;
 	
 	//set how you want things sorted
 	private $sort; 
 	
 	
 	/////////////////////////////////////////////////////////////////////////////////////////////////////////
 	// CONSTRUCTORS
 	///////////////////////////////////////////////////////////////////////////////////////////////////////
 	
 	
 	/**
 	 * Constructor. Normally this would accept all the required fields, but since
 	 * there are so many different combinations with this particular task I'm
 	 * going to leave it up to the users to set the parameters with the setters.
 	 * 
 	 * @param String $by
 	 */
 	public function __construct()
    {
    	parent::__construct("incidents");
        
    }
    
    
 	
 	
    
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
 	// GETTERS AND SETTERS
 	///////////////////////////////////////////////////////////////////////////////////////////////////////
    
	public function getBy() { return $this->by; } 
	public function getId() { return $this->id; } 
	public function getName() { return $this->name; } 
	public function getC() { return $this->c; } 
	public function getSw() { return $this->sw; } 
	public function getNe() { return $this->ne; } 
	public function getOrderField() { return $this->orderField; } 
	public function getLimit() { return $this->limit; } 
	public function getSort() { return $this->sort; } 
	
	/**
	 * 
	 * Set the "by" parameter use the UshApiLib_Incidents_Bys class to set this field
	 * @param consts from UshApiLib_Incidents_Bys $x
	 */
	public function setBy($x) { $this->by = $x; } 
	/**
	 * 
	 * The ID parameter when the BY is catid, locid, or sinceid, incidentid
	 * @param String $x
	 */
	public function setId($x) { $this->id = $x; }
	/**
	 * 
	 * The name parameter when the BY is catname, locname,
	 * @param unknown_type $x
	 */ 
	public function setName($x) { $this->name = $x; }
	/**
	 * 
	 *the category ID paramter when the BY is bounds 
	 * @param String $x
	 */ 
	public function setC($x) { $this->c = $x; }
	/**
	 * 
	 * Sets the South West corner parameter when the BY is bounds (-11.44) 
	 * @param String $x
	 */ 
	public function setSw($x) { $this->sw = $x; } 
	/**
	 * The North East corner paramter when the BY is bounds (34.33)
	 * @param String $x
	 */
	public function setNe($x) { $this->ne = $x; } 
	/**
	 * 
	 * Which field to order the results by, corresponds to fields in the database
	 * @param string $x
	 */
	public function setOrderField($x) { $this->orderField = $x; }
	/**
	 * 
	 * The number of incidents the user wants back
	 * @param Int $x
	 */ 
	public function setLimit($x) { $this->limit = $x; }
	/**
	 * 
	 * set how you want things sorted, 0 - Ascending, 1 - Descending
	 * @param int $x
	 */ 
	public function setSort($x) { $this->sort = $x; } 

	
	 	
 	/**
 	 * Creates the POST/GET query string
 	 * (non-PHPdoc)
 	 * @see Ushahidi_API_Library.Task_Parameter_Base::get_query_string()
 	 */
 	public function get_query_string()
 	{
 		$queryStr = array();
 		$queryStr["task"] = $this->task_name;
 		$queryStr["resp"] = $this->resp;
 		$queryStr["by"] = $this->by;
 		
 		
 		switch($this->by)
 		{
 			
 			case UshApiLib_Incidents_Bys::BY_CATEGORY_ID:
 			case UshApiLib_Incidents_Bys::BY_INCIDENT_ID:
 			case UshApiLib_Incidents_Bys::BY_LOCATION_ID:
 			case UshApiLib_Incidents_Bys::INCIDENTS_SINCE_ID:
 				$queryStr["id"] = $this->id;
 				break;
 				
 			case UshApiLib_Incidents_Bys::BY_CATEGORY_NAME:
 			case UshApiLib_Incidents_Bys::BY_LOCATION_NAME:
 				$queryStr["name"] = $this->name;
 				break;
 			
 			case UshApiLib_Incidents_Bys::BY_BOUNDS:
 				if($this->c != null)
 				{
 					$queryStr["c"] = $this->c;
 				}
 				$queryStr["sw"] = $this->sw;
 				$queryStr["ne"] = $this->ne;
 		}
 		
 		if($this->orderField != null)
 		{
 			$queryStr["orderfield"] = $this->orderField;
 		}
 		
 		if($this->sort !== null)
 		{
 			$queryStr["sort"] = $this->sort;
 		}
 		
 		if($this->limit != null)
 		{
 			$queryStr["limit"] = $this->limit;
 		}
		
		return $queryStr;
 		
 	}
    
    
 	
 }    