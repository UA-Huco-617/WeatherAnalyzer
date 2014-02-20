<?php
class Scraper_EnvironmentCanada extends Weather_WeatherScraper{

	protected $siteID = 11;				
	protected $siteURL = 'http://weather.gc.ca/city/pages/ab-50_metric_e.html';	
	protected $detailedForecast;	//	contains longer prose, including wind info		
	
	public function scrape(){
		$divs = $this->extractDIVsFromHTML($this->html);
		$this->detailedForecast = $this->extractDetailedForecast($this->html);
		foreach ($divs as $div) {
			$dto = $this->buildDTOFromDIV($div);
			$this->addToCollection($dto);
		}
		return count($this->weathercollection);
	}

	public function extractDIVsFromHTML($html) {
		$div_regex = '/<div class="fperiod">(.+?)<\/div>/';
		preg_match_all($div_regex, $html, $divs);
		return $divs[1];
	}

	public function extractDetailedForecast($html) {
		$regex = '/<div class="fdetails">(.+?)<\/div>/';
		preg_match($regex, $html, $details);
		return $details[1];
	}

	public function buildDTOFromDIV($div){
		$dto = new Weather_WeatherDTO($this);

		//----------------------------------------------------------------------------
		//	DATE
		//	looks like:
		//	<span class="fdate">17&nbsp;<abbr title="February">Feb</abbr>
		$date_regex = '/<span class="fdate">(\d+)&nbsp;<abbr title="(\w+)">/';
		if (preg_match($date_regex, $div, $date)) {
			//	will look like => Monday 17 February
			//	ignore the year; strtotime() will assume current year
			$date_string = $date[1] . ' ' . $date[2];
			$dto->setForecastDate($date_string);
		} else {
			Utility_Logger::log(__METHOD__ . ' could not parse a proper date. HTML changed? Returning without a DTO.');
			return null;
		}
		

		//----------------------------------------------------------------------------
		//	Prose Description
		//	let's get this from the detailed forecast rather than from the img's @alt;
		//	problem: there are sometimes two entries per data ("Today" and "Tonight")
		$date_header = $date[1] . '&nbsp;' . $date[2];
		$prose_regex = "/{$date_header}<\/span><\/dt>\s*<dd>(.+?)<\/dd>/";
		preg_match_all($prose_regex, $this->detailedForecast, $prose);
		$desc = join(' ', $prose[1]);
		$dto->setProseDescription(trim($desc));

		//----------------------------------------------------------------------------
		//	Wind
		//	don't take this from the current conditions at the top of the page; rather,
		//	let's use the appropriate prose sentence in the detailed forecast:
		//	"A mix of sun and cloud. Wind becoming west 20 km/h gusting to 40 this afternoon. High plus 2."

		$wind_regex = '/Wind (?:becoming )?(\w+) (\d+) (.+?)[. ]/';
		//	sometimes that regex won't match, so don't set Wind data unless we get a hit.
		if (preg_match($wind_regex, $desc, $windData)) {
			$direction = Utility_WindDirection::getDegrees($windData[1]);
			$dto->setWindDirection($direction);
			$dto->setWindSpeed($windData[2]);
			$dto->setWindSpeedUnit($windData[3]);
		}

		//----------------------------------------------------------------------------
		//Chance of Precipitation
		//	if it's non-existent, this regex won't match. If there's a %, it's this:
		//	<li class="pop" title="Chance of Precipitation"> 60%</li>
		//	Note: sometimes this appears as prose in the Detailed Forecast, but
		//	not in the DIVs at the top. Should this part be smarter?
		$COP_regex = '/title="Chance of Precipitation">\s*(\d+)%\s*<\/li>/';
		if (preg_match($COP_regex, $div, $cop)) {
			$dto->setChanceOfPrecip($cop[1]);
		}
		
		//----------------------------------------------------------------------------
		//High - High not provided for all dates
		$high_regex = '/title="High">([-.0-9]+)&deg;<abbr title="(?:\w+)">(\w+)<\/abbr>/';
		if (preg_match($high_regex, $div, $high)) {
			$dto->setHighTemp($high[1]);
		}
		
		//----------------------------------------------------------------------------
		//	Low - low not provided for all dates
		$low_regex = '/title="Low">([-.0-9]+)&deg;<abbr title="(?:\w+)">(\w+)<\/abbr>/';
		if (preg_match($low_regex, $div, $low)) {
			$dto->setLowTemp($low[1]);
			//	assume low tmp unit == high temp unit
		}

		return $dto;
	}


}

?>
