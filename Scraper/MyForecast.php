<?php

class Scraper_MyForecast extends WeatherScraper{

//I changed my siteID and siteURL...all else is same as template.
	
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
	


//this is the function to fill out I only change things below here now.
	public function scrape()











//1. Get Page

$html = file_get_contents('http://www.myforecast.com/bin/expanded_forecast_15day.m?city=54149&metric=true');

//2. Clean up \n

$html = str_replace("\n", ' ', $html );

//3. Get all rows

$row_regex = '/<tr (.*?)<\/tr>/';

preg_match_all($row_regex, $html, $row_matches);


$cell_regex = '/<td align="center" valign="middle" class="normal">(.*?)<\/td>/';

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
************************

*/

//this is an attempt to isolate the dates for each forcast...need to figure out how to match to data...

$date_regex = '/<td align="left" valign="middle" bgcolor="#3366CC" class="wt">(.*?)<\/td>/';

preg_match_all($date_regex, $html, $date_matches);


//ok, so I have the dates, now to find a way to match the data
//lets try making each day a var
/*
*************************
* DATES ($date_matches) *
* TODAY/Day 1 = [0][0]  *
* Day 2 = [0][1]        *
* Day 3 = [0][2]        *
* Day 4 = [0][3]        *
* Day 5 = [0][4]        *
* Day 6 = [0][5]        *
* Day 7 = [0][6]        *
* Day 8 = [0][7]        *
* Day 9 = [0][8]        *
* Day 10 = [0][9]       *
* Day 11 = [0][10]      *
* Day 12 = [0][11]      *
* Day 13 = [0][12]      *
* Day 14 = [0][13]      *
* Day 15 = [0][14]      *
*************************

*/ 

public function extractDate($html) {
		//	the forecast days are <a> tags, so the </a> here will fail on non-forecast days
		$date_regex = '/<td align="left" valign="middle" bgcolor="#3366CC" class="wt">(.*?)<\/td>/';
		if (preg_match($date_regex, $html, $matches)) {
			return $matches[1] . ' ' . $matches[2];
		} else {
			return null;
		}
	}


//4. Get all table data

foreach ( $row_matches[1] as $row) {
	if (preg_match_all ($cell_regex, $row, $cell_matches ) ){
		print_r($cell_matches[1]);
		
 }
}








// here down is other copied stuff to maybe put in/play with!
//looks like this creates the DTO to be sent out.
public function extractWeatherData($rows) {
		foreach ($rows as $row) {
			if ( $this->haveValidRow($row)) {
				$dto = $this->buildDTO($row);
				if ($dto) {
					$date = $this->extractDate($row);
					$dto->setForecastDate($date);
					$this->weathercollection->addToCollection($dto);
				}
				//var_dump($dto);
			}
		}
	}
	
}


?>