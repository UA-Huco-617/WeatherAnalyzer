<?php

class Scraper_MyForecast extends WeatherScraper{
	
	protected $siteID = 6;				
	protected $siteURL = 'http://www.myforecast.com/bin/expanded_forecast_15day.m?city=54149&metric=true';
	protected $date;
	protected $pageHasData = true;	
	
	public function __construct() {
		parent::__construct();
		$this->date = new Date();
	}

	public function __construct() {
		$this->weathercollection = new WeatherCollection();
		date_default_timezone_set('America/Edmonton');
	}
	
	public function getSiteID() {
		return $this->siteID;
	}
	
	public function getSiteURL() {
		return $this->siteURL;
	}

	public function getWeatherDTOCollection() {

		return $this->weathercollection;
	}

	public function log($message = null) {
		if (!empty($message)) Logger::log($message);
	}
	
	public function cleanup($text = '') {
		return str_replace("\n", ' ', $text);
	}
	
	
	}


//this is the function to fill out I only change things below here now.
	//THE FUNCTIONS ALREADY EXIST!  call getters and setters....WeatherDTO and DATE
	//remember to do the top-down narrative thing...every function followed by next level of abstractions

	public function scrape() {
		$html = file_get_contents($this->$siteURL);
		$html = $this->cleanup($html);
		//can I make a function that will set each day as a separate row to then convert to dto?
		//or do I need to do a separate command here for each day?
	}

//Day 1 - Today

	public function extractTodaysRow($html) {
		$today = new Date('Today');
		//can't test...is this the correct way to get the date?
		$date = $today->setYear(2014);
		$date = $today->setMonthByName();
		$date = $today->setDay();
		$date = $today->getCanonicalDate();
		//again, cannot test at the moment...is $date in the correct place?
		$regex = '/<td align="left" valign="middle" bgcolor="#3366CC" class="wt">'.$date.'(.*?)<\/tr>/';
		preg_match($regex, $html, $matches);
		//without testing, this should isolate today's row
		return $matches[0];
	}

	public function setDTOFromRow($row) {
		$dto = new WeatherDTO($this);
		$regex = '/<td align="center" valign="middle" class="normal">(.*?)<\/td>/';
		preg_match_all($regex, $row, $matches);
/*
************************
* Data                 *
* proseDescription [0] *
* High Temp [1]        *
* Low Temp [2]         *
* Wind Speed/Dir [3]   *
* Humidity [4]         *
* Comfort Level [5]    *
* UV Index [6]         *
* Prob Precip [7]      *
* 24 h precip total [8]*
***********************/

			$dto->setForecastDate('Today')
			//without testing, this should isolate individual parts of above defined row 'today'
			//having done that, not sure if I need [0][0]...or just [0]
			
			//prose
			$dto->setProseDescription($matches[0][0]);

			//high
			$high = str_replace('&#176;', '', $matches[0][1]);
			$dto->setHighTemp($high);
			
			//low
			$low = str_replace('&#176', '' , $matches[0][2]);
			$dto->setLowTemp($low);

			//chanceprecip
			$chanceprecip = str_replace('%', '', $matches[0][7]);
			$dto->setChanceOfPrecip($chanceprecip);

			//precipamount this is an issue - site gives cm when snow...but rain in same place?
			$precipamount = str_replace('cm', '', $matches[0][8]);
			$dto->setSnowAmount($precipamount);


	}




//3. Get all rows

$row_regex = '/<tr (.*?)<\/tr>/';

preg_match_all($row_regex, $html, $row_matches);


$cell_regex = '/<td align="center" valign="middle" class="normal">(.*?)<\/td>/';

/*
These are the variables that Harvey has listed, so make the above match the exact terms - for my own ease of understanding!
      protected $chanceprecip;
      protected $date;                    //    forecast date
      protected $hightemp;
      protected $lowtemp;
      protected $rainAmount;
      protected $rainUnit = 'mm';         //    default value
      protected $proseDescription;  //    i.e., 'partly cloudy'
      protected $precipitation;
      protected $precipUnit = 'mm'; // default unit
      protected $snowAmount;
      protected $snowUnit = 'cm';         //    default value
      protected $tempUnit = 'C';          //    default value
      
      protected $scraper;                       //    scraper that built this object
      protected $siteID;                        //    scraper's site ID
      protected $dbhelper;                //    DatabaseMapper object to handle I/O
*/






/*
*************************
* DATES ($date_matches) *
* TODAY/Day 1 = [0][0]  *
* Day 2 = [0][1]        *
* Day 3 = [0][2]        *
* Day 4 = [0][3]        *
* Day 5 = [0][4]        *
* Day 6 = [0][5]        *
* Day 7 = [0][6]        *
* Day 8 = [0][7]        *
* Day 9 = [0][8]        *
* Day 10 = [0][9]       *
* Day 11 = [0][10]      *
* Day 12 = [0][11]      *
* Day 13 = [0][12]      *
* Day 14 = [0][13]      *
* Day 15 = [0][14]      *
*************************







// here down is other copied stuff to maybe put in/play with! -----------------
// keeping in mind that above I have already moved table data and dates into arrays - so if I can sort the above arrays, may not need some of these functions?
//to create the dto to send out...this is the version from Harvey's AccuWeather45 - what are my differences?
//see...high, low, etc. is ONLY designated here....not the str replace bit!  ah ha
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

?>