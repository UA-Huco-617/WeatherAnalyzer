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
		//	set the DTO
		$this->dto->setHighTemp($this->validate($m[1][0]));
		$this->dto->setLowTemp($this->validate($m[1][1]));
		$precip = $this->validate($m[1][7]);
		if (is_null($precip)) $precip = 0;
		$this->dto->setPrecipitation($precip);
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
			Utility_Logger::log(__METHOD__ . ' cannot parse rows from HTML. Failing.');
			return false;
		}
		$windSpeed = $this->getWindSpeed($rows);
		$this->dto->setWindSpeed($windSpeed);
		$this->dto->setWindSpeedUnit('km/h'); // yeah, hard-coded, but it's EnviroCan!
		$windDirection = $this->getWindDirection($rows);	//	account for units of 10s
		$this->dto->setWindDirection($windDirection);
		$pressure = $this->getPressure($rows);
		$this->dto->setPressure($pressure);
		$humidity = $this->getHumidity($rows);
		$this->dto->setHumidity($humidity);
		return true;
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
	
	public function getWindSpeed($rows) {
		$total = $count = 0;
		foreach ($rows as $row) {
			if (empty($row[self::SPEED_INDEX]) or 
				preg_match(self::NOT_NUMERIC_DATA, $row[self::SPEED_INDEX])) continue;
			$total += $row[self::SPEED_INDEX];
			$count++;
		}
		return round($total / $count);
	}
	
	public function getWindDirection($rows) {
		//	Environment Canada measures this in units of 10 degrees;
		//	Use trig -- convert to (x,y) points on the unit circle
		//	and average, then find the arctangent of the averaged point.
		$sum_x = $sum_y = $count = 0;
		foreach ($rows as $row) {
			if (empty($row[self::DIRECTION_INDEX]) or 
				preg_match(self::NOT_NUMERIC_DATA, $row[self::DIRECTION_INDEX])) continue;
			$dir = $row[self::DIRECTION_INDEX] * 10;
			$sum_x += cos(deg2rad($dir));
			$sum_y += sin(deg2rad($dir));
			$count++;
		}
		$avg_x = $sum_x / $count;
		$avg_y = $sum_y / $count;
		$angle = rad2deg(atan($avg_y / $avg_x));
		if ($angle < 0) $angle += 360;
		return round($angle);
	}
	
	public function getPressure($rows) {
		$total = $count = 0;
		foreach ($rows as $row) {
			if (empty($row[self::PRESSURE_INDEX]) or 
				preg_match(self::NOT_NUMERIC_DATA, $row[self::PRESSURE_INDEX])) continue;
			$total += $row[self::PRESSURE_INDEX];
			$count++;
		}
		return round(($total / $count), 2);
	}
	
	public function getHumidity($rows) {
		$total = $count = 0;
		foreach ($rows as $row) {
			if (empty($row[self::HUMIDITY_INDEX]) or 
				preg_match(self::NOT_NUMERIC_DATA, $row[self::HUMIDITY_INDEX])) continue;
			$total += $row[self::HUMIDITY_INDEX];
			$count++;
		}
		return round($total / $count);
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