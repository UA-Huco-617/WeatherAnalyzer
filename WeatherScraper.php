<?php

/**********************************************************************
*	Huco 617.B2 (Winter 2014)
*	WeatherScraper is an abstract parent class that establishes
*	an interface and basic functionality for a scraper that
*	collects data from one particular weather URL page.
*
*	Children should override three things:
*		• $sitename ==> e.g., "AccuWeather 10-day forecast"
*		• $weatherurl ==> the URL this scraper collects data from
*		• scrape() ==> function where the scraper does its stuff;
*			you may or may not want to break this into sub-functions.
**********************************************************************/

abstract class WeatherScraper {

	protected $weathermanager;			//	the manager object
	protected $weathercollection;		//	a data transport object
	
	//	children should override these:
	protected $sitename = '';			//	e.g., "Weather.com 7-day forecast"
	protected $siteurl = '';			//	your URL to scrape
	
	
	public function __construct($weathermanager = null) {
		$this->weathermanager = $weathermanager;
		$this->weathercollection = new WeatherCollection();
	}
	
	public function getSiteName() {
		return $this->sitename;
	}
	
	public function getSiteURL() {
		return $this->siteurl;
	}

	public function getWeatherForecastCollection() {
		//return a loaded Weather Data Collection
		return $this->weathercollection;
	}
	
	//	you're free to log messages! We'll perhaps push them
	//	to a webpage so everyone can read them.
	public function log($message = null) {
		if (!empty($this->weathermanager)) $this->weathermanager->log($message);
	}
	
	
	/*************************************************
	*	Abstract method for children to define
	*************************************************/
	
	//	scrape() should do the following.
	//	1. for each day's forecast:
	//	2. build a new WeatherDTO object:
	//		$weatherdto = new WeatherDTO($this);
	//	3. set the forecast date on the WeatherDTO
	//		(we may modify class Date to help people do this)
	//	4. collect data and push it into the WeatherDTO
	//	5. add the WeatherDTO object to the collection
	//		$this->weathercollection->addWeatherDTO($weatherdto);
	//	6. while still more days, go to step 1
	//	if you determined that the scrape worked, return true;
	//	else return false.
	public abstract function scrape();


}

?>