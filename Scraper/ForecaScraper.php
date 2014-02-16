<?php

class Scraper_ForecaScraper extends Weather_WeatherScraper {
	
	//	ForecaScraper shows 10day forecast.
	// http://www.foreca.com/Canada/Edmonton?tenday -> site url
	
	protected $siteID = 4;				
	protected $siteURL = 'http://www.foreca.com/Canada/Edmonton?tenday';
	
	public function scrape() {
		$rows=$this->extractRowsFromHTML($this->html);
			foreach ($rows as $row) {
				$dto=$this->buildDTOFromRow($row);
				$this->addToCollection($dto);
			}
			return count($this->weathercollection);
	}

	public function extractRowsFromHTML($html) {
		$div_regex='/<div class="c1 daily(?:.+?)">(.+?)more/';
		preg_match_all($div_regex, $html, $rows);
		return $rows[1];	
	}
	
	public function buildDTOFromRow($row) {
	
		$dto = new Weather_WeatherDTO($this);
		
		$hi_regex='/Hi: <strong>(.+?)&deg;/';
		$low_regex='/Lo: <strong>(.+?)&deg;/';
		preg_match_all($hi_regex, $row, $hightemp);
		preg_match_all($low_regex, $row, $lowtemp);
		$dto->setHighTemp($hightemp[1][0]);
		$dto->setLowTemp($lowtemp[1][0]);


		$date_regex='/<span class="h5">(.+?)<\/span>/';
		preg_match_all($date_regex, $row, $date);
		$dto->setForecastDate($date[1][0]);
		

		$prose_regex='/<div class="symbol_50x50d symbol_d(.+?)" alt="(.+?)" title/';  
		preg_match_all($prose_regex, $row, $desc);
		$dto->setProseDescription($desc[2][0]);
		
		$wind_dir_regex='/symb-wind\/(.+?)" alt="(.+?)"/';
		preg_match_all($wind_dir_regex, $row, $windDirection);
		$direction = Utility_WindDirection::getDegrees($windDirection[2][0]);
		$dto->setWindDirection($direction);
		
		//$wind_speed_regex='/height="28" \/>\s*<strong>(\d+)<\/strong>/';
		//	revise to the following regex, which will also pick up the unit
		//	(that's important b/c different User Agents produce different units!)
		$wind_speed_regex = '/<strong>([-.0-9]+)<\/strong>\s*(.+?)\s*<\/span>/';
		preg_match_all($wind_speed_regex, $row, $windSpeed);
		$dto->setWindSpeed($windSpeed[1][0]);
		$wind_unit = trim($windSpeed[2][0]);
		//	brief normalization attempt:
		if ($wind_unit == 'ms') $wind_unit = 'm/s';
		if ($wind_unit == 'kmh') $wind_unit = 'km/h';
		$dto->setWindSpeedUnit($wind_unit);
		
		return $dto;
	}

}
?>
