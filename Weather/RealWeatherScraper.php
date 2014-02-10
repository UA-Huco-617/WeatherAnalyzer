<?php

abstract class Weather_RealWeatherScraper extends Weather_WeatherScraper {

	protected $dto;
	protected $yesterday;
	
	public function __construct() {
		$this->weathercollection = new Weather_WeatherCollection();
		$this->yesterday = new Utility_Date('yesterday');
		$this->dto = new Weather_RealWeatherDTO($this);
		$this->dto->setForecastDate($this->yesterday->getCanonicalDate());
		$this->weathercollection->addToCollection($this->dto);
	}


}

?>