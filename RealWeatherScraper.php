<?php

abstract class RealWeatherScraper extends WeatherScraper {

	protected $dto;
	protected $yesterday;
	
	public function __construct() {
		$this->weathercollection = new WeatherCollection();
		$this->yesterday = new Date('yesterday');
		$this->dto = new RealWeatherDTO($this);
		$this->dto->setForecastDate($this->yesterday->getCanonicalDate());
		$this->weathercollection->addToCollection($this->dto);
	}


}

?>