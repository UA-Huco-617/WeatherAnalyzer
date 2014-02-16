<?php

class Scraper_MyForecast extends Weather_WeatherScraper{
	
	protected $siteID = 6;				
	protected $siteURL = 'http://www.myforecast.com/bin/expanded_forecast_15day.m?city=54149&metric=true';

	public function scrape() {
		$table = $this->extractForecastTable($this->html);
		$rows=$this->extractRowsFromTable($table);
		foreach ($rows as $row) {
			$dto=$this->setDTOFromRow($row);
			$this->addToCollection($dto);
		}
		return count($this->weathercollection);
	}

	public function extractForecastTable($html) {
		$table_regex = '/<table width="100%" border="0" cellspacing="1" cellpadding="3">(.+?)<\/table>/';
		preg_match($table_regex, $html, $table);
		return $table[1];
	}

	public function extractRowsFromTable($html) {
		$row_regex = '/<tr(?:.+?)>(.+?)<\/tr>/';
		preg_match_all($row_regex, $html, $row_matches);
		//	$row[0] is a header, so throw it away
		array_shift($row_matches[1]);
		return $row_matches[1];
	}

	public function setDTOFromRow($row) {
		$dto = new Weather_WeatherDTO($this);
		$cell_regex = '/<td(?:.*?)>(.+?)<\/td>/';
		preg_match_all($cell_regex, $row, $cells);

		/*
		[1][0] => date
	    [1][1] => <img> (ignore)
	    [1][2] => prose forecast
	    [1][3] => High => 2&#xB0;C
	    [1][4] => Low => -8&#xB0;C
	    [1][5] => Wind Speed | unit | direction => 23&nbsp;km/h / WSW
	    [1][6] => Humidity => 59%
	    [1][7] => comfort level (ignore)
	    [1][8] => UV index (ignore)
	    [1][9] => Chance of Precip
	    [1][10] => 24 hr precip total
	    */
		
		//	date
		$dto->setForecastDate($cells[1][0]);
			
		//prose		
		$dto->setProseDescription(trim($cells[1][2]));

		//high
		list($high, $unit) = explode('&#xB0;', $cells[1][3]);
		$dto->setHighTemp($high);
		$dto->setTempUnit(trim($unit));
			
		//low
		list($low, $unit) = explode('&#xB0;', $cells[1][4]);
		$dto->setLowTemp($low);

		//	wind speed; unit; direction
		//	23&nbsp;km/h / WSW
		$slash = strrpos($cells[1][5], '/');
		$front = substr($cells[1][5], 0, $slash - 1);
		$direction = substr($cells[1][5], $slash + 1);
		list($speed, $unit) = explode('&nbsp;', $front);
		$dto->setWindSpeed($speed);
		$dto->setWindSpeedUnit(trim($unit));
		$degrees = Utility_WindDirection::getDegrees(trim($direction));
		$dto->setWindDirection($degrees);

		//	humidity
		$humidity = trim(str_replace('%', '', $cells[1][6]));
		$dto->setHumidity($humidity);

		//	chanceprecip
		$chanceprecip = str_replace('%', '', $cells[1][9]);
		$dto->setChanceOfPrecip($chanceprecip);

		//	precip amount [1][10] is thus far empty,
		//	except for a &nbsp;
		//	Let's log something if this changes.
		if (trim($cells[1][10]) != '&nbsp;')
			Utility_Logger::log('Site ID' . $this->siteID . ' has real data for 24-hour Precip: "'. $cells[1][10] . '"');

		return $dto;
	}
}

?>