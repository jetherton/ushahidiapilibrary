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

use Ushahidi_API_Library\Site_Info as SiteInfo;
use Ushahidi_API_Library\Report_Task_Parameter as ReportParam;
use Ushahidi_API_Library\Report_Task as ReportTask;
use Ushahidi_API_Library\Report_Response as ReportResponse;

use Ushahidi_API_Library\Api_Key_Task_Parameter as ApiParam;
use Ushahidi_API_Library\Api_Key_Task as ApiTask;
use Ushahidi_API_Library\Api_Key_Response as ApiResponse;


use Ushahidi_API_Library\Categories_Task_Parameter as CategoriesParam;
use Ushahidi_API_Library\Categories_Task as CategoriesTask;
use Ushahidi_API_Library\Categories_Response as CategoriesResponse;

use Ushahidi_API_Library\Incidents_Task_Parameter as IncidentsParam;
use Ushahidi_API_Library\Incidents_Task as IncidentsTask;
use Ushahidi_API_Library\Incidents_Response as IncidentsResponse;
use Ushahidi_API_Library\Incidents_Bys as IncidentBys;


class Testapilibrary_Controller extends Controller {
	
	
	function index()
	{
		
		echo "<html><head><title>Ushahidi API Library Test</title></head>";

		$this->testIncidentsAll();
		$this->testCategories1();
		$this->testCategories();		
		$this->testApiKeys();
		$this->testCopyFromScratch();
		$this->testCopyExistingReport();
		
		
		echo "</html>";
	}
	
	
	private function testIncidentsAll()
	{
		$siteInfo = new SiteInfo(url::base()."api");
		
		echo "<h1>Incidents, All</h1><strong>URL:</strong> ". $siteInfo->getUrl(). "<br/><br/>";
		
		$params = new IncidentsParam();
		$params->setBy(IncidentBys::SHOW_ALL_INCIDENTS);
		
		echo "<strong>Query String:</strong> ". Kohana::debug($params->get_query_string()) . "<br/><br/>";
		
		$task = new IncidentsTask($params, $siteInfo);
		$response = $task->execute();
		
		echo "<strong>JSON:</strong> ". $task->getJson() . "<br/><br/>";
		echo "<strong>Code:</strong> ". $response->getError_code() . " <strong>Message:</strong> ". $response->getError_message() . "<br/><br/>";
		foreach($response->getIncidents() as $cat)
		{
			echo "Category Name: ". $cat->category_title. "<br/>";
		}
	}
	
	
	
	private function testCategories1()
	{
		$siteInfo = new SiteInfo(url::base()."api");
		
		echo "<h1>Categories By ID</h1><strong>URL:</strong> ". $siteInfo->getUrl(). "<br/><br/>";
		
		$params = new CategoriesParam("1");
		
		echo "<strong>Query String:</strong> ". Kohana::debug($params->get_query_string()) . "<br/><br/>";
		
		$task = new CategoriesTask($params, $siteInfo);
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
		$siteInfo = new SiteInfo(url::base()."api");
		
		echo "<h1>Categories</h1><strong>URL:</strong> ". $siteInfo->getUrl(). "<br/><br/>";
		
		$params = new CategoriesParam();
		
		$task = new CategoriesTask($params, $siteInfo);
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
		$siteInfo = new SiteInfo(url::base()."api");
		
		echo "<h1>API Keys</h1><strong>URL:</strong> ". $siteInfo->getUrl(). "<br/><br/>";
		
		$params = new ApiParam("google");
		
		$task = new ApiTask($params, $siteInfo);
		$response = $task->execute();
		
		echo "<strong>Query String:</strong> ". Kohana::debug($params->get_query_string()) . "<br/><br/>";
		echo "<strong>JSON:</strong> ". $task->getJson() . "<br/><br/>";
		echo "<strong>Code:</strong> ". $response->getError_code() . " <strong>Message:</strong> ". $response->getError_message() . "<br/><br/>";
		echo "<strong>API:</strong> ". $response->getApi_key() . " <strong>ID:</strong> ". $response->getId();
	}
	
	private function testCopyFromScratch()
	{
		$siteInfo = new SiteInfo(url::base()."api");
		
		echo "<h1>Create new report from Scratch</h1><strong>URL:</strong> ". $siteInfo->getUrl(). "<br/><br/><br/>";
		
		
		$reportParams = new ReportParam(
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
		
		$reportTask = new ReportTask($reportParams, $siteInfo);
		$reportResponse = $reportTask->execute();
		
		echo "<strong>Query String:</strong> ". Kohana::debug($reportParams->get_query_string()) . "<br/><br/><br/>";
		
		echo "<strong>JSON:</strong> ". $reportTask->getJson() . "<br/><br/><br/>";
		echo "<strong>Code:</strong> ". $reportResponse->getError_code() . " <strong>Message:</strong> ". $reportResponse->getError_message();	
	}
	
	
	
	private function testCopyExistingReport()
	{
				$siteInfo = new SiteInfo(url::base()."api");
		
		echo "<br/><br/><br/><br/><h1>Copy an existing report</h1><strong>URL:</strong> ". $siteInfo->getUrl(). "<br/><br/><br/>";
		
		
		$report = ORM::factory('incident')->find();
		
		echo "<strong>Coping Report With ID:</strong> ". $report->id."<br/><br/>";  
		
		$reportParams = ReportParam::fromORM($report);
		
		$reportTask = new ReportTask($reportParams, $siteInfo);
		$reportResponse = $reportTask->execute();
		
		echo "<strong>Query String:</strong> ". Kohana::debug($reportParams->get_query_string()) . "<br/><br/><br/>";
		
		echo "<strong>JSON:</strong> ". $reportTask->getJson() . "<br/><br/><br/>";
		echo "<strong>Code:</strong> ". $reportResponse->getError_code() . " <strong>Message:</strong> ". $reportResponse->getError_message();
	}
}
