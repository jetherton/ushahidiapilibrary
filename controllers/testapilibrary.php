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

class Testapilibrary_Controller extends Controller {
	
	
	function index()
	{
		
		echo "<html><head><title>Ushahidi API Library Test</title></head>";

		$siteInfo = new SiteInfo(url::base()."api");
		
		echo "<strong>URL:</strong> ". $siteInfo->getUrl(). "<br/><br/><br/>";
		
		
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
		
		echo "<strong>Query String:</strong> ". $reportParams->get_query_string() . "<br/><br/><br/>";
		
		echo "<strong>JSON:</strong> ". $reportTask->getJson() . "<br/><br/><br/>";
		echo "<strong>Code:</strong> ". $reportResponse->getError_code() . " <strong>Message:</strong> ". $reportResponse->getError_message();
		
		echo "</html>";
	}
}
