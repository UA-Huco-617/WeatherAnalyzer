<?php

class AirportWeatherScraper extends RealWeatherScraper {

	protected $siteURL = 'http://climate.weather.gc.ca/climateData/dailydata_e.html?StationID=';
	protected $stationID;
	protected $cloudCoverURL = 'http://edmonton.weatherstats.ca/data/cloud_cover-2weeks.json';

	public function __construct($weathermanager = null) {
		parent::__construct( $weathermanager );
		$urlparams = 'Year=' . $this->yesterday->getYear() . '&Month=' . $this->yesterday->getMonth();
		$this->siteURL .= $this->stationID . '&' . $urlparams;
	}

	public function scrape() {
		if ( $this->scrapeEnvironmentCanada() and $this->scrapeCloudCover() ) {
			return count($this->weathercollection);
		} else {
			return false;
		}
	}
	
	public function scrapeEnvironmentCanada() {
		$html = $this->cleanup(Utility_SecretAgent::getURL($this->siteURL));
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
		$lines = $this->cleanup(file($this->cloudCoverURL));
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
		//	this should use is_null() because 0 (which is a legit value)
		//	will make a false positive and this method will return NULL in that case.
		if ( is_null($string) or preg_match('/[^-.0-9]/', $string) ) {
			return null;
		} else {
			return trim($string);
		}
	}

}

?>