<?php

/**********************************************************************
*	Huco 617.B2 (Winter 2014)
*	WeatherScraper is an abstract parent class that establishes
*	an interface and basic functionality for a scraper that
*	collects data from one particular weather URL page.
*
*	Children should override three things:
*		• $siteID ==> your Site ID from the `weather_site` table
*		• $siteurl ==> the URL this scraper collects data from
*		• scrape() ==> function where the scraper does its stuff;
*			you may or may not want to break this into sub-functions.
*   This comment is very exciting.
**********************************************************************/

class Scraper_CbcWeatherScraper extends Weather_WeatherScraper {

	//	children should override these:
	protected $siteID = 5;				//	your Site ID from the `weather_site` table in birdclub
	protected $siteURL = 'http://www.cbc.ca/edmonton/weather/s0000045.html';			//	your URL to scrape
	
	/*************************************************
	*	Abstract method for children to define
	*************************************************/
	
	//	scrape() should do the following.
	//	1. for each day's forecast:
	//	2. build a new WeatherDTO object:
	//		$weatherdto = new WeatherDTO($this);
	//	3. set the forecast date on the WeatherDTO
	//		$weatherdto->setDate($some_string);
	//		(test your data with class Date to make sure it works)
	//	4. collect data and push it into the WeatherDTO
	//	5. add the WeatherDTO object to the collection
	//		$this->addToCollection($weatherdto);
	//	6. while still more days, go to step 1
	//	7. return count($this->weathercollection);
	
	public function scrape() {
		if ($this->scrapeWeather()) {
			return count($this->weathercollection);
		} else {
			return 0;
		}
	}

	public function scrapeWeather() {
		
		// build an array of DTOs
		$dtos = array();

		for ($number = 0; $number < 6; $number++ ) {
			$dtos[] = new Weather_WeatherDTO($this);
		}

		/***********************************
		*	Build the HTML array to work with -- collect rows
		/***********************************/

		$row_regex = '/<tr(.*?)>(.+?)<\/tr>/';
		preg_match_all($row_regex, $this->html, $rows);
		$html_rows = $rows[2];	// throw away data I don't want

		/***********************************
		* Iterate all the rows to collect
		* stuff we need
		************************************/

		//	grab dates from row #1
		$date_regex = '/<p>(.+?)<\/p>/';
		preg_match_all($date_regex, $html_rows[1], $dates);
		//print_r($dates[1]);

		//	loop through the columns, setting the date on the proper DTO
		for ($column = 0; $column < 6; $column++) {
			$forecast_date = $dates[1][$column];
			$dtos[$column]->setForecastDate($forecast_date);
		}

		// grab prose forecast from row #3
		$prose_regex = '/<td class="dayforecast">(.+?)<\/td>/';
		preg_match_all($prose_regex, $html_rows[3], $prose);

		//	loop through the columns, setting the prose on the proper DTO
		for ($column = 0; $column < 6; $column++) {
			$prose_description = trim($prose[1][$column]);
			$dtos[$column]->setProseDescription($prose_description);
		}

		// grab hi/lo from row #4
		$temp_regex = '/<td class="daytemps">(.+?)<\/td>/';
		preg_match_all($temp_regex, $html_rows[4], $temps);

		for ($column = 0; $column < 6; $column++) {
			$regex = '/<p class="celsius">(.+?)<\/p>/';
			preg_match($regex, $temps[1][$column], $raw);
			//	work with $raw[1]
			$high = $low = null;
			if (stripos($raw[1], '|') !== false) {
				list($high, $low) = explode('|', $raw[1]);
				// clean up data a bit
				$high = str_replace('&deg;', '', $high);
				$high = str_replace('High', '', $high);
				$high = trim($high);
				//		echo "Column $column High: |$high|\n"; 
				$low = trim($low);
				$low = str_replace('&deg;', '', $low);
				$dtos[$column]->setHighTemp($high);
				$dtos[$column]->setLowTemp($low);
			} else {
				$solo_regex = '/(High|Low)?\s*([-.0-9]+)&deg;/';
				preg_match($solo_regex, $raw[1], $solo);
				if ($solo[1] == 'High') {
					$dto[$column]->setHighTemp($solo[2]);
				} else {
					$dto[$column]->setLowTemp($solo[2]);
				}
			}
			
		}

		//	grab chance of precipitation
		$pop_regex = '/P.O.P. (\d+)%/';
		preg_match_all($pop_regex, $html_rows[4], $pop);

		for ($column = 0; $column < 6; $column++) {
			if (isset($pop[1][$column])) {	// execute only if has data
				$dtos[$column]->setChanceOfPrecip($pop[1][$column]);
			}
		}


		//add to collection
		foreach ($dtos as $dto) {
			$this->addToCollection($dto);
		}

		if (count($this->weathercollection) > 0) {
			return true;
		} else {
			return false;
		}
	}

}
?>