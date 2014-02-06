<?php

class Scraper_YEGcc extends AirportWeatherScraper {

	//	This scraper pulls real, historical weather data
	//	from the Edmonton City Centre airport.
	
	protected $stationID = '31427';		//	Environment Canada's station #
	protected $siteID = 2;				//	ID in weather_site database table

}

?>