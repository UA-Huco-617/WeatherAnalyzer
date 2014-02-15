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
	

	/**************************************************************************
			*	The regex produces this data:
			*	[1][1] => high 
			*	[1][1] => low 
			*   [1][1] => date
			*   [1][2] => prosedesc
			*   [1][2] => winddirection
			*   [1][1] => windspeed
	**************************************************************************/	
	
	public function buildDTOFromRow($row) {
	
		$dto = new Weather_WeatherDTO($this);
		
		$hi_regex='/Hi: <strong>(.+?)&deg;/';
		$low_regex='/Lo: <strong>(.+?)&deg;/';
		preg_match_all($hi_regex, $row, $hightemp);
		preg_match_all($low_regex, $row, $lowtemp);

		$dto->setHighTemp($hightemp[1][1]);
		$dto->setLowTemp($lowtemp[1][1]);


		
		$date_regex='/<span class="h5">(.+?)<\/span>/';
		preg_match_all($date_regex, $row, $date);		
			if( $date[1][1][0]='Today') {
				$date[1][1][0]=date('D M d');
			}
			if( $date[1][1][1]='Tomorrow') {
			$date1[1][1][1]=date('D M d',time()+86400);
			}
		$dto->setForecastDate($date[1][1]);
		

		$prose_regex='/<div class="symbol_50x50d symbol_d(.+?)" alt="(.+?)" title/';  
		preg_match_all($prose_regex, $row, $desc);		
		$dto->setProseDescription($desc[1][2]);
		
		$wind_dir_regex='/symb-wind\/(.+?)" alt="(.+?)"/';
		preg_match_all($wind_dir_regex, $row, $windDirection);
		$dto->setWindDirection($windDirection[1][2]);
		
		$wind_speed_regex='/height="28" \/>\s*<strong>(\d+)<\/strong>/';
		preg_match_all($wind_speed_regex, $row, $windSpeed);
		$dto->setWindSpeed($windSpeed[1][1]);
		
		return $dto;

			
	}
	

}
?>