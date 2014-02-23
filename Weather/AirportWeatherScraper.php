<?php

class Weather_AirportWeatherScraper extends Weather_RealWeatherScraper {

	protected $siteURL = 'http://climate.weather.gc.ca/climateData/dailydata_e.html?StationID=';
	protected $hourlyURL = 'http://climate.weather.gc.ca/climateData/hourlydata_e.html?StationID=';
	protected $stationID;
	protected $cloudCoverURL = 'http://edmonton.weatherstats.ca/data/cloud_cover-2weeks.json';
	
	//	indexes for columns in the Environment Canada hourly page:
	const SPEED_INDEX = 5;
	const DIRECTION_INDEX = 4;
	const PRESSURE_INDEX = 7;
	const HUMIDITY_INDEX = 3;
	const NOT_NUMERIC_DATA = '/[^-.0-9]/';

	//	arrays to stash info
	protected $windSpeedArray = array();
	protected $windDirectionArray = array();
	protected $pressureArray = array();
	protected $humidityArray = array();

	public function __construct($weathermanager = null) {
		parent::__construct( $weathermanager );
		$urlparams = 'Year=' . $this->yesterday->getYear() . '&Month=' . $this->yesterday->getMonth();
		$this->siteURL .= $this->stationID . '&' . $urlparams;
	}

	public function scrape() {
		if ( $this->scrapeEnvironmentCanada() and $this->scrapeCloudCover()
			and $this->scrapeHourly()) {
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
		/*
			Set the DTO; here's what we have:
			[1][0] => max temp
	    	[1][1] => min temp
	    	[1][2] => mean temp (ignore)
	    	[1][3] => heat degree days (ignore)
	    	[1][4] => cool degree days (ignore)
	    	[1][5] => rain (mm)
	    	[1][6] => snow (cm)
	    	[1][7] => precip (mm)
	    	[1][8] => snow on ground (cm)
	    	[1][9] => direction of max gust (ignore)
	    	[1][10] => speed of max gust (ignore)
		*/
	    //	Sometimes, temps will have an "E" suffix to
	    //	indicate an estimate. We can just remove that,
	    //	otherwise, we'll insert NULL.
	    $high = str_replace('E', '', $m[1][0]);
		$this->dto->setHighTemp($this->validate($high));
		$low = str_replace('E', '', $m[1][1]);
		$this->dto->setLowTemp($this->validate($low));
		$this->dto->setRainAmount($this->validate($m[1][5]));
		$this->dto->setRainUnit('mm');
		$this->dto->setSnowAmount($this->validate($m[1][6]));
		$this->dto->setSnowUnit('cm');
		$this->dto->setPrecipitation($this->validate($m[1][7]));
		$this->dto->setPrecipitationUnit('mm');
		return $success;
	}
	
	public function scrapeCloudCover() {
		$lines = $this->cleanup(Utility_SecretAgent::getURL($this->cloudCoverURL));
		$year = $this->yesterday->getYear();
		$month = $this->yesterday->getMonth() - 1;	//	JavaScript counts months from zero
		$day = $this->yesterday->getDay();
		$regex = "/new Date\( $year, $month, $day" . ' \)},{"v":(?:\d+)},{"v":(\d+)},{"v":(?:\d+)}/';
		if ( preg_match( $regex, $lines, $matches ) ) {
			$this->dto->setCloudCover($this->validate($matches[1]));
			return true;
		} else {
			Utility_Logger::log(__METHOD__ . ' failing.');
			return false;
		}
	}
	
	public function scrapeHourly() {
		// average this from the hourly update
		$this->buildHourlyURL();
		$html = $this->cleanup(Utility_SecretAgent::getURL($this->hourlyURL));
		if (empty($html)) {
			Utility_Logger::log(__METHOD__ . 'cannot load Hourly page for station ID ' . $this->stationID);
			return false;
		}
		$rows = $this->getHourlyRows($html);
		if (!$rows) {
			Utility_Logger::log(__METHOD__ . ' cannot parse rows from HTML on Site ID ' . $this->getSiteID() . '. Failing.');
			return false;
		}
		$this->buildDataArrays($rows);
		
		$this->dto->setWindSpeed(Utility_Statistics::getAverage($this->windSpeedArray));
		$this->dto->setWindSpeedUnit('km/h'); // yeah, hard-coded, but it's EnviroCan!
		$this->dto->setWindDirection(Utility_WindDirection::getAverageWindDirection($this->windDirectionArray));
		$this->dto->setPressure(Utility_Statistics::getAverage($this->pressureArray));
		$this->dto->setPressureUnit('kPa');	//	this is the unit for both Environment Canada and Tory
		$this->dto->setPressureCoefficient(Utility_Statistics::getLinearRegressionCoefficient($this->pressureArray));
		$this->dto->setHumidity(Utility_Statistics::getAverage($this->humidityArray));
		return true;
	}

	public function buildDataArrays($rows) {
		// use isset() here instead of !empty() because
		//	we need to retain values that are 0.
		foreach ($rows as $row) {
			//	wind speed
			if (isset($row[self::SPEED_INDEX]) and 
				!preg_match(self::NOT_NUMERIC_DATA, $row[self::SPEED_INDEX]))
					$this->windSpeedArray[] = $row[self::SPEED_INDEX];

			// wind direction
			if (isset($row[self::DIRECTION_INDEX]) and 
				!preg_match(self::NOT_NUMERIC_DATA, $row[self::DIRECTION_INDEX]))
					$this->windDirectionArray[] = $row[self::DIRECTION_INDEX] * 10;

			// pressure
			if (isset($row[self::PRESSURE_INDEX]) and 
				!preg_match(self::NOT_NUMERIC_DATA, $row[self::PRESSURE_INDEX]))
					$this->pressureArray[] = $row[self::PRESSURE_INDEX];

			// humidity
			if (isset($row[self::HUMIDITY_INDEX]) and 
				!preg_match(self::NOT_NUMERIC_DATA, $row[self::HUMIDITY_INDEX]))
					$this->humidityArray[] = $row[self::HUMIDITY_INDEX];
		}
	}
	
	public function buildHourlyURL() {
		//50149&timeframe=1&Year=2014&Month=1&cmdB1=Go&Day=31
		$this->hourlyURL .= $this->stationID . '&timeframe=1&Year=' . $this->yesterday->getYear() . '&Month=' .
			$this->yesterday->getMonth() . '&cmdB1=Go&Day=' . $this->yesterday->getDay();
	}
	
	public function getHourlyRows($html) {
		$clean_rows = array();
		$table_regex = '/<tr>\s*<th>TIME\s*<\/th>(.+?)<\/table>/';
		if (!preg_match($table_regex, $html, $table)) {
			Utility_Logger::log(__METHOD__ . ': Hourly Table regex didn\'t match');
			return null;
		}
		$row_regex = '/<tr>(.+?)<\/tr>/';
		if (!preg_match_all($row_regex, $table[1], $rows)) {
			Utility_Logger::log(__METHOD__ . ': Hourly Row regex didn\'t match');
			return null;
		}
		$cell_regex = '/<td\s*>(.*?)<\/td>/';
		foreach ($rows[1] as $row) {
			if (!preg_match_all($cell_regex, $row, $cells)) {
				Utility_Logger::log(__METHOD__ . ': Hourly Cell regex didn\'t match');
				return null;
			}
			$clean_rows[] = $cells[1];
		}
		return $clean_rows;
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