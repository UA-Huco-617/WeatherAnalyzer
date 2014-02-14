<?php

class Weather_RealWeatherDTO extends Weather_WeatherDTO {

	protected $actualprecip;
	protected $cloudCover;
	protected $coefficient;
	
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

	/*****************************************
	*	Pressure Coefficient
	*	This is the slope of the linear
	*	regression of the daily pressures.
	*****************************************/
	
	public function getPressureCoefficient() {
		return $this->coefficient;
	}	

	public function setPressureCoefficient($coefficient = null) {
		$this->coefficient = $coefficient;
	}


}

?>