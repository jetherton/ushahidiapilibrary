<?php defined('SYSPATH') or die('No direct script access allowed'); 
/**
 * This class is used to test the Ushahidi API Library
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



class Testapilibrary_Controller extends Controller {
	
	
	function index()
	{
		//This is for debugging and development only. Be sure this is commented out in production sites
		echo "<html><head><title>Ushahidi API Library Test</title></head>";
		$this->testIncidentsByBounds();
		$this->testIncidentsByCategoryName();
		$this->testIncidentsById();
		$this->testIncidentsAll();
		$this->testCategories1();
		$this->testCategories();
		$this->testApiKeys();
		$this->testCopyFromScratch();
		$this->testCopyExistingReport();		
		
		echo "</html>";
		
	}
	
	
	private function testIncidentsByBounds()
	{
		$UshApiLib_Site_Info = new UshApiLib_Site_Info(url::base()."api");
		
		echo "<h1>Incidents, By Bounds</h1><strong>URL:</strong> ". $UshApiLib_Site_Info->getUrl(). "<br/><br/>";
		
		$params = new UshApiLib_Incidents_Task_Parameter();
		$params->setBy(UshApiLib_Incidents_Bys::BY_BOUNDS);
		$params->setNe("-8,9");
		$params->setSw("-12,4");
		$params->setC(1);
		
		
		echo "<strong>Query String:</strong> ". Kohana::debug($params->get_query_string()) . "<br/><br/>";
		
		$task = new UshApiLib_Incidents_Task($params, $UshApiLib_Site_Info);
		$response = $task->execute();
		
		echo "<strong>JSON:</strong> ". $task->getJson() . "<br/><br/>";
		echo "<strong>Code:</strong> ". $response->getError_code() . " <strong>Message:</strong> ". $response->getError_message() . "<br/><br/>";
		foreach($response->getIncidents() as $cat)
		{
			echo "Incident Title: ". $cat["incident"]->incident_title. "<br/>";
		}
	}
	
	private function testIncidentsByCategoryName()
	{
		$UshApiLib_Site_Info = new UshApiLib_Site_Info(url::base()."api");
		
		echo "<h1>Incidents, By Category Name</h1><strong>URL:</strong> ". $UshApiLib_Site_Info->getUrl(). "<br/><br/>";
		
		$params = new UshApiLib_Incidents_Task_Parameter();
		$params->setBy(UshApiLib_Incidents_Bys::BY_CATEGORY_NAME);
		$params->setName("Category 2");
		
		echo "<strong>Query String:</strong> ". Kohana::debug($params->get_query_string()) . "<br/><br/>";
		
		$task = new UshApiLib_Incidents_Task($params, $UshApiLib_Site_Info);
		$response = $task->execute();
		
		echo "<strong>JSON:</strong> ". $task->getJson() . "<br/><br/>";
		echo "<strong>Code:</strong> ". $response->getError_code() . " <strong>Message:</strong> ". $response->getError_message() . "<br/><br/>";
		foreach($response->getIncidents() as $cat)
		{
			echo "Incident Title: ". $cat["incident"]->incident_title. "<br/>";
		}
	}
	
	
	
	
	private function testIncidentsById()
	{
		$UshApiLib_Site_Info = new UshApiLib_Site_Info(url::base()."api");
		
		echo "<h1>Incidents, By ID</h1><strong>URL:</strong> ". $UshApiLib_Site_Info->getUrl(). "<br/><br/>";
		
		$params = new UshApiLib_Incidents_Task_Parameter();
		$params->setBy(UshApiLib_Incidents_Bys::BY_INCIDENT_ID);
		$params->setId(81);
		
		echo "<strong>Query String:</strong> ". Kohana::debug($params->get_query_string()) . "<br/><br/>";
		
		$task = new UshApiLib_Incidents_Task($params, $UshApiLib_Site_Info);
		$response = $task->execute();
		
		echo "<strong>JSON:</strong> ". $task->getJson() . "<br/><br/>";
		echo "<strong>Code:</strong> ". $response->getError_code() . " <strong>Message:</strong> ". $response->getError_message() . "<br/><br/>";
		foreach($response->getIncidents() as $cat)
		{
			echo "Incident Title: ". $cat["incident"]->incident_title. "<br/>";
		}
	}
	
	
	private function testIncidentsAll()
	{
		$UshApiLib_Site_Info = new UshApiLib_Site_Info(url::base()."api");
		
		
		echo "<h1>Incidents, All</h1><strong>URL:</strong> ". $UshApiLib_Site_Info->getUrl(). "<br/><br/>";
		$params = new UshApiLib_Incidents_Task_Parameter();
		$params->setBy(UshApiLib_Incidents_Bys::SHOW_ALL_INCIDENTS);
		
		echo "<strong>Query String:</strong> ". Kohana::debug($params->get_query_string()) . "<br/><br/>";
		
		$task = new UshApiLib_Incidents_Task($params, $UshApiLib_Site_Info);
		$response = $task->execute();
		
		echo "<strong>JSON:</strong> ". $task->getJson() . "<br/><br/>";
		echo "<strong>Code:</strong> ". $response->getError_code() . " <strong>Message:</strong> ". $response->getError_message() . "<br/><br/>";
		foreach($response->getIncidents() as $cat)
		{
			echo "Incident Title: ". $cat["incident"]->incident_title. "<br/>";
		}
	}
	
	
	
	private function testCategories1()
	{
		$UshApiLib_Site_Info = new UshApiLib_Site_Info(url::base()."api");
		
		echo "<h1>Categories By ID</h1><strong>URL:</strong> ". $UshApiLib_Site_Info->getUrl(). "<br/><br/>";
		
		$params = new UshApiLib_Categories_Task_Parameter("1");
		
		echo "<strong>Query String:</strong> ". Kohana::debug($params->get_query_string()) . "<br/><br/>";
		
		$task = new UshApiLib_Categories_Task($params, $UshApiLib_Site_Info);
		$response = $task->execute();
		
		echo "<strong>JSON:</strong> ". $task->getJson() . "<br/><br/>";
		echo "<strong>Code:</strong> ". $response->getError_code() . " <strong>Message:</strong> ". $response->getError_message() . "<br/><br/>";
		foreach($response->getCategories() as $cat)
		{
			echo "Category Name: ". $cat->category_title. "<br/>";
		}
	}
	
	
	
	private function testCategories()
	{
		$UshApiLib_Site_Info = new UshApiLib_Site_Info(url::base()."api");
		
		echo "<h1>Categories</h1><strong>URL:</strong> ". $UshApiLib_Site_Info->getUrl(). "<br/><br/>";
		
		$params = new UshApiLib_Categories_Task_Parameter();
		
		$task = new UshApiLib_Categories_Task($params, $UshApiLib_Site_Info);
		$response = $task->execute();
		
		echo "<strong>Query String:</strong> ". Kohana::debug($params->get_query_string()) . "<br/><br/>";
		echo "<strong>JSON:</strong> ". $task->getJson() . "<br/><br/>";
		echo "<strong>Code:</strong> ". $response->getError_code() . " <strong>Message:</strong> ". $response->getError_message() . "<br/><br/>";
		foreach($response->getCategories() as $cat)
		{
			echo "Category Name: ". $cat->category_title. "<br/>";
		}
	}
	
	
	
	
	private function testApiKeys()
	{
		$UshApiLib_Site_Info = new UshApiLib_Site_Info(url::base()."api");
		
		echo "<h1>API Keys</h1><strong>URL:</strong> ". $UshApiLib_Site_Info->getUrl(). "<br/><br/>";
		
		$params = new UshApiLib_Api_Key_Task_Parameter("google");
		
		$task = new UshApiLib_Api_Key_Task($params, $UshApiLib_Site_Info);
		$response = $task->execute();
		
		echo "<strong>Query String:</strong> ". Kohana::debug($params->get_query_string()) . "<br/><br/>";
		echo "<strong>JSON:</strong> ". $task->getJson() . "<br/><br/>";
		echo "<strong>Code:</strong> ". $response->getError_code() . " <strong>Message:</strong> ". $response->getError_message() . "<br/><br/>";
		echo "<strong>API:</strong> ". $response->getApi_key() . " <strong>ID:</strong> ". $response->getId();
	}
	
	private function testCopyFromScratch()
	{
		$UshApiLib_Site_Info = new UshApiLib_Site_Info(url::base()."api");
		
		echo "<h1>Create new report from Scratch</h1><strong>URL:</strong> ". $UshApiLib_Site_Info->getUrl(). "<br/><br/><br/>";
		
		
		$reportParams = new UshApiLib_Report_Task_Parameter(
			"Test report title -- ".  date('l jS \of F Y h:i:s A'),
			"Test report description -- ".  date('l jS \of F Y h:i:s A'),
			date("m/d/Y"),
			date("h"),
			date("i"),
			date("a"),
			"Category 1",
			"6",
			"-11",
			"Liberia");
		
		$reportTask = new UshApiLib_Report_Task($reportParams, $UshApiLib_Site_Info);
		$reportResponse = $reportTask->execute();
		
		echo "<strong>Query String:</strong> ". Kohana::debug($reportParams->get_query_string()) . "<br/><br/><br/>";
		
		echo "<strong>JSON:</strong> ". $reportTask->getJson() . "<br/><br/><br/>";
		echo "<strong>Code:</strong> ". $reportResponse->getError_code() . " <strong>Message:</strong> ". $reportResponse->getError_message();	
	}
	
	
	
	private function testCopyExistingReport()
	{
				$UshApiLib_Site_Info = new UshApiLib_Site_Info(url::base()."api");
		
		echo "<br/><br/><br/><br/><h1>Copy an existing report</h1><strong>URL:</strong> ". $UshApiLib_Site_Info->getUrl(). "<br/><br/><br/>";
		
		
		$report = ORM::factory('incident')->find();
		
		echo "<strong>Coping Report With ID:</strong> ". $report->id."<br/><br/>";  
		
		$reportParams = UshApiLib_Report_Task_Parameter::fromORM($report);
		
		$reportTask = new UshApiLib_Report_Task($reportParams, $UshApiLib_Site_Info);
		$reportResponse = $reportTask->execute();
		
		echo "<strong>Query String:</strong> ". Kohana::debug($reportParams->get_query_string()) . "<br/><br/><br/>";
		
		echo "<strong>JSON:</strong> ". $reportTask->getJson() . "<br/><br/><br/>";
		echo "<strong>Code:</strong> ". $reportResponse->getError_code() . " <strong>Message:</strong> ". $reportResponse->getError_message();
	}
}
