<?php

abstract class Database_DBMapper {

	protected $dbconn;
	protected $dto;
	protected $columnType = array();
	protected $table;	//	children should set this
	
	public function __construct(WeatherDTO $dto = null) {
		$this->dbconn = Database_DBConn::getConnection();
		$this->dto = $dto;
		$this->loadColumnMetadata();
	}

	public function buildSaveQuery() {
		//	someday, this might need to choose between INSERT and UPDATE. Not yet, though.
		$dirty = $this->getRawDTOData();
		$clean = $this->getCleanData($dirty);
		return $this->buildInsertQuery($clean);
	}
	
	public function loadColumnMetadata() {
		//	retrieves metadata (column names and data types) from the database table;
		//	getCleanData() will use this to prepare data for SQL query.
		$result = $this->dbconn->query("DESC {$this->table}");
		while ($row = $result->fetch_assoc()) $this->columnType[$row['Field']] = $row['Type'];
	}
	
	public function getCleanData($dirty) {
		//	this method uses metadata from the database table to quote/slash/numericize
		//	the data automatically based on the column type. It treats any unknown type as a string.
		$clean = array();
		if (get_magic_quotes_gpc()) $dirty = array_map('stripslashes', $dirty);	// kill evil magic quotes
		
		foreach ($dirty as $key => $value) {
			//	preserve NULL values, if they exist
			if (is_null($value) or $value === '') { $clean[$key] = 'NULL'; continue; }
			
			//	clean numeric types
			if (stripos($this->columnType[$key], 'int') !== false) { $clean[$key] = (int) $value; continue; }
			if (stripos($this->columnType[$key], 'dec') !== false) { $clean[$key] = (float) $value; continue; }
			if (stripos($this->columnType[$key], 'float') !== false) { $clean[$key] = (float) $value; continue; }
			if (stripos($this->columnType[$key], 'real') !== false) { $clean[$key] = (float) $value; continue; }
			if (stripos($this->columnType[$key], 'double') !== false) { $clean[$key] = (float) $value; continue; }
			if (stripos($this->columnType[$key], 'numeric') !== false) { $clean[$key] = (int) $value; continue; }
			
			//	otherwise, treat it as a string
			$clean[$key] =  "'" . $this->dbconn->real_escape_string( trim($value) ) . "'";
		}
		return $clean;
	}
	
	public function saveToDatabase() {
		$query = $this->buildSaveQuery();
		$this->dbconn->query($query);
		if ($this->dbconn->affected_rows != 1) {
			$this->dto->log('Database error: ' . $this->dbconn->errno . ':: ' . $this->dbconn->error );
			return false;
		}
		return true;
	}
	
	
	/*********************************************************
	*	abstract methods for children to override;
	*	real data and forecast data need to do these
	*	jobs differently.
	*********************************************************/
		
	abstract public function buildInsertQuery($data_array);
	abstract public function getRawDTOData();

}

?>