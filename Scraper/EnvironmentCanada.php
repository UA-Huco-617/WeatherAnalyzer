<?php
class Scraper_EnvironmentCanada extends Weather_WeatherScraper{

	protected $siteID = '11';				
	protected $siteURL = 'http://weather.gc.ca/city/pages/ab-50_metric_e.html';			
	
	public function scrape(){
		$rows= $this->extractRowsFromHTML($this->html);
		foreach ($rows as $row) {
			$dto = $this->buildDTOFromRow($row);
			$this->addToCollection($dto);
		}
		return count($this->weathercollection);

	}

	public function extractRowsFromHTML($html){
		$html = str_replace("\n", "", $html);
		$regexhtml = '/<h4>(.+?)<\/div>/';
		preg_match_all($regexhtml, $html, $rows);
		$rows = $rows[0];
		return $rows;
	}



	
	public function buildDTOFromRow($row){
		$dto = new Weather_WeatherDTO($this);
		
		$html = file_get_contents('http://weather.gc.ca/city/pages/ab-50_metric_e.html');
		$html = str_replace("\n", "", $html);
		$regex = '/"mainContent">(.+?)"wb-invisible">D/';
		preg_match_all($regex, $html, $cells);
		$cells = $cells[0];


		//DATE

		$fregex = '/"fdate">(\d+)&nbsp;<abbr title="(\w+)">/';
		preg_match_all($fregex, $cells[0], $date);
		$x= 0;
		foreach ($date[1] as $value) {
			
			$date[1][$x] = $date[1][$x] . " " . $date[2][$x] . " 2014";
			$date[1][$x] = date('d/m/Y', strtotime($date[1][$x]));
			$x++;
		}
		$date = $date[1];
		$dto->setForecastDate($date);


		$dto->setDate($date[0]);




		//Wind Rows

		$windRow_regex = '/"longContent">(.+?)<\/dd>/';
		preg_match_all($windRow_regex, $cells[0], $windRows);
		$windRows = $windRows[0][0];



		//Wind Speed Unit

		$windSpeedUnit_regex = '/km\/h/';
		preg_match_all($windSpeedUnit_regex, $cells[0], $windSpeedUnit);
		$windSpeedUnit = $windSpeedUnit[0];
		$dto->setWindSpeedUnit($windSpeedUnit);



		//Wind Direction and Speed

		$directionspeed_regex = '/(\w+)<\/abbr>\s*(\d+)\s*<abbr title/';
		preg_match_all($directionspeed_regex, $windRows, $directionspeed);
		$windSpeed = $directionspeed[2];
		$direction = $directionspeed[1];
		$dto->setWindSpeed($windSpeed);
		$dto->setWindDirection($direction);



		//Description

		$description_regex = '/.gif" alt="(.+?)"/';
		preg_match_all($description_regex, $cells[0], $description);
		$description = $description[1];
		unset($description[1]);
		$description = array_values($description);
		$dto->setProseDescription($description);




		//Chance of Precipitation

		$COP_regex = '/"pop"(.+?)<\/li> /';
		preg_match_all($COP_regex, $cells[0], $COP);
		$COP = $COP[1];
		$x = 0;
		foreach ($COP as $value) {
			if (strcspn($COP[$x], '0123456789') != strlen($COP[$x])){
				preg_match_all('/[0-9][0-9]?%/', $COP[$x], $number);
				$COP[$x] = $number[0][0];
				$x++;}
			else{
				$COP[$x] = null;
				$x++;
			}
		}
		$dto->setChanceOfPrecip($COP);



		//High - High not provided for all dates

		$high_regex = '/"high"(.+?)<\/li>/';
		preg_match_all($high_regex, $cells[0], $high);
		$high = $high[1];
		$x=0;
		foreach ($high as $value) {
			if (strcspn($high[$x], '0123456789') != strlen($high[$x])){
				preg_match_all('/-?[0-9][0-9]?[0-9]?/',$high[$x] , $matches);
				$high[$x] = $matches[0][0];
			$x++;}
			else{
				$high[$x] = null;
				$x++;
			}
		}	
		$dto->setHighTemp($high);

		

		//Low - Low not provided for all dates

		$low_regex = '/"low"(.+?)<\/li>/';
		preg_match_all($low_regex, $cells[0], $low);
		$low = $low[1];
		$x = 0;
		foreach ($low as $value) {
			if ($low[$x] == '>&nbsp'){
				$low[$x] = null;
				$x = $x++;
			}
			if (strcspn($low[$x], '0123456789') != strlen($low[$x])){
				preg_match_all('/-?[0-9][0-9]?[0-9]?/',$low[$x] , $matches);
				$low[$x] = $matches[0][0];
			$x++;}
			else{
				$low[$x] = null;
				$x++;
			}
		}
			$dto->setLowTemp($low);
			


			//Pressure

			$pressure_regex='/Pressure.+?([.0-9]+)&nbsp;/';
			preg_match_all($pressure_regex, $cells[0], $pressure);
			$pressure = $pressure[1];
			$dto->setPressure($pressure);


			//Pressureunit

			$pressureunit_regex='/"kilopascals">(kPa)<\/abbr>/';
			preg_match_all($pressureunit_regex, $cells[0], $pressureunit);
			$pressureunit = $pressureunit[1];
			$dto->setPressureUnit($pressureunit);




			//Humidity
			$humidity_regex = '/Humidity:<\/dt>.+?([.0-9]+%)<\/dd>/';
			preg_match_all($humidity_regex, $cells[0], $humidity);
			$humidity = $humidity[1];
			$dto->setHumidity($humidity);

			return $dto;


	}


}

?>
