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
	
		
		
		$hi_regex='/Hi: <strong>(.+?)&deg;/';
		$low_regex='/Lo: <strong>(.+?)&deg;/';
		preg_match_all($hi_regex, $html, $high);
		preg_match_all($low_regex, $html, $low);

		$dto->setHighTemp($high[1][0]);
		$dto->setLowTemp($low[1][0]);


		
		$date_regex='/ >(.+?)<\/td><\/tr> <tr><td>/';
		preg_match_all($date_regex, $row, $date);
		
	
		$dto= new Weather_WeatherDTO($this);
			//is this a class or a funcyion??? how do we use it??
		
		$dto->setForecastDate($date[1][0]);


		$low_regex = '/Min:&nbsp;(.+?)&/';
		preg_match_all($low_regex, $row, $low);

		$dto->setLowTemp($low[1][0]);

		$max_regex = '/Max:&nbsp;(.+?)&deg;C/';
		preg_match_all($max_regex, $row, $high);
		
		$dto->setHighTemp($high[1][0]);

		$pic_regex = '/alt="(.+?)"title=/';
		preg_match_all($pic_regex, $row, $desc);
		
		$dto->setProseDescription($desc[1][0]);
		
		return $dto;

			
	}
	

}
?>