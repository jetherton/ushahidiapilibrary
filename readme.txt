=== About ===
name: Ushahidi API Library
website: http://www.apps.ushahidi.com
description: A library for using the Ushahidi API in PHP, from one Ushaihdi instance to another.
version: 0.1
requires: 2.0
tested up to: 2.0
author: John Etherton
author website: http://johnetherton.com

== Description ==
This plugin creates a new library that is used to interact with the API of other Ushahidi sites. The helper handles all of the parsing and creating of API requests. This Library is not the API itself. It just makes using the API easier.

This is made for Ushahidi sites that need to interact with other Ushahidi sites in a programatic way.

Requires PHP 5.3

== Installation ==

1. Copy the entire /ushahidiapilibrary/ directory into your /plugins/ directory.
2. Activate the plugin.
3. create a new Ushahidi_API_Library object in your code and then go to town.

== Changelog ==
v0.1 - 2011/05/13 - Etherton - Started working on this plugin. At first it'll just support the report task since that's what I need right now.

== TODO == 
* gracefully handle HTTP issues
* Figure out how to send photos
* Figure out how to parse the media to properly find videos and news links
* add all the other API commands
 