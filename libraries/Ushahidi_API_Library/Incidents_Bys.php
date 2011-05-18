<?php namespace Ushahidi_API_Library;
defined('SYSPATH') or die('No direct script access allowed'); 
/**
 * This class is to define the differen types of Bys that you can use to get incidents
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


class Incidents_Bys 
 {

 	const SHOW_ALL_INCIDENTS = "all";
 	const BY_CATEGORY_ID = "catid";
 	const BY_CATEGORY_NAME = "catname";
 	const BY_LOCATION_ID = "locid";
 	const BY_LOCATION_NAME = "locname";
 	const INCIDENTS_SINCE_ID = "sinceid";
 	const BY_INCIDENT_ID = "incidentid";
 	const BY_BOUNDS = "bounds";
    
    
    
 }