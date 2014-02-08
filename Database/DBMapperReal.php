<?php

class Database_DBMapperReal extends Database_DBMapper {

	protected $table = 'weather_real';
	
	public function buildInsertQuery($clean) {
		return "INSERT INTO {$this->table} VALUES (\N, {$clean['site_id']}, {$clean['date']}, 
			{$clean['high']}, {$clean['high_unit']}, {$clean['low']}, {$clean['low_unit']}, 
			{$clean['precip']}, {$clean['precip_unit']}, {$clean['cloud_cover']}, 
			{$clean['wind_speed']}, {$clean['wind_unit']}, {$clean['wind_direction']})";
	}
	
	public function getRawDTOData() {
		//	make sure we have an array element for every column in the database table
		$raw = array_fill_keys(array_keys($this->columnType), 0);
		$raw['site_id'] = $this->dto->getSiteID();
		$raw['date'] = $this->dto->getForecastDate();	// will be yesterday
		$raw['high'] = $this->dto->getHighTemp(); 
		$raw['high_unit'] = $this->dto->getTempUnit();
		$raw['low'] = $this->dto->getLowTemp();
		$raw['low_unit'] = $this->dto->getTempUnit();
		$raw['precip'] = $this->dto->getPrecipitation();
		$raw['precip_unit'] = $this->dto->getPrecipitationUnit();
		$raw['cloud_cover'] = $this->dto->getCloudCover();
		$raw['wind_speed'] = $this->dto->getWindSpeed();
		$raw['wind_unit'] = $this->dto->getWindUnit();
		$raw['wind_direction'] = $this->dto->getWindDirection();
		//$raw['prose_description'] = $this->dto->getProseDescription();
		return $raw;
	}

}

?>