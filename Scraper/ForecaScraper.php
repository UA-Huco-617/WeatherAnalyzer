<?php

class Scraper_ForecaScraper extends Weather_WeatherScraper {
	
	//	ForecaScraper shows 10day forecast.
	// http://www.foreca.com/Canada/Edmonton?tenday -> site url
	
	protected $siteID = 4;				
	protected $siteURL = 'http://www.foreca.com/Canada/Edmonton?tenday';
	
	
	public function __construct() {
		$this->weathercollection = new Weather_WeatherCollection();
		$this->date = new Utility_Date();
	}
	
	
	
	
	public function scrape() { // it guarantees child class will have the same body!!(when it has 'abstract'
		$row =$this->extractRowsFromHTML($this->html);  //get everything first
		//print_r($row);
		//exit;
		foreach ($rows as $row)  {    //put it in!
			//build a DTO
			$dto = $this->buildDTOFromRow($row);
		//	push it onto the collection
			$this->addToCollection($dto);
		}
		return count($this->weathercollection); //and return the numbers of objects that I have!
	}
	
	
	public function extractRowsFromHTML($html) {
		//input: whole HTML page
		//output: an array of rows from the HTML table
		$div_regex='/<div class="c1 daily(?:.+?)">(.+?)<\/div>/';
		preg_match_all($div_regex, $html, $matches);
	
		
		//now i want all the rows as a giant array!
		$row_regex='/<tr>(.+?)<\/tr>/';
		preg_match_all($row_regex,$rows[1][0],$cells);
		return $cells[1];
		
	}

	
	public function buildURL() {
		return $this->siteURL . strtolower($this->date->getMonthName()) . '-weather/52478?monyr=' .
			$this->date->getMonthDayYear() . '&view=table';
	}

	public function scrapeMonthlyPage() {
		$url = $this->buildURL();
		$html = $this->cleanup(Utility_SecretAgent::getURL($url));
		$html = $this->extractFirstTable($html);	//	two tables on this page!
		if (is_null($html)) {
			Logger::log(__CLASS__ . " cannot find a table to parse on '{$url}'");
			$this->pageHasData = false;
			return;
		}
		$rows = $this->extractRows($html);
		$this->extractWeatherData($rows);
	}
	
	public function extractFirstTable($html) {
		if (preg_match('/<table\s*(?:.*?)>(.+?)<\/table>/', $html, $matches)) {
			return $matches[1];
		} else {
			return null;
		}
	}
	
	public function extractRows($html) {
		$regex = '/<tr (.+?)<\/tr>/';
		preg_match_all($regex, $html, $matches);
		//print_r($matches);
		return $matches[1];
	}
	
	public function extractWeatherData($rows) {
		foreach ($rows as $row) {
			if ( $this->haveValidRow($row)) {
				$dto = $this->buildDTO($row);
				if ($dto) {
					$date = $this->extractDate($row);
					$dto->setForecastDate($date);
					$this->weathercollection->addToCollection($dto);
				}
				//var_dump($dto);
			}
		}
	}
	
	public function extractDate($html) {
		//	the forecast days are <a> tags, so the </a> here will fail on non-forecast days
		$regex = '/<th (?:.+?)(\w+)<br\s*\/>([\/0-9]+?)<\/a><\/th>/';
		if (preg_match($regex, $html, $matches)) {
			return $matches[1] . ' ' . $matches[2];
		} else {
			return null;
		}
	}
	
	public function haveValidRow($html) {
		//	The row has no data if we have </th> then <td>&nbsp;</td>
		if (preg_match('/<\/th>\s*<td>&nbsp;<\/td>/', $html)) {
			//	out of data; set flag
			$this->pageHasData = false;
			return false;
		}
		//	an old weather day means we haven't gotten to good data yet
		if ( preg_match('/class="pre">/', $html)) {
			return false;
		}
		return true;
	}
	
	public function buildDTO($html) {
		/******************************************************************
		*	The regex produces this data:
		*	[1][0] => high (remove entity: &#176;)
		*	[1][1] => low (remove entity: &#176;)
		*	[1][2] => precip (split to capture unit: prob mm)
		*	[1][3] => snow (split to capture unit: prob cm)
		*	[1][4] => forecast (remove image; keep prose)
		*	[1][5] => avg hi (ignore)
		*	[1][6] => avg low (ignore)
		*	
		*	The row has no data if we have </th>\s*<td>&nbsp;</td>
		******************************************************************/
		if (stripos($html, "\n") !== false ) $html = $this->cleanup($html);
		if ( !$this->haveValidRow($html)) return null;
		$dto = new Weather_WeatherDTO($this);
		$regex = '/<td(?:.*?)>(.+?)<\/td>/';
		preg_match_all($regex, $html, $m);
		//	HIGH
		$high = str_replace('&#176;', '', $m[1][0]);
		$dto->setHighTemp($high);
		//	LOW
		$low = str_replace('&#176;', '', $m[1][1]);
		$dto->setLowTemp($low);
		//	PRECIP
		//	echo "Precip line: {$m[1][2]}\n";
		if (isset($m[1][2]) && preg_match('/\d/', $m[1][2])) {
			list( $precip, $punit ) = explode(' ', $m[1][2]);
			$dto->setPrecipitation($precip);
			$dto->setPrecipitationUnit($punit);
		}
		//	SNOW -- this stays in the summer, but they
		//	seem to use the Precip column for rain.
		//	echo "Snow line: {$m[1][3]}\n";
		if (isset($m[1][3]) && preg_match('/\d/', $m[1][3])) {
			list($snow, $sunit) = explode(' ', $m[1][3]);
			$dto->setSnowAmount($snow);
			$dto->setSnowUnit($sunit);
		}
		//	FORECAST
		if (isset($m[1][4]) && !preg_match('/<td>&nbsp;<\/td>/',$m[1][4])) {
			//echo "Prose: |{$m[1][4]}|\n";
			list(,$prose) = explode('/>', $m[1][4]);
			$prose = trim($prose);
			$dto->setProseDescription($prose);
		}
		return $dto;
	}
}

?>