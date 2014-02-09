<?php

class Scraper_ToryScraper extends Weather_RealWeatherScraper {

	protected $siteID = 8;		//	Site ID from birdclub database
	protected $siteURL = 'http://easweb.eas.ualberta.ca/weather_archive.php';

	public function scrape() {
		//	1. constructor builds a new RealWeatherDTO object:
		//	2. constructor sets yesterday's date on the WeatherDTO
		//	3. collect data and push it into the WeatherDTO
		//	4. constructor already added the WeatherDTO object to the collection
		//	5. return count($this->weathercollection);
		
		$html = file_get_contents( $this->siteURL );
		$html = $this->cleanup($html);
		$row = $this->extractYesterdaysRow($html);
		$this->setDTOFromRow($row);
		return count($this->weathercollection);
	}
	
	public function extractYesterdaysRow($html) {
		$date = $this->yesterday->getDateAsSQL();
		$regex = '/<tr><td class="day">' . $date . '<\/td>(.+?)<\/tr>/';
		preg_match( $regex, $html, $matches );
		return $matches[1];
	}
	
	public function setDTOFromRow($row) {
		$regex = '/<td>(.+?)<\/td>/';
		preg_match_all( $regex, $row, $matches );
		//	Tory temps are DECIMAL(4,2), so let's round 'em off
		//	to match the database column which is DECIMAL(3,1)
		//	min temp ==> [1][0]
		//	max temp ==> [1][2]
		
		//	set high temp
		$high = round($matches[1][2], 1);	// round to 1 decimal place
		$this->dto->setHighTemp($high);
		
		// set low temp
		$low = round($matches[1][0], 1);	// round to 1 decimal place
		$this->dto->setLowTemp($low);
	}

}

?>