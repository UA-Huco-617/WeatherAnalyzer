<?php

/**********************************************************************
*	Huco 617.B2 (Winter 2014)
*	WeatherScraper is an abstract parent class that establishes
*	an interface and basic functionality for a scraper that
*	collects data from one particular weather URL page.
*
*	Children should override three things:
*		• $weatherurl ==> the URL this scraper collects data from
*		• scrape() ==> function where the scraper does its stuff
*		• getResults() ==> function that returns the weather data
**********************************************************************/

abstract class WeatherScraper {

	protected $weatheranalyzer;			//	the manager object
	protected $weatherurl = '';			//	children should override this
	
	public function __construct($weatheranalyzer = null) {
		$this->weatheranalyzer = $weatheranalyzer;
	}

	public function log($message = null) {
		if (!empty($this->weatheranalyzer)) $this->weatheranalyzer->log($message);
	}
	
	/*************************************************
	*	Abstract methods for children to define
	*************************************************/
	
	//	scrape() should return true if you determine that it worked,
	//	and should return false otherwise.
	public abstract function scrape();
	
	//	getResults() should return an associative array of data if
	//	it worked, otherwise it should return null.
	public abstract function getResults();

}

?>