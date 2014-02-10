<?php

class Scraper_Wunderground extends WeatherScraper{

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
	
	protected $siteID = '10';
	protected $siteURL = 'http://www.wunderground.com/weatherstation/WXDailyHistory.asp?ID=IALBERTA60&day=9&year=2014&month=2&graphspan=day';
	
	public function scrape(){

		$wundergroundDTO = new Weather_WeatherDTO($this);

		$regex = '/<td><span class="nobr"><span class="b">(.*?)<\/span>&nbsp;&deg;C<\/span><\/td>/';

	} //scrape()

} //Scraper_Wunderground

?>