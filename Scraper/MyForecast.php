<?php

class Scraper_MyForecast extends Weather_WeatherScraper{
	
	protected $siteID = 6;				
	protected $siteURL = 'http://www.myforecast.com/bin/expanded_forecast_15day.m?city=54149&metric=true';
	protected $date;
	protected $pageHasData = true;	
	
	/*public function __construct() {
		parent::__construct();
		$this->date = new Utility_Date();
	}
*/
	public function __construct() {
		$this->weathercollection = new Weather_WeatherCollection();
		$this->date = new Utility_Date();
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
	
	


	public function scrape() {
		$this->html = $this->cleanup(Utility_SecretAgent::getURL($this->siteURL));
		$html = $this->cleanup(Utility_SecretAgent::getURL($url));
		$row = $this->extractTableData($html);
		$data = $this->extractDailyData ($html);
		$dto = $this->setDTOFromData($data);
		$this->addToCollection($dto);
		return count($this->weathercollection);

	}


//this function gives me one array for each day so day 1 - array[0] and day 15 - array[14]
	public function extractTableData($html) {
		$cell_regex = '/<td align="center" valign="middle" class="normal">(.*?)<\/td>/';
		preg_match_all($cell_regex, $html, $cell_matches);
		$row = array_chunk($cell_matches[0], 9);
		return $row;
		//print_r($row);
	}


//this function loops through the above arrays to make each day a new array, now each prose is [0] etc.
	public function extractDailyData($row){
		foreach ($row as $day => $data) {
		return $data;
     	// print_r($data);
}
}

	public function extractDate($html) {
		$date_regex = '/<td align="left" valign="middle" bgcolor="#3366CC" class="wt">(.*?)<\/td>/';
		preg_match_all($date_regex, $html, $date_matches);
		print_r($date_matches[1]);

	}


	public function setDTOFromData($data) {
		$dto = new WeatherDTO($this);

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
		
			$dto->setForecastDate();

			//prose		
			$dto->setProseDescription($data[0]);

			//high
			$high = str_replace('&#xB0;C', '', $data[1]);
			$dto->setHighTemp($high);
			
			//low
			$low = str_replace('&#xB0;C', '' , $data[2]);
			$dto->setLowTemp($low);

			//humidity
			$humidity = str_replace('%', '', $data[4]);
			$dto->setHumidity($humidity);


			//chanceprecip
			$chanceprecip = str_replace('%', '', $data[7]);
			$dto->setChanceOfPrecip($chanceprecip);

			//precipamount this is an issue - site gives cm when snow...but rain in same place?
			//need to do something for if this is null!  
			$precipamount = str_replace('cm', '', $data[8]);
			$dto->setSnowAmount($precipamount);

			return $dto;

	}








  //NEED THIS SOMEWHERE...???

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
	***************************
	
	public function log($message = '') {
		if (!empty($message)) Logger::log($message);
	}*/

}


?>