<?php

class Scraper_YEGintl extends RealWeatherScraper {

	//	This scraper pulls real, historical weather data
	//	from the Edmonton International airport.
	
	protected $stationID = '50149';		//	Environment Canada's station #
	protected $siteID = 1;				//	ID in weather_site database table

}

?>