<?php

//*****************************************************************
//	Database Configuration
//*****************************************************************

define('HOST', 'localhost');
define ('USER', 'dmckechn');
define ('PWD', '7hr58jh5');
define ('DB', 'dmckechn');

class Database_DBConn {

	private static $connection;		//	the connection itself
	
	private function __construct() { }
	
	public static function getConnection() {
		if ( empty( self::$connection ) ) {
			try {
				self::$connection =  new mysqli( HOST, USER, PWD, DB );
			} catch ( Exception $e ) {
				die( "I'm sorry. The database is temporarily down. Please try again later.\n" );
			}
		}
		return self::$connection;
	}

}

?>