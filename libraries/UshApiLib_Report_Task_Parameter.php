<?php 
defined('SYSPATH') or die('No direct script access allowed');
/**
 * This class is used to encapuslate the parameters needed to execute the report task on the Ushahidi API
 *
 * @version 02 - John Etherton 2011-05-17
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




 class UshApiLib_Report_Task_Parameter extends UshApiLib_Task_Parameter_Base
 {
 	
 	///////////////////////////////////////////////////////////////////////////////////////////////////////
 	// INSTANCE VARIABLES
 	///////////////////////////////////////////////////////////////////////////////////////////////////////
    
 	// The title of the incident. Why does ushahidi call it a report and an incident?
 	private $incident_title = null;
 	
 	//The description of the incident
 	private $incident_description = null;
 	
 	//The date the incident occured
 	private $incident_date = null;
 	
 	//The hour the incident occured
 	private $incident_hour = null;
 	
 	//The minute the incident occured
 	private $incident_minute = null;
 	
 	//was this time am or pm
 	private $incident_ampm = null;
 	
 	//A comma seperated list of category IDs that this incident was assigned to
 	private $incident_category = null;
 	
 	//The latitude of the incident
 	private $latitude = null;
 	
 	//The longitude of the incident
 	private $longitude = null;
 	
 	//The location of the incident/report
 	private $location_name = null; 	
 	
 	//////////////////////////////////////////////
 	//Optional parameters
 	//////////////////////////////////////////////
 	
 	//The first name of the person submitting the incident 	
 	private $person_first = null;
 	
 	//The last name of the person submitting the incident
 	private $person_last = null;
 	
 	//The email of the person submitting the incident
 	private $person_email = null;
 	
 	//Binary data of photos that accompany this incident
 	private $incident_photo = null;
 	
 	//A news source regarding the incident/report. A news feed.
 	private $incident_news = null;
 	
 	//A video link regarding the incident/report. Video services like youtube.com, video.google.com, metacafe.com,etc
 	private $incident_video = null;
 	
 	
 	
 	/////////////////////////////////////////////////////////////////////////////////////////////////////////
 	// CONSTRUCTORS
 	///////////////////////////////////////////////////////////////////////////////////////////////////////
 	
 	
 	/**
 	 * Constructor. For the parameters you need to run the report task.
 	 * This will url encode all the strings. So no worries about that. 
 	 * We got ya covered.
 	 * 
 	 * @param String $incident_title
 	 * @param String $incident_description
 	 * @param String $incident_date
 	 * @param String $incident_hour
 	 * @param String $incident_minute
 	 * @param String $incident_ampm
 	 * @param String $incident_category
 	 * @param String $latitude
 	 * @param String $longitude
 	 * @param String $location_name
 	 * @param String $person_first
 	 * @param String $person_last
 	 * @param String $person_email
 	 * @param Binary[] $incident_photo
 	 * @param String $incident_news
 	 * @param String $incident_video
 	 */
 	public function __construct($incident_title, $incident_description, $incident_date, $incident_hour, $incident_minute,
 		$incident_ampm, $incident_category, $latitude, $longitude, $location_name, $person_first = null, $person_last = null,
 		$person_email = null, $incident_photo = null, $incident_news = null, $incident_video = null)
    {
    	parent::__construct("report");
    	
    	$this->incident_title = $incident_title;
    	$this->incident_description = $incident_description;
    	$this->incident_date = $incident_date;
    	$this->incident_hour = $incident_hour;
    	$this->incident_minute = $incident_minute;
    	$this->incident_ampm = $incident_ampm;
    	$this->incident_category = $incident_category;
    	$this->latitude = $latitude;
    	$this->longitude = $longitude;
    	$this->location_name = $location_name;
    	$this->person_first = $person_first;
    	$this->person_last = $person_last;
    	$this->person_email = $person_email;
    	$this->incident_photo = $incident_photo;
    	$this->incident_news = $incident_news;
    	$this->incident_video = $incident_video;
    	
        
    }
    
    
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
 	// STATIC FACTORIES
 	///////////////////////////////////////////////////////////////////////////////////////////////////////
 	
    /**
     * This function takes a ORM incident model and creates the required parameter for the report task.
     * 
     * @param ORM Object of an Ushahidi incident $incident
     */
 	public static function fromORM($incident)
 	{
 		
 		$category_str = "";
 		$i = 0;
 		foreach($incident->incident_category as $cat)
 		{
 			$i++;
 			if($i > 1)
 			{
 				$category_str .=",";
 			}
 			$category_str .= $cat->category->id;
 		}
 		
 		
 		$retVal =  new UshApiLib_Report_Task_Parameter($incident->incident_title, 
 			$incident->incident_description, 
 			date("m/d/Y", strtotime($incident->incident_date)), 
 			date("h",strtotime($incident->incident_date)), 
 			date("i", strtotime($incident->incident_date)), 
 			date("a", strtotime($incident->incident_date)), 
 			$category_str, 
 			$incident->location->latitude, 
 			$incident->location->longitude, 
 			$incident->location->location_name);
 			
 		if(isset($incident->incident_person->person_first))
 		{ $retVal->setPerson_first($incident->incident_person->person_first);}
 		
 		if(isset($incident->incident_person->person_last))
 		{ $retVal->setPerson_last($incident->incident_person->person_last);}
 		
 		if(isset($incident->incident_person->person_email))
 		{ $retVal->setPerson_email($incident->incident_person->person_email);}
 		
 		//save the media elements
 		foreach($incident->media as $media)
		{
			switch ($media->media_type)
			{
				case 4:
					$retVal->addIncident_news($media->media_link);
					break;
				case 2:
					$retVal->addIncident_video($media->media_link);
					break;
				case 1:
					$retVal->addIncident_photo("@".\Kohana::config('upload.directory', TRUE).$media->media_link);
					break;
					
			}			
		}
 		
 		return $retVal;
 		
 	}
 	
 	
    
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
 	// GETTERS AND SETTERS
 	///////////////////////////////////////////////////////////////////////////////////////////////////////
    
    /**
     * 
     * Gets the incident title
     */
    public function getIncident_title() { return $this->incident_title; }
    /**
     * 
     * Gets the indicent description
     */ 
	public function getIncident_description() { return $this->incident_description; }
	/**
	 * 
	 * Gets the incident date
	 */ 
	public function getIncident_date() { return $this->incident_date; }
	/**
	 * Gets the incident hour
	 */ 
	public function getIncident_hour() { return $this->incident_hour; }
	/**
	 * Gets the incident minute 
	 */
	public function getIncident_minute() { return $this->incident_minute; }
	/**
	 * Gets the am or pm 
	 */ 
	public function getincident_ampm() { return $this->incident_ampm; } 
	/**
	 * Gets the category as a comma seperate string of category names 
	 */
	public function getIncident_category() { return $this->incident_category; }
	/**
	 * Gets the latitude of the incident 
	 */ 
	public function getLatitude() { return $this->latitude; }
	/**
	 * Gets the longitude of the incident 
	 */ 
	public function getLongitude() { return $this->longitude; }
	/**
	 * Gets the location name 
	 */ 
	public function getLocation_name() { return $this->location_name; }
	/**
	 * Gets the person who reported this incident's first name 
	 */ 
	public function getPerson_first() { return $this->person_first; }
	/**
	 * Gets the person who reported this incident's last name 
	 */  
	public function getPerson_last() { return $this->person_last; }
	/**
	 * Gets the person who reported this incident's email 
	 */  
	public function getPerson_email() { return $this->person_email; }
	/**
	 * Gets the photos associated with this report 
	 */  
	public function getincident_photo() { return $this->incident_photo; }
	/**
	 * Gets the news link associated with this report 
	 */   
	public function getIncident_news() { return $this->incident_news; }
	/**
	 * Gets the video link associated with this report 
	 */   
	public function getIncident_video() { return $this->incident_video; } 
	
	/**
	 * Sets the incident title
	 * @param Stringe $x
	 */
	public function setIncident_title($x) { $this->incident_title = $x; }
	/**
	 * Sets the incident description
	 * @param Stringe $x
	 */ 
	public function setIncident_description($x) { $this->incident_description = $x; }
	/**
	 * Sets the incident date
	 * @param Stringe $x
	 */ 
	public function setIncident_date($x) { $this->incident_date = $x; }
	/**
	 * Sets the incident hour
	 * @param Stringe $x
	 */ 
	public function setIncident_hour($x) { $this->incident_hour = $x; }
	/**
	 * Sets the incident minute
	 * @param Stringe $x
	 */ 
	public function setIncident_minute($x) { $this->incident_minute = $x; }
	/**
	 * Sets the incident am or pm
	 * @param Stringe $x
	 */ 
	public function setincident_ampm($x) { $this->incident_ampm = $x; }
	/**
	 * Sets the incident category with a comma seperated string of category IDs
	 * @param Stringe $x
	 */ 
	public function setIncident_category($x) { $this->incident_category = $x; }
	/**
	 * Sets the incident latitude
	 * @param Stringe $x
	 */ 
	public function setLatitude($x) { $this->latitude = $x; }
	/**
	 * Sets the incident longitude
	 * @param Stringe $x
	 */ 
	public function setLongitude($x) { $this->longitude = $x; }
	/**
	 * Sets the incident location name
	 * @param Stringe $x
	 */ 
	public function setLocation_name($x) { $this->location_name = $x; }
	/**
	 * Sets the incident reporters first name
	 * @param Stringe $x
	 */ 
	public function setPerson_first($x) { $this->person_first = $x; }
	/**
	 * Sets the incident reporters last name
	 * @param Stringe $x
	 */ 
	public function setPerson_last($x) { $this->person_last = $x; }
	/**
	 * Sets the incident reporters email
	 * @param Stringe $x
	 */ 
	public function setPerson_email($x) { $this->person_email = $x; }
	/**
	 * Sets the incident photos - use an array of full file names prefixed with a "@"
	 * @param String[] $x
	 */ 
	public function setincident_photo($x) { $this->incident_photo = $x; }
 	/**
	 * Lets you add a new photo file name string. Must be full filename prefixed with a "@"
	 * This will handle the creation and manipulation of the underlying array
	 * @param String $x
	 */
	public function addIncident_photo($x) 
	{ 
		if(!is_array($this->incident_photo))
		{
			$this->incident_photo = array();
		}
		$this->incident_photo[] = $x; 
	}
	/**
	 * Sets the incident news link
	 * @param String[] $x
	 */
	public function setIncident_news($x)  {$this->incident_news = $x; } 
	/**
	 * Lets you add a new news item link as a string.
	 * This will handle the creation and manipulation of the underlying array
	 * @param String $x
	 */
	public function addIncident_news($x) 
	{ 
		if(!is_array($this->incident_news))
		{
			$this->incident_news = array();
		}
		$this->incident_news[] = $x; 
	}
	/**
	 * Sets the incident video link
	 * @param Stringe $x
	 */ 
	public function setIncident_video($x) { $this->incident_video = $x; }
 	/**
	 * Lets you add a new video item link as a string.
	 * This will handle the creation and manipulation of the underlying array
	 * @param String $x
	 */
	public function addIncident_video($x) 
	{ 
		if(!is_array($this->incident_video))
		{
			$this->incident_video = array();
		}
		$this->incident_video[] = $x; 
	}

	
	 	
 	/**
 	 * Creates the POST/GET query string
 	 * (non-PHPdoc)
 	 * @see Ushahidi_API_Library.Task_Parameter_Base::get_query_string()
 	 */
 	public function get_query_string()
 	{
 		$queryStr = array();
 		$queryStr["task"] = $this->task_name;
 		
		$queryStr["incident_title"] = $this->incident_title;
		$queryStr["incident_description"] = $this->incident_description;
		$queryStr["incident_date"] = $this->incident_date;
		$queryStr["incident_hour"] = $this->incident_hour;
		$queryStr["incident_minute"] = $this->incident_minute;
		$queryStr["incident_ampm"] = $this->incident_ampm;
		$queryStr["incident_category"] = $this->incident_category;
		$queryStr["latitude"] = $this->latitude;
		$queryStr["longitude"] = $this->longitude;
		$queryStr["location_name"] = $this->location_name;
 		
 		
 		
		if($this->person_first != null)
		{
			$queryStr["person_first"] = $this->person_first;
		}
 		if($this->person_last != null)
		{
			$queryStr["person_last"] = $this->person_last;
		}
 		if($this->person_email != null)
		{
			$queryStr["person_email"] = $this->person_email;
		}
		
 		if(is_array($this->incident_news))
		{	
			$i = 0;
			foreach($this->incident_news as $news)
			{
				$queryStr["incident_news[$i]"] =  $news;
				$i++;	
			}
			
		}
		
 		if(is_array($this->incident_video))
		{
			$i = 0;
			foreach($this->incident_video as $video)
			{
				$queryStr["incident_video[$i]"] = $video;
				$i++;	
			}
			
		}
		
 		if(is_array($this->incident_photo))
		{
			$i = 0;
			foreach($this->incident_photo as $photo)
			{
				$queryStr["incident_photo[$i]"] = $photo;
				$i++;	
			}
			
		}
		
		
		return $queryStr;
 		
 	}
    
    
 	
 }    