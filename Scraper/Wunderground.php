<?php

class Scraper_Wunderground extends Weather_WeatherScraper{

	//	scrape() should do the following.
	//	1. for each day's forecast:
	//	2. build a new Weather_WeatherDTO object:
	//		$weatherdto = new Weather_WeatherDTO($this);
	//	3. set the forecast date on the WeatherDTO
	//		$weatherdto->setDate($some_string);
	//		(test your data with class Date to make sure it works)
	//	4. collect data and push it into the WeatherDTO
	//	5. add the WeatherDTO object to the collection
	//		$this->addToCollection($weatherdto);
	//	6. while still more days, go to step 1
	//	7. return count($this->weathercollection);
	
	protected $siteID = 10;
	protected $siteURL = 'http://www.wunderground.com/weatherstation/WXDailyHistory.asp?ID=IALBERTA60&day=9&year=2014&month=2&graphspan=day';
	
	public function scrape(){

		$rows = $this->extractRowsFromHTML();
		foreach($rows as $row){
			$dto = $this->buildDTOFromRow($row);
			$this->addToCollection($dto);
		}//foreach
		return count($this->weathercollection);

	} //scrape()

	public function extractRowsFromHTML($html){

		$regex = '/<tbody>(<tr>(.+?)<\/tr>)+<\/tbody>/';
		preg_match_all($regex, $html, $rows);
		print_r($rows);
		exit;

	} //extractRowsFromHTML
} //Scraper_Wunderground

?>