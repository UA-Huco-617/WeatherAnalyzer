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
	protected $siteURL = 'http://www.wunderground.com/global/stations/71123.html?MR=1';
	
	public function scrape(){

		$arrayForecast = $this->getProseForecast();
		foreach ($arrayForecast as $forecastDay => $forecastProse) {
			$weatherdto = new Weather_WeatherDTO($this);
			$weatherdto->setForecastDate($forecastDay);
			$weatherdto->setProseDescription($forecastProse);
			$this->addToCollection($weatherdto);
		} // foreach

		return count($this->weathercollection);

	} // scrape()

	public function getProseForecast() {
		$html = file_get_contents("http://www.wunderground.com/global/stations/71123.html?MR=1");
		$html = str_replace("\n", '', $html);
		$div_regex = '/<div class="p5">(.+?)<\/table>\s*<\/div>/';
		$arrayForecast = array();
		preg_match_all($div_regex, $html, $divs);
		foreach ($divs[1] as $div) {
			$currentDay = $this->getDay($div);
			$currentProseForecast = $this->getProse($div);
			$arrayForecast[$currentDay] = $currentProseForecast;			
		} // foreach
		return $arrayForecast;
	}

	protected function getDay($divDay){
		$dayRegex = '/<div class="b">(.+?)<\/div>/';
		preg_match($dayRegex, $divDay, $day);
		echo $day[1]."\n";
		return $currentDay = $day[1];
	} // getDay

	protected function getProse($divProse){
		$proseRegex = '/<td class="vaT full">(.+?)<\/td>/';
		preg_match($proseRegex, $divProse, $prose);
		echo $prose[1]."\n\n";
		return $currentProseForecast = $prose[1];
	} // getProse

} // Scraper_Wunderground

?>