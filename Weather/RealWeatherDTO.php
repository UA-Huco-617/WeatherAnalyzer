<?php

class Weather_RealWeatherDTO extends Weather_WeatherDTO {

	protected $actualprecip;
	protected $cloudCover;
	
	/*****************************************
	*	Actual Precipitation
	*****************************************/
	
	public function getActualPrecip() {
		return $this->actualprecip;
	}
	
	public function setActualPrecip($precip = null) {
		$this->actualprecip = $precip;
	}

	/*****************************************
	*	Cloud Cover Percentage
	*****************************************/
	
	public function getCloudCover() {
		return $this->cloudCover;
	}	

	public function setCloudCover($percent = null) {
		$this->cloudCover = $percent;
	}


}

?>