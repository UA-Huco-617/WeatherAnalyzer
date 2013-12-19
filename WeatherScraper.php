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
	protected $weatherdto;				//	a data transport object
	
	//	children should override these:
	protected $sitename = '';			//	e.g., "Weather.com 7-day forecast"
	protected $weatherurl = '';			//	your URL to scrape
	
	
	public function __construct($weathermanager = null) {
		$this->weathermanager = $weathermanager;
		$this->weatherdto = new WeatherDTO();
		$this->weatherdto->setSiteName($this->sitename);
	}

	public function log($message = null) {
		if (!empty($this->weathermanager)) $this->weathermanager->log($message);
	}
	
	public function getWeatherDTO() {
		//return a loaded Weather Data Transport Object
		return $this->weatherdto;
	}
	
	
	/*************************************************
	*	Abstract method for children to define
	*************************************************/
	
	//	scrape() should collect data and put it into
	//	the WeatherDTO object. If you determine it
	//	worked, return true. If you determine that
	//	you can't scrape data, return false.
	public abstract function scrape();


}

?>