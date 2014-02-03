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
	

//this is the function to fill out - main function!?
public function scrape()


//1. Get Page

$html = file_get_contents('http://www.myforecast.com/bin/expanded_forecast_15day.m?city=54149&metric=true');


//2. Clean up \n

$html = str_replace("\n", ' ', $html );

//3. Get all rows

$row_regex = '/<tr (.*?)<\/tr>/';

preg_match_all($row_regex, $html, $row_matches);

$cell_regex = '/<td align="center" valign="middle" class="normal">(.*?)<\/td>/';


//this is an attempt to isolate the dates for each forcast...need to figure out how to match to data...

$date_regex = '/<td align="left" valign="middle" bgcolor="#3366CC" class="wt">(.*?)<\/td>/';

preg_match_all($date_regex, $html, $date_matches);

//ok, so I have the dates, now to find a way to match the data
//lets try making each day a var


print_r($date_matches[1]);

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