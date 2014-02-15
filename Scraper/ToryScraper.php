<?php

class Scraper_ToryScraper extends Weather_RealWeatherScraper {

	protected $siteID = 8;		//	Site ID from birdclub database
	protected $siteURL = 'http://easweb.eas.ualberta.ca/weather_archive.php';
	//	hourly data is the URL above plus this $_GET data:
	//		?month1=2&day1=8&year1=2014&month2=2&day2=8&year2=2014&raw=generate+raw+data

	public function scrape() {
		if ( $this->scrapeTemp() and $this->scrapeHourlyData()) {
			return count($this->weathercollection);
		} else {
			return 0;
		}
	}
	
	public function scrapeTemp() {
		//	get hi and lo from the main page
		$this->html = $this->cleanup(Utility_SecretAgent::getURL($this->siteURL));
		$row = $this->extractYesterdaysRow($this->html);
		if ($row) {
			$this->setDTOFromRow($row);
			return true;
		} else {
			Utility_Logger::log( __METHOD__ . ' could not extract data.');
			return false;
		}
	}
	
	public function scrapeHourlyData() {
		$url = $this->buildHourlyURL();
		$html = $this->cleanup(Utility_SecretAgent::getURL($url));
		$rows = $this->extractYesterdaysHourlyRows($html);
		if (!$rows) return false;
		//	columns:
		//	[0] => solar_radiation_W
		//	[1] => temperature_C
		//	[2] => humidity_%
		//	[3] => pressure_kPa	
		//	[4] => rain_mm
		//	[5] => wind_speed_ms
		//	[6] => wind_direction
		//	[7] => wind_speed_max_ms
		//	[8] => wind_speed_max_time	
		//	[9] => heat_index
		//	[10] => wind_chill
		$cell_regex = '/<td>(.*?)<\/td>/';
		$this->dto->setForecastDate($this->yesterday->getCanonicalDate());
		$humidity = $pressure = $rain = $windspeed = $winddirection = array();
		foreach ($rows as $row) {
			preg_match_all($cell_regex, $row, $cells);
			$humidity[] = $cells[1][2];
			$pressure[] = $cells[1][3];
			$rain[] = $cells[1][4];
			$windspeed[] = $cells[1][5];
			$winddirection[] = $cells[1][6];
		}
		$this->dto->setHumidity(Utility_Statistics::getAverage($humidity));
		$this->dto->setPressure(Utility_Statistics::getAverage($pressure));
		$this->dto->setPressureCoefficient(Utility_Statistics::getLinearRegressionCoefficient($pressure));
		$this->dto->setPressureUnit('kPa');
		$this->dto->setRainAmount(array_sum($rain));
		$this->dto->setRainUnit('mm');
		$this->dto->setWindSpeed(Utility_Statistics::getAverage($windspeed));
		$this->dto->setWindSpeedUnit('m/s'); // meters per second! not the typical km/h
		$direction = Utility_WindDirection::getAverageWindDirection($winddirection);
		$this->dto->setWindDirection($direction);
		return true;
	}
	
	public function buildHourlyURL() {
		//	oddly, getting one day's data leaves off the zero hour, so
		//	we need to get a range from the day before yesterday to yesterday
		$before_yesterday = new Utility_Date('2 days ago');
		$month1 = $before_yesterday->getMonth();
		$day1 = $before_yesterday->getDay();
		$year1 = $before_yesterday->getYear();
		$month2 = $this->yesterday->getMonth();
		$day2 = $this->yesterday->getDay();
		$year2 = $this->yesterday->getYear();
		return $this->siteURL .= "?month1={$month1}&day1={$day1}&year1={$year1}&month2={$month2}&day2" .
			"={$day2}&year2={$year2}&raw=generate+raw+data";
	}
	
	public function extractYesterdaysRow($html) {
		$date = $this->yesterday->getDateAsSQL();
		$regex = '/<tr><td class="day">' . $date . '<\/td>(.+?)<\/tr>/';
		preg_match( $regex, $html, $matches );
		return $matches[1];
	}
	
	public function extractYesterdaysHourlyRows($html) {
		$yester = $this->yesterday->getDateAsSQL();
		$regex = "/<tr><td>$yester(.+?)<\/tr>/";
		preg_match_all($regex, $html, $matches);
		return $matches[1];
	}
	
	public function getColumnFromArray($column, $array) {
		$answer = array();
		foreach ($array as $row) $answer[] = $row[$column];
		return $answer;
	}
	
	public function setDTOFromRow($row) {
		$regex = '/<td>(.+?)<\/td>/';
		preg_match_all( $regex, $row, $matches );
		//	Tory temps are DECIMAL(4,2), but they'll get rounded
		//	off properly when they get inserted into the database.
		//	min temp ==> [1][0]
		//	max temp ==> [1][2]
		//	set high temp
		$this->dto->setHighTemp($matches[1][2]);
		// set low temp
		$this->dto->setLowTemp($matches[1][0]);
	}

}

?>