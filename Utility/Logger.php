<?php

class Utility_Logger {

	const LOGFILE = '/home/hquamen/web-docs/weather/log.txt';
	
	public static function log($message = '') {
		date_default_timezone_set('America/Edmonton');
		$message = date('D j M Y g:i a') . ' -- ' . $message . "\n";
		@file_put_contents(self::LOGFILE, $message, FILE_APPEND);
	}
}
?>