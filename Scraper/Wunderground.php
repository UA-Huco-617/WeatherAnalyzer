<?php

class Scraper_Wunderground extends Weather_WeatherScraper {
	
	protected $siteID = 10;
	protected $siteURL = 'http://www.wunderground.com/global/stations/71123.html?MR=1';
	protected $days_in_future = 0;
	protected $divs = array(); 	// an array of prose forecasts; two per day

	public function scrape() {
		// site has a series of DIVs; each day is two:
		//	one for daytime, one for nighttime.
		$section = $this->getProperSection();
		$this->divs = $this->parseDivs($section);
		do {
			$dto = $this->buildDTO();
			$this->addToCollection($dto);
		} while (count($this->divs) > 0);
		return count($this->weathercollection);
	}

	public function getProperSection() {
		$regex = '/<div>Descriptive Forecast(.+?)conds_details_radarbox/';
		if (!preg_match($regex, $this->html, $matches)) {
			Utility_Logger::log(__METHOD__ . " cannot retrieve section containing forecasts.");
			return null;
		}
		return $matches[1];
	}

	public function parseDivs($divs) {
		$regex = '/<div class="b">(.+?)<\/table>\s*<\/div>/';
		preg_match_all($regex, $divs, $matches);
		return $matches[1];
	}

	public function buildDTO() {
		if (count($this->divs) == 0) return null;
		$forecast = $this->popForecastFromDIVs();
		$dto = new Weather_WeatherDTO($this);
		$dto->setForecastDate($this->extractDate($forecast));
		$dto->setProseDescription($forecast);
		$dto->setHighTemp($this->extractHighTemp($forecast));
		$dto->setLowTemp($this->extractLowTemp($forecast));
		$dto->setWindSpeed($this->extractWindSpeed($forecast));
		$dto->setWindDirection($this->extractWindDirection($forecast));
		// wind speed on this site seems consistently to be kmh
		$dto->setWindSpeedUnit('km/h');
		$dto->setChanceOfPrecip($this->extractCOP($forecast));
		$dto->setSnowAmount($this->extractSnowAmount($forecast));
		//	don't know how they handle rain yet; revisit this later!
		return $dto;
	}

	public function popForecastFromDIVs() {
		$forecast = '';
		do {
			$forecast .= array_shift($this->divs);
		} while (!preg_match('/night<\/div>/', $forecast));
		$forecast = strip_tags($forecast);
		$forecast = preg_replace('/\s{2,}/', ' ', $forecast);
		return trim($forecast);
	}

	public function extractDate($string) {
		if (stripos($string, 'today') !== false or stripos($string, 'tonight') !== false) return 'today';
		$this->days_in_future++;
		return "today + {$this->days_in_future} days";
	}

	public function extractHighTemp($string) {
		$regex = '/High(?:.+?)([-0-9]+)C/i';
		if (preg_match($regex, $string, $matches)) {
			return $matches[1];
		} else {
			return null;
		}
	}

	public function extractLowTemp($string) {
		$regex = '/Low(?:.+?)([-0-9]+)C/i';
		if (preg_match($regex, $string, $matches)) {
			return $matches[1];
		} else {
			return null;
		}
	}

	public function extractWindSpeed($string) {
		$speeds = array();
		$regex = '/Winds (?:\w+) at (\d+) to (\d+) kmh/i';
		preg_match_all($regex, $string, $matches);
		$speeds = array_merge($matches[1], $matches[2]);
		return Utility_Statistics::getAverage($speeds);
	}

	public function extractWindDirection($string) {
		$degrees = array();
		$regex = '/Winds (\w+) at (?:\d+) to (?:\d+) kmh/i';
		preg_match_all($regex, $string, $matches);
		foreach ($matches[1] as $dir) {
			$degrees[] = Utility_WindDirection::getDegrees($dir);
		}
		return Utility_WindDirection::getAverageWindDirection($degrees);
	}

	public function extractCOP($string) {
		$regex = '/Chance of (?:\w+) (\d+)%/';
		if (preg_match($regex, $string, $matches)) {
			return $matches[1];
		} else {
			return null;
		}
	}

	public function extractSnowAmount($string) {
		$regex = '/Snow accumulation(?:.+?)([.0-9]+)cm/i';
		if (preg_match($regex, $string, $matches)) {
			return $matches[1];
		} else {
			return null;
		}
	}

}

?>