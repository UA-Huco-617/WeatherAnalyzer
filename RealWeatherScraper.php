<?php

class RealWeatherScraper extends WeatherScraper {

	protected $url = 'http://climate.weather.gc.ca/climateData/dailydata_e.html?StationID=';
	protected $stationID;
	protected $cloudCoverURL = 'http://edmonton.weatherstats.ca/data/cloud_cover-2weeks.json';
	protected $dto;
	protected $yesterday;


	public function __construct($weathermanager = null) {
		parent::__construct( $weathermanager );
		$this->yesterday = new Date('yesterday');
		$urlparams = 'Year=' . $this->yesterday->getYear() . '&Month=' . $this->yesterday->getMonth();
		$this->url .= $this->stationID . '&' . $urlparams;
		$this->dto = new RealWeatherDTO($this);
		$this->dto->setForecastDate($this->yesterday->getCanonicalDate());
		$this->weathercollection->addToCollection($this->dto);
	}

	public function scrape() {
		if ( $this->scrapeEnvironmentCanada() and $this->scrapeCloudCover() ) {
			return count($this->weathercollection);
		} else {
			return false;
		}
	}
	
	public function scrapeEnvironmentCanada() {
		$html = $this->cleanup( file_get_contents($this->url) );
		$success = true;
		//	get the right string
		$regex1 = "/title=\"" . $this->yesterday->getCanonicalDate() . "\">(.+?)<\/tr>/";
		$success = $success and preg_match( $regex1, $html, $matches );
		//	now get the data
		$regex2 = "/<td\s*>(.+?)<\/td>/";
		$success = $success and preg_match_all( $regex2, $matches[1], $m );
		//	set the DTO
		$this->dto->setHighTemp($this->validate($m[1][0]));
		$this->dto->setLowTemp($this->validate($m[1][1]));
		$precip = $this->validate($m[1][7]);
		if (is_null($precip)) $precip = 0;
		$this->dto->setPrecipitation($precip);
		return $success;
	}
	
	public function scrapeCloudCover() {
		$lines = file($this->cloudCoverURL);
		$year = $this->yesterday->getYear();
		$month = $this->yesterday->getMonth() - 1;	//	JavaScript counts months from zero
		$day = $this->yesterday->getDay();
		$regex = "/new Date\( $year, $month, $day" . ' \)},{"v":(?:\d+)},{"v":(\d+)},{"v":(?:\d+)}/';
		if ( preg_match( $regex, $lines[0], $matches ) ) {
			$this->dto->setCloudCover($this->validate($matches[1]));
			return true;
		} else {
			return false;
		}
	}
	
	public function validate($string) {
		if ( empty($string) or preg_match('/[^-.0-9]/', $string) ) {
			return null;
		} else {
			return trim($string);
		}
	}

}

?>