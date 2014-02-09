<?php

class Weather_WeatherDTO {

	/**********************************************************************
	*	Huco 617.B2 (Winter 2014)
	*	WeatherDTO is a data transfer object to facilitate moving weather
	*	data around. Clients are free to work with their own data in 
	*	any format they wish, but can get/set this DTO for easy access.
	**********************************************************************/

	protected $chanceprecip;
	protected $date;				//	forecast date
	protected $hightemp;
	protected $humidity;
	protected $lowtemp;
	protected $rainAmount;
	protected $rainUnit = 'mm';		//	default value
	protected $proseDescription;	//	i.e., 'partly cloudy'
	protected $precipitation;
	protected $precipUnit = 'mm';	// default unit
	protected $pressure;
	protected $snowAmount;
	protected $snowUnit = 'cm';		//	default value
	protected $tempUnit = 'C';		//	default value
	protected $windSpeed;
	protected $windSpeedUnit;
	protected $windDirection;
	
	protected $scraper;				//	scraper that built this object
	protected $siteID;				//	scraper's site ID
	protected $dbhelper;			//	DatabaseMapper object to handle I/O
	
	public function __construct(Weather_WeatherScraper $scraper = null) {
		$this->date = new Utility_Date();
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
	
	public function getForecastDate() {
		return $this->date->getDateAsSQL();
	}
	
	public function setForecastDate($string) {
		$this->date->setFromString($string);
	}
	
	public function getTodayAsSQL() {
		return $this->date->getTodayAsSQL();
	}
	
	/***************************
	*	Humidity
	***************************/
	
	public function getHumidity() {
		return $this->humidity;
	}
	
	public function setHumidity($humidity = null) {
		$this->humidity = $humidity;
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
	*	Precipitation
	*	This might measure, for
	*	example, the quantity
	*	of moisture in snowfall.
	***************************/
	
	public function getPrecipitation() {
			return $this->precipitation;
	}
	
	public function setPrecipitation($precip = 0) {
			$this->precipitation = $precip;
	}
	
	/***************************
	*	Precip Unit
	***************************/
	
	public function getPrecipitationUnit() {
			return $this->precipUnit;
	}
	
	public function setPrecipitationUnit($unit = 'mm') {
			$this->precipUnit = $unit;
	}
	
	/***************************
	*	Rain
	***************************/
	
	public function getRainAmount() {
		return $this->rainAmount;
	}
	
	public function setRainAmount($rain = 0) {
		$this->rainAmount = $rain;
	}
	
	/***************************
	*	Rain Unit
	***************************/
	
	public function getRainUnit() {
		return $this->rainUnit;
	}
	
	public function setRainUnit($unit = 'mm') {
		$this->rainUnit = $unit;
	}
	
	/***************************
	*	Snow
	***************************/
	
	public function getSnowAmount() {
		return $this->snowAmount;
	}
	
	public function setSnowAmount($snow = 0) {
		$this->snowAmount = $snow;
	}
	
	/***************************
	*	Snow Unit
	***************************/
	
	public function getSnowUnit() {
		return $this->snowUnit;
	}
	
	public function setSnowUnit($unit = 'cm') {
		$this->snowUnit = $unit;
	}
	
	/***************************
	*	Barometric Pressure
	***************************/
	
	public function getPressure() {
		return $this->pressure;
	}
	
	public function setPressure($pressure = null) {
		$this->pressure = $pressure;
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
	*	Wind Speed
	***************************/
	
	public function getWindSpeed() {
		return $this->windSpeed;
	}
	
	public function setWindSpeed($speed = null) {
		$this->windSpeed = $speed;
	}
	
	/***************************
	*	Wind Speed Unit
	***************************/
	
	public function getWindSpeedUnit() {
		return $this->windSpeedUnit;
	}
	
	public function setWindSpeedUnit($unit = 'km/h') {
		$this->windSpeedUnit = strtolower(str_replace(' ', '', $unit));
	}
	
	/******************************************
	*	Wind Direction
	*	officially, this is a 360-degree
	*	circle, but Environment Canada
	*	divides the number by 10:
	*	i.e., 23 = 230 degrees clockwise
	*	from North
	******************************************/
	
	public function getWindDirection() {
		return $this->windDirection;
	}
	
	public function setWindDirection($direction = null) {
		$this->windDirection = Utility_WindDirection::getDegrees($direction);
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
	***************************/
	
	public function log($message = '') {
		if (!empty($message)) Utility_Logger::log($message);
	}

}

?>