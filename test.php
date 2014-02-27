<?php

require_once 'autoload.php';

$scraper = new Scraper_Wunderground();
$result = $scraper->scrape();
echo $result." records scraped.\n";

?>