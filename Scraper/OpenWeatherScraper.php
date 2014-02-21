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
*
*	NOTE: your HTML is loaded by the constructor and is in $this->html
**********************************************************************/
class Scraper_OpenWeatherScraper extends Weather_WeatherScraper {

	protected $siteID = 3;				//	your Site ID from the `weather_site` table in birdclub
	protected $siteURL = 'http://www.weatherforecastmap.com/canada/edmonton';			//	your URL to scrape

	public function scrape() {
		$rows=$this->extractRowsFromHTML($this->html);
		foreach ($rows as $row) {
			$dto=$this->buildDTOFromRow($row);
			$this->addToCollection($dto);
		}
		return count($this->weathercollection);
	}
	
	public function extractRowsFromHTML($html) {
		$thing= '<td colspace=2 class="heading"';
		$end = 'deg;C<\/td>';
		$row_regex ="/$thing(.*?)$end/";
		preg_match_all($row_regex, $html, $rows);
		if (empty($rows)) Utility_Logger::log(__METHOD__ . ' could not extract rows from html.');
		return $rows[1];	
	}
	
	
	public function buildDTOFromRow($row) {
			
		$dto= new Weather_WeatherDTO($this);

		// date
		$date_regex='/ >(.+?)<\/td><\/tr> <tr><td>/';
		preg_match_all($date_regex, $row, $date);
		if (empty($date)) Utility_Logger::log(__METHOD__ . ' could not extract date from row.');
		$dto->setForecastDate($date[1][0]);

		// Low Temp
		$low_regex = '/Min:&nbsp;(.+?)&/';
		preg_match_all($low_regex, $row, $low);
		if (empty($low)) Utility_Logger::log(__METHOD__ . ' could not extract low temp from row.');
		$dto->setLowTemp($low[1][0]);

		// High Temp
		$max_regex = '/Max:&nbsp;(.+?)&deg;C/';
		preg_match_all($max_regex, $row, $high);
		if (empty($high)) Utility_Logger::log(__METHOD__ . ' could not extract high temp from row.');
		$dto->setHighTemp($high[1][0]);

		//	prose description
		$pic_regex = '/alt="(.+?)"title=/';
		preg_match_all($pic_regex, $row, $desc);
		if (empty($desc)) Utility_Logger::log(__METHOD__ . ' could not extract prose description from alt tag.');
		$dto->setProseDescription($desc[1][0]);
	
		return $dto;
	}

}

?>