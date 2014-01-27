<?php

class WeatherDTO {

	/**********************************************************************
	*	Huco 617.B2 (Winter 2014)
	*	WeatherDTO is a data transfer object to facilitate moving weather
	*	data around. Clients are free to work with their own data in 
	*	any format they wish, but can get/set this DTO for easy access.
	**********************************************************************/

	protected $chanceprecip;
	protected $date;				//	forecast date
	protected $hightemp;
	protected $lowtemp;
	protected $precipType;
	protected $precipUnit = 'mm';	//	default value
	protected $proseDescription;	//	i.e., 'partly cloudy'
	protected $tempUnit = 'C';		//	default value
	
	protected $scraper;				//	scraper that built this object
	protected $siteID;				//	scraper's site ID
	protected $dbhelper;			//	DatabaseMapper object to handle I/O
	
	public function __construct(WeatherScraper $scraper = null) {
		$this->date = new Date();
		if (!empty($scraper)) {
			$this->scraper = $scraper;
			$this->siteID = $this->scraper->getSiteID();	// method guaranteed by WeatherScraper class
		}
		$this->dbhelper = Database_MapperFactory::getDatabaseMapper($this);
	}
	
	/***************************
	*	Site ID
	***************************/
	
	public function getSiteID() {
		return $this->siteID;
	}	
	
	public function setSiteID($siteID = null) {
		$this->siteID = $siteID;
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
	*	Temp Unit
	***************************/
	
	public function getTempUnit() {
		return $this->tempUnit;
	}
	
	public function setTempUnit($unit = 'C') {
		$this->tempUnit = $unit;
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
	*	Precipitation Type(michael)
	***************************/
	
	public function getPrecipType() {
		return $this->precipType;
	}
	
	public function setPrecipType($type = null) {
		$this->precipType = $type;
	}
	
	/***************************
	*	Precip Unit
	***************************/
	
	public function getPrecipUnit() {
		return $this->precipUnit;
	}
	
	public function setPrecipUnit($unit = 'mm') {
		$this->precipUnit = $unit;
	}
	
	/***************************
	*	Prose Description
	***************************/

	public function getProseDescription() {
		return $this->proseDescription;
	}
	
	public function setProseDescription($desc = null) {
		$this->proseDescription = $desc;
	}
	
	
	/***************************
	*	Database Access
	***************************/
	
	public function saveToDatabase() {
		if ($this->dbhelper->saveToDatabase()) {
			return true;
		} else {
			return false;
		}
	}
	
	/***************************
	*	Logfile Access
	*	(push this up to Scraper)
	***************************/
	
	public function log($message = '') {
		if (!empty($message)) Logger::log($message);
	}

}

?>