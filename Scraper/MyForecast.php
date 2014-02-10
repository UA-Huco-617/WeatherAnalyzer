<?php

class Scraper_MyForecast extends Weather_WeatherScraper{
	
	protected $siteID = 6;				
	protected $siteURL = 'http://www.myforecast.com/bin/expanded_forecast_15day.m?city=54149&metric=true';
	protected $date;
	protected $pageHasData = true;	
	
	public function __construct() {
		parent::__construct();
		$this->date = new Utility_Date();
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

		return $this->weathercollection;
	}

	public function log($message = null) {
		if (!empty($message)) Logger::log($message);
	}
	
	public function cleanup($text = '') {
		return str_replace("\n", ' ', $text);
	}
	
	
	}


//this is the function to fill out I only change things below here now.
	//THE FUNCTIONS ALREADY EXIST!  call getters and setters....WeatherDTO and DATE
	//remember to do the top-down narrative thing...every function followed by next level of abstractions

	public function scrape() {

		$row = $this->extractTodaysRow($html);
		$dto = $this->setDTOFromRow($row);
		$this->addToCollection($dto);
		//this is my guess...
		$row = $this->extractDay2Row($html);
		$dto = $this->setDTOFromRow($row);
		$this->addToCollection($dto);
		return count($this->weathercollection);

	}

//Day 1 - Today

	public function extractTodaysRow($html) {
		$today = new Utility_Date('Today');
		//got rid of previous individual date functions....is this all I need?
		//again, cannot test at the moment...is $date in the correct place?
		$regex = '/<td align="left" valign="middle" bgcolor="#3366CC" class="wt">'.$date.'(.*?)<\/tr>/';
		preg_match($regex, $html, $matches);
		//without testing, this should isolate today's row
		return $matches[0];
	}

	public function setDTOFromRow($row) {
		$dto = new WeatherDTO($this);
		$regex = '/<td align="center" valign="middle" class="normal">(.*?)<\/td>/';
		preg_match_all($regex, $row, $matches);
/*
************************
* Data                 *
* proseDescription [0] *
* High Temp [1]        *
* Low Temp [2]         *
* Wind Speed/Dir [3]   *
* Humidity [4]         *
* Comfort Level [5]    *
* UV Index [6]         *
* Prob Precip [7]      *
* 24 h precip total [8]*
***********************/
			//so this should be changed to $dto->setForecastDate($date-databit); ???????
			$dto->setForecastDate('Today');
			//without testing, this should isolate individual parts of above defined row 'today'
			//having done that, not sure if I need [0][0]...or just [0]
			
			//prose
			$dto->setProseDescription($matches[0][0]);

			//high
			$high = str_replace('&#176;', '', $matches[0][1]);
			$dto->setHighTemp($high);
			
			//low
			$low = str_replace('&#176', '' , $matches[0][2]);
			$dto->setLowTemp($low);

			//chanceprecip
			$chanceprecip = str_replace('%', '', $matches[0][7]);
			$dto->setChanceOfPrecip($chanceprecip);

			//precipamount this is an issue - site gives cm when snow...but rain in same place?
			$precipamount = str_replace('cm', '', $matches[0][8]);
			$dto->setSnowAmount($precipamount);

			return $dto;

	}

//Day 2

	public function extractDay2Row($html) {
		$today = new Date('Day2');
		//can't test...is this the correct way to get the date?
		$date = $today->setYear(2014);
		$date = $today->setMonthByName();
		$date = $today->setDay();
		$date = $today->getCanonicalDate();
		//again, cannot test at the moment...is $date in the correct place?
		$regex = '/<td align="left" valign="middle" bgcolor="#3366CC" class="wt">'.$date.'(.*?)<\/tr>/';
		preg_match($regex, $html, $matches);
		//without testing, this should isolate day2's row
		return $matches[1];
	}

	public function setDTOFromRow($row) {
		$dto = new WeatherDTO($this);
		$regex = '/<td align="center" valign="middle" class="normal">(.*?)<\/td>/';
		preg_match_all($regex, $row, $matches);
/*
************************
* Data                 *
* proseDescription [0] *
* High Temp [1]        *
* Low Temp [2]         *
* Wind Speed/Dir [3]   *
* Humidity [4]         *
* Comfort Level [5]    *
* UV Index [6]         *
* Prob Precip [7]      *
* 24 h precip total [8]*
***********************/

			$dto->setForecastDate('Day2');
			//without testing, this should isolate individual parts of above defined row 'Day2'
			//having done that, not sure if I need [1][0]...or just [0]
			
			//prose
			$dto->setProseDescription($matches[1][0]);

			//high
			$high = str_replace('&#176;', '', $matches[1][1]);
			$dto->setHighTemp($high);
			
			//low
			$low = str_replace('&#176', '' , $matches[1][2]);
			$dto->setLowTemp($low);

			//chanceprecip
			$chanceprecip = str_replace('%', '', $matches[1][7]);
			$dto->setChanceOfPrecip($chanceprecip);

			//precipamount this is an issue - site gives cm when snow...but rain in same place?
			$precipamount = str_replace('cm', '', $matches[1][8]);
			$dto->setSnowAmount($precipamount);

			return $dto;

	}


/*  NEED THIS SOMEWHERE...???

	/***************************
	*	Database Access
	***************************
	
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
	***************************
	
	public function log($message = '') {
		if (!empty($message)) Logger::log($message);
	}

}
*/

?>