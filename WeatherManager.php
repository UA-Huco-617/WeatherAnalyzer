<?php

define('PATH_TO_SCRAPERS', '/Users/hquamen/Documents/Courses/Huco 617 - OOP (2014)/WeatherAnalyzer/Scraper');	//	put w/ autoload

/**********************************************************************
*        Huco 617.B2 (Winter 2014)
*        WeatherManager is an managerial class that builds a series
*        of web scrapers, instructs them to collect weather forecast 
*        data and inserts it into a database.
**********************************************************************/

class WeatherManager {

	protected $scrapers = array();		//  collection of scrapers

	public function __construct() {
		$this->loadScraperFiles();
		$this->instantiateScrapers();
	}
        
	public function addScraper(WeatherScraper $scraper) {
		$this->scrapers[] = $scraper;
	}
	
	public function instantiateScrapers() {
		$classes = array_filter( get_declared_classes(), array('WeatherManager', 'is_scraper') );
		foreach ($classes as $scraper) $this->scrapers[] = new $scraper($this);
	}
	
	//	Used as a callback function in instantiateScrapers()
	protected function is_scraper( $string ) {
		return (strpos($string, 'Scraper_') !== false);
	}
        
	public function loadScraperFiles() {
		//	require every file in directory X
		foreach (new DirectoryIterator(PATH_TO_SCRAPERS) as $fileInfo) {
    		if ($fileInfo->getExtension() == 'php') require_once $fileInfo->getPathname();
    	}
	}
	
	public function log($message = null) {
		if (!empty($message)) Logger::log($message);
	}
    
	public function run() {
		$successful_scrapers = $records_saved = 0;
		foreach ($this->scrapers as $scraper) {
			if (!$scraper->scrape()) {
				Logger::log( get_class($scraper) .' failed on Site ID ' . $scraper->getSiteID() );
				continue;
			}
			$successful_scrapers++;
			$collection = $scraper->getWeatherDTOCollection();
			$records_saved += $collection->saveToDatabase();
		}
		Logger::log("End run: {$successful_scrapers} scrapers saved {$records_saved} records into the database.");
	}
}

?>