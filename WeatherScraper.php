<?php

/**********************************************************************
*	Huco 617.B2 (Winter 2014)
*	WeatherScraper is an abstract parent class that establishes
*	an interface and basic functionality for a scraper that
*	collects data from one particular weather URL page.
*
*	Children should override four things:
*		• $sitename ==> e.g., "AccuWeather 10-day forecast"
*		• $weatherurl ==> the URL this scraper collects data from
*		• scrape() ==> function where the scraper does its stuff
*		• getResults() ==> function that returns the weather data
**********************************************************************/

abstract class WeatherScraper {

	protected $weathermanager;			//	the manager object
	protected $weatherdataobject;		//	a data transport object
	
	//	children should override these:
	protected $sitename = '';			//	e.g., "Weather.com 7-day forecast"
	protected $weatherurl = '';			//	your URL to scrape
	
	
	public function __construct($weathermanager = null) {
		$this->weathermanager = $weathermanager;
		$this->weatherdataobject = new WeatherDTO();
	}

	public function log($message = null) {
		if (!empty($this->weathermanager)) $this->weathermanager->log($message);
	}
	
	/*************************************************
	*	Abstract methods for children to define
	*************************************************/
	
	//	scrape() should return true if you determine that it worked,
	//	and should return false otherwise.
	public abstract function scrape();
	
	//	getResults() should return a loaded Weather Data Transport Object:
	//		return $this->weatherdataobject;
	//	If you haven't successfully scraped data, the
	//	object will simply contain no data.
	public abstract function getResults();

}

?>