<?php

class Scraper_MyForecast extends Weather_WeatherScraper{
	
	protected $siteID = 6;				
	protected $siteURL = 'http://www.myforecast.com/bin/expanded_forecast_15day.m?city=54149&metric=true';
	//protected $date;
	//protected $pageHasData = true;	

	

	public function __construct() {
		$this->weathercollection = new Weather_WeatherCollection();
		$this->date = new Utility_Date();
	}


	public function scrape() {
		
		$rows=$this->extractRowsFromHTML($this->html);
			foreach ($rows as $row) {
				$dto=$this->buildDTOFromRow($row);
				$this->addToCollection($dto);
			}
		
			return count($this->weathercollection);
	}


//this function gives me one array for each day so day 1 - array[0] and day 15 - array[14]
	public function extractRowsFromHTML($html) {
		$cell_regex = '/<td align="center" valign="middle" class="normal">(.*?)<\/td>/';
		preg_match_all($cell_regex, $html, $cell_matches);
		$table = array_chunk($cell_matches[0], 9);
		return $table;
	}


//this function loops through the above arrays to make each day a new array, now each prose is [0] etc.
	
	public function extractDailyData($row){
		foreach ($table as $day => $row) {
		return $row;
     	// print_r($data);
}
}

	public function extractDate($html) {
		$date_regex = '/<td align="left" valign="middle" bgcolor="#3366CC" class="wt">(.*?)<\/td>/';
		preg_match_all($date_regex, $html, $date_matches);
		//print_r($date_matches[1]);
		return $date_matches[1];

	}


	public function setDTOFromRow($row) {
		$dto = new Weather_WeatherDTO($this);

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
		
			$dto->setForecastDate($date_matches[1]);

			//prose		

			$dto->setProseDescription($row[0][0]);

			//high

			$high = str_replace('&#xB0;C', '', $row[0][1]);
			$dto->setHighTemp($high);
			
			//low
			$low = str_replace('&#xB0;C', '' , $row[0][2]);
			$dto->setLowTemp($low);

			//humidity
			$humidity = str_replace('%', '', $row[0][4]);
			$dto->setHumidity($humidity);


			//chanceprecip
			$chanceprecip = str_replace('%', '', $row[0][7]);
			$dto->setChanceOfPrecip($chanceprecip);
			$dto->setPrecipitationUnit($punit);

			//precipamount this is an issue - site gives cm when snow...but rain in same place?
			//need to do something for if this is null? 
			$precipamount = str_replace('cm', '', $row[0][8]);
			$dto->setSnowAmount($precipamount);
			$dto->setPrecipitationUnit($punit);

			//Wind Speed
			$wind_regex ('/<td align="center" valign="middle" class="normal">(\d)</td>/', $row[0][3]);
			preg_match($wind_regex, $row, $wind);
			$dto->setWindSpeed($wind);
			$dto->setWindSpeedUnit($windunit);

			//Wind Direction
			$winddir_regex ('/<td align="center" valign="middle" class="normal">(N|NNE|NE|ENE|E|ESE|SE|SSE|S|SSW|SW|WSW|W|WNW|NW|NNW)+?</td>/', $row[0][3]);
			preg_match($winddir_regex, $row, $winddir);
			$dto->setWindDirection ($winddir);

			return $dto;

	}
}

?>