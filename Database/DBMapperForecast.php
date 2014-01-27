<?php

class Database_DBMapperForecast extends Database_DBMapper {

	protected $table = 'weather_forecast';
	
	public function buildInsertQuery($clean) {
		return "INSERT INTO {$this->table} VALUES (\N, ....";
	}
	
	public function getRawDTOData() {
		//	make sure we have an array element for every column in the database table
		$raw = array_fill_keys(array_keys($this->columnType), 0);
		
		//	collect data from $this->dto
		return $raw;
	}

}

?>