<?php

class WeatherDTO {

	/**********************************************************************
	*	Huco 617.B2 (Winter 2014)
	*	WeatherDTO is a data transfer object to facilitate moving weather
	*	data around. Clients are free to work with their own data in 
	*	any format they wish, but can get/set this DTO for easy access.
	**********************************************************************/

	protected $actualprecip;
	protected $chanceprecip;
	protected $date;		//	forecast date
	protected $hightemp;
	protected $lowtemp;
	protected $scraper;		//	scraper that built this object
	protected $precipType;
	protected $sitename;	//	scraper's target site (make this an ID?)

	
	public function __construct(WeatherScraper $scraper) {
		$this->date = new Date();
		$this->scraper = $scraper;
		$this->sitename = $this->scraper->getSiteName();
	}
	
	/***************************
	*	Site Name
	***************************/
	
	public function getSiteName() {
		return $this->sitename;				// Johns test addition! //Sonja's test addition! //Ditto for Andrea!
	}	
	
	public function setSiteName($sitename = null) {
		$this->sitename = $sitename;
	}
	
	/***************************
	*	Date
	***************************/
	
	public function getDate() {
		return $this->date->getDateAsSQL();
	}
	
	public function setDate($string) {
		$this->date->setFromString($string);
	}
	
	/***************************
	*	High Temp
	***************************/
	
	public function getHighTemp() {
		return $this->hightemp;
	}
	
	public function setHighTemp($temp = null) {
		$this->hightemp = $temp;
	}
	
	/***************************
	*	Low Temp
	***************************/
	
	public function getLowTemp() {
		return $this->lowtemp;
	}
	
	public function setLowTemp($temp = null) {
		$this->lowtemp = $temp;
	}
	
	/***************************
	*	Chance of Precipitation
	***************************/
	
	public function getChanceOfPrecip() {
		return $this->chanceprecip;
	}
	
	public function setChanceOfPrecip($precip = null) {
		$this->chanceprecip = $precip;
	}
	
	/***************************
	*	Actual Precipitation
	***************************/
	
	public function getActualPrecip() {
		return $this->actualprecip;
	}
	
	public function setActualPrecip($precip = null) {
		$this->actualprecip = $precip;
	}
	
	/***************************
	*	Precipitation Type
	***************************/
	
	public function getPrecipType() {
		return $this->precipType;
	}
	
	public function setPrecipType($type = null) {
		$this->precipType = $type;
	}

}

?>