<?php

/**********************************************************************
*        Huco 617.B2 (Winter 2014)
*        WeatherManager is an managerial class that builds a series
*        of web scrapers, instructs them to collect weather forecast 
*        data and inserts it all into a database.
**********************************************************************/

class WeatherManager {

	protected $scrapers = array();		//  collection of scrapers
	protected $path_to_scrapers;

	public function __construct() {
		$this->path_to_scrapers = __DIR__ . '/Scraper';
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
		foreach (new DirectoryIterator($this->path_to_scrapers) as $fileInfo) {
    		if ($fileInfo->getExtension() == 'php') require_once $fileInfo->getPathname();
    	}
	}
	
	public function log($message = null) {
		if (!empty($message)) Utility_Logger::log($message);
	}
    
	public function run() {
		$successful_scrapers = $records_saved = 0;
		foreach ($this->scrapers as $scraper) {
			if (!$scraper->scrape()) {
				Utility_Logger::log( get_class($scraper) .' failed on Site ID ' . $scraper->getSiteID() );
				continue;
			}
			$successful_scrapers++;
			$collection = $scraper->getWeatherDTOCollection();
			$records_saved += $collection->saveToDatabase();
		}
		Utility_Logger::log("End run: {$successful_scrapers} scrapers saved {$records_saved} records into the database.");
	}
}

?>