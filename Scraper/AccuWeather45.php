<?php

class Scraper_AccuWeather45 extends WeatherScraper {
	
	//	This scraper picks up 45 days of forecasts, so needs to do multiple
	//	URL requests until it runs out of data to scrape. Example URLs:
	//	http://www.accuweather.com/en/ca/edmonton/t5k/january-weather/52478?monyr=1/28/2014&view=table
	//	http://www.accuweather.com/en/ca/edmonton/t5k/february-weather/52478?monyr=2/1/2014&view=table
	//	http://www.accuweather.com/en/ca/edmonton/t5k/march-weather/52478?monyr=3/1/2014&view=table
	
	protected $siteID = 7;				//	your Site ID from the `weather_site` table in birdclub
	protected $siteURL = 'http://www.accuweather.com/en/ca/edmonton/t5k/';
	protected $date;
	protected $pageHasData = true;	//	flag to keep scraping
	
	public function __construct() {
		parent::__construct();
		$this->date = new Date();
	}
	
	public function scrape() {
		//	needs to scrape either 2 or 3 pages; when it encounters
		//	blank rows, the $pageHasData flag will be set to false
		while ($this->pageHasData) {
			$this->scrapeMonthlyPage();
			$this->date->advanceToNextMonth();
		}
		return count($this->weathercollection);
	}
	
	public function buildURL() {
		return $this->siteURL . strtolower($this->date->getMonthName()) . '-weather/52478?monyr=' .
			$this->date->getMonthDayYear() . '&view=table';
	}

	public function scrapeMonthlyPage() {
		$url = $this->buildURL();
		$html = $this->cleanup(file_get_contents($url));
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
		} else {
			return true;
		}
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
		$dto = new WeatherDTO($this);
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
			list(,$prose) = explode('/>', $m[1][4]);
			$prose = trim($prose);
			$dto->setProseDescription($prose);
		}
		return $dto;
	}
}

?>