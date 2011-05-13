<?php namespace Ushahidi_API_Library;
defined('SYSPATH') or die('No direct script access allowed'); 
/**
 * This class is used to define the Ushahidi site API calls are being made against
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


class Site_Info extends Ushahidi_API_Library_Base
{
	//url of the site, don't forget http://
	private $url;
	
	//user name, not yet supported by the API, but it'll come
	private $username;
	
	//password, not yet supported by the API, but it'll come
	private $password;
	
	/**
	 * You're classic parameterized constructor
	 * 
	 * @param String $url
	 * @param String $username
	 * @param String $password
	 */
	public function __construct($url, $username = null, $password = null)
    {
    	$this->url = $url;
    	$this->username = $username;
    	$this->password = $password;
    }
    
    
    
    /**
     * Gets the site URL
     */
    public function geturl() { return $this->url; } 
	/**
     * Gets the site user name
     */
    public function getUsername() { return $this->username; } 
	/**
     * Gets the site password
     */
    public function getPassword() { return $this->password; } 
	/**
     * Sets the site URL   
     */
    public function seturl($x) { $this->url = $x; } 
	/**
     * Sets the site user name  
     */
    public function setUsername($x) { $this->username = $x; } 
	/**
     * Sets the site password
     */
    public function setPassword($x) { $this->password = $x; } 
	
}