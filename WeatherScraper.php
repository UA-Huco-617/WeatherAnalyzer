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
*
*	NOTE: your HTML is loaded by the constructor and is in $this->html
**********************************************************************/

abstract class WeatherScraper {

	protected $weathercollection;		//	a collection of DTOs
	protected $html;
	
	//	children should override these:
	protected $siteID = '';				//	your Site ID from the `weather_site` table in birdclub
	protected $siteURL = '';			//	your URL to scrape
	
	public function __construct() {
		$this->weathercollection = new WeatherCollection();
		date_default_timezone_set('America/Edmonton');
		$this->html = $this->cleanup(Utility_SecretAgent::getURL($this->siteURL));
	}
	
	public function addToCollection(WeatherDTO $dto = null) {
		if (!empty($dto)) $this->weathercollection->addToCollection($dto);
	}
	
	public function getSiteID() {
		return $this->siteID;
	}
	
	public function getSiteURL() {
		return $this->siteURL;
	}

	public function getWeatherDTOCollection() {
		//return a loaded Weather Data Collection
		return $this->weathercollection;
	}
	
	//	you're free to log messages! We'll perhaps push them
	//	to a webpage so everyone can read them.
	public function log($message = null) {
		if (!empty($message)) Utility_Logger::log($message);
	}
	
	public function cleanup($text = '') {
		return str_replace("\n", ' ', $text);
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
	//		(test your data with class Date to make sure it works)
	//	4. collect data and push it into the WeatherDTO
	//	5. add the WeatherDTO object to the collection
	//		$this->addToCollection($weatherdto);
	//	6. while still more days, go to step 1
	//	7. return count($this->weathercollection);
	public abstract function scrape();


}

?>