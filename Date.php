<?php

class Date {

	/************************************************
	*	Date is a lightweight date formatting class;
	*	you can set it with a string like 'Friday'
	*	and it will try to set the date properly:
	*		$d = new Date('a week from Wednesday');
	*		$d = new Date('Tuesday');
	*		$d = new Date('yesterday');
	************************************************/
	
	protected $month = '0';
	protected $day = '0';
	protected $year = '0';
	protected $months = array( 'Unknown', 'January', 'February', 'March', 'April', 'May', 'June', 'July',
			'August', 'September', 'October', 'November', 'December' );
	
	public function __construct($string = 'now') {
		date_default_timezone_set( 'America/Edmonton' );
		$this->setFromString($string);
	}
	
	/************************************************
	*			GETTERS
	************************************************/
	
	public function getDateAsSQL() {
		return sprintf( '%04d-%02d-%02d', $this->year, $this->month, $this->day );
	}
	
	public function getDay() {
		return $this->day;
	}
	
	public function getMonth() {
		return $this->month;
	}
	
	public function getYear() {
		return $this->year;
	}


	/************************************************
	*			SETTERS
	************************************************/
	
	public function setDay($day) {
		$day = (int) $day;
		if ( $day >= 0 and $day <= 31 ) $this->day = $day;
	}
	
	public function setMonth($month) {
		$month = (int) $month;
		if ( $month >= 0 and $month <= 12 ) $this->month = $month;
	}
	
	public function setYear($year) {
		$this->year = (int) $year;
	}
	
	public function setMonthByName($string) {
		$months = array( 'unk', 'jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec' );
		foreach ( $months as $num => $month ) {
			if (stripos($string, $month) !== false) {
				$this->month = $num;
				break;
			}
		}
	}
	
	public function setFromString($string) {
		if (empty($string)) return;
		$timestamp = strtotime($string);
		$this->day = idate('d', $timestamp);
		$this->month = idate('m', $timestamp);
		$this->year = idate('Y', $timestamp);
	}
	
	public function setFromSQLString($string) {
		if (empty($string)) return;
		list( $year, $month, $day ) = explode( '-', $string, 3 );
		$this->setYear( $year );
		$this->setMonth( $month );
		$this->setDay( $day );
	}


}

?>