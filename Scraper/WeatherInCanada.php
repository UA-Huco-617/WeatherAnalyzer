<?php

class Scraper_WeatherInCanada extends Weather_WeatherScraper {

	protected $siteID = 9;
	protected $siteURL = 'http://www.weather-in-canada.com/Alberta/Weather_in_Edmonton/14-day-forecast';

	public function scrape() {
		$rows = $this->extractValidRows($this->html);
		foreach ($rows as $row) {
			$dto = $this->buildDTO($row);
			if ($dto) $this->addToCollection($dto);
		}
		return count($this->weathercollection);
	}
	
	public function extractValidRows($html) {
		$regex = "/<tr>(.+?)<\/tr>/";
		preg_match_all($regex, $html, $matches);
		array_shift($matches[1]);	//	remove header row
		return $matches[1];
	}
	
	public function buildDTO($html) {
		$regex = '/<td(?:.*?)>(.+?)<\/td>/';
		if (! preg_match_all($regex, $html, $matches)) return null;
		$dto = new Weather_WeatherDTO($this);
		//	[1][0] => Thursday<br>20.02.2014
		//	[1][1] => <img class="day" src="http://www.weather-in-canada.com/res/04.png" alt="">
		//	[1][2] => -6 &deg;C
		//	[1][3] => -14 &deg;C
		//	[1][4] => 9 km/h
		//	[1][5] => E
		//	[1][6] => cloudy with little or no clear sky
		
		//	Date -- if the European-style breaks, transform to m/d/y ?
		//	Somehow, the Date class barfs on this: 'Tomorrow, Sunday 09.02.2014';
		//	so let's axe anything before the comma
		if (stripos($matches[1][0], ',') !== false) {
			list(,$matches[1][0]) = explode(',', $matches[1][0], 2);
		}
		$date = str_replace('<br>', ' ', $matches[1][0]);
		$dto->setForecastDate($date);
		//	High:
		list($high, $unit) = explode('&deg;', $matches[1][2]);
		$dto->setHighTemp(trim($high));
		$dto->setTempUnit(strtoupper(trim($unit)));
		//	Low:
		list($low, ) = explode('&deg;', $matches[1][3]);
		$dto->setLowTemp(trim($low));
		//	Wind:
		list($speed, $unit) = explode(' ', $matches[1][4]);
		$dto->setWindSpeed($speed);
		$dto->setWindSpeedUnit($unit);
		$dto->setWindDirection($matches[1][5]);
		//	Prose:
		$dto->setProseDescription($matches[1][6]);
		return $dto;
	}

}

?>