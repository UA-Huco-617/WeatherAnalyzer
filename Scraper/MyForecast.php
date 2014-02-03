<?php

class Scraper_MyForecast extends WeatherScraper{

	protected $siteID = 6;				
	protected $siteURL = 'http://www.myforecast.com/bin/expanded_forecast_15day.m?city=54149&metric=true';
	protected $date;
	protected $pageHasData = true;	
	
	public function __construct() {
		parent::__construct();
		$this->date = new Date();
	}

	public function __construct() {
		$this->weathercollection = new WeatherCollection();
		date_default_timezone_set('America/Edmonton');
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
		if (!empty($message)) Logger::log($message);
	}
	
	public function cleanup($text = '') {
		return str_replace("\n", ' ', $text);
	}
	


public function scrape()




	
}


?>