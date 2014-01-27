<?php

/**********************************************************************
*	Huco 617.B2 (Winter 2014)
*	WeatherScraper is an abstract parent class that establishes
*	an interface and basic functionality for a scraper that
*	collects data from one particular weather URL page.
*
*	Children should override three things:
*		• $siteID ==> your Site ID from the `weather_site` table
*		• $siteurl ==> the URL this scraper collects data from
*		• scrape() ==> function where the scraper does its stuff;
*			you may or may not want to break this into sub-functions.
*   This comment is very exciting.
**********************************************************************/

abstract class WeatherScraper {

	protected $weathermanager;			//	the manager object
	protected $weathercollection;		//	a collection of DTOs
	
	//	children should override these:
	protected $siteID = '';				//	your Site ID from the `weather_site` table in birdclub
	protected $siteurl = '';			//	your URL to scrape
	
	
	public function __construct($weathermanager = null) {
		$this->weathermanager = $weathermanager;
		$this->weathercollection = new WeatherCollection();
		date_default_timezone_set('America/Edmonton');
	}
	
	public function getSiteID() {
		return $this->siteID;
	}
	
	public function getSiteURL() {
		return $this->siteurl;
	}

	public function getWeatherDTOCollection() {
		//return a loaded Weather Data Collection
		return $this->weathercollection;
	}
	
	//	you're free to log messages! We'll perhaps push them
	//	to a webpage so everyone can read them.
	public function log($message = null) {
		if (!empty($message)) Logger::log($message);
	}
	
	
	/*************************************************
	*	Abstract method for children to define
	*************************************************/
	
	//	scrape() should do the following.
	//	1. for each day's forecast:
	//	2. build a new WeatherDTO object:
	//		$weatherdto = new WeatherDTO($this);
	//	3. set the forecast date on the WeatherDTO
	//		$weatherdto->setDate($some_string);
	//		(we may modify class Date to help people do this)
	//	4. collect data and push it into the WeatherDTO
	//	5. add the WeatherDTO object to the collection
	//		$this->weathercollection->addToCollection($weatherdto);
	//	6. while still more days, go to step 1
	//	if you determined that the scrape worked, return true;
	//	else return false.
	public abstract function scrape();


}

?>