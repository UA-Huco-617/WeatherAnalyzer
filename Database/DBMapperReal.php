<?php

class Database_DBMapperReal extends Database_DBMapper {

	protected $table = 'weather_real';
	
	public function buildInsertQuery($clean) {
		return "INSERT INTO {$this->table} VALUES (\N, {$clean['site_id']}, {$clean['date']}, 
			{$clean['high']}, {$clean['high_unit']}, {$clean['low']}, {$clean['low_unit']}, 
			{$clean['precip']}, {$clean['precip_unit']}, {$clean['cloud_cover']}, 
			{$clean['wind_speed']}, {$clean['wind_unit']}, {$clean['wind_direction']}, 
			{$clean['pressure']}, {$clean['humidity']})";
	}
	
	public function getRawDTOData() {
		//	make sure we have an array element for every column in the database table
		$raw = array_fill_keys(array_keys($this->columnType), 0);
		$raw['site_id'] = $this->dto->getSiteID();
		$raw['date'] = $this->dto->getForecastDate();	// will be yesterday
		$raw['high'] = $this->dto->getHighTemp();
			if (isset($raw['high'])) $raw['high'] = round($raw['high'], 1);
		$raw['high_unit'] = $this->dto->getTempUnit();
		$raw['low'] = $this->dto->getLowTemp();
			if (isset($raw['low'])) $raw['low'] = round($raw['low'], 1);
		$raw['low_unit'] = $this->dto->getTempUnit();
		$raw['precip'] = $this->dto->getPrecipitation();
			if (isset($raw['precip'])) $raw['precip'] = round($raw['precip'], 1);
		$raw['precip_unit'] = $this->dto->getPrecipitationUnit();
		$raw['cloud_cover'] = $this->dto->getCloudCover();
			if (isset($raw['cloud_cover'])) $raw['cloud_cover'] = round($raw['cloud_cover']);
		$raw['wind_speed'] = $this->dto->getWindSpeed();
			if (isset($raw['wind_speed'])) $raw['wind_speed'] = round($raw['wind_speed']);
		$raw['wind_unit'] = $this->dto->getWindSpeedUnit();
		$raw['wind_direction'] = $this->dto->getWindDirection();
			if (isset($raw['wind_direction'])) $raw['wind_direction'] = round($raw['wind_direction']);
		$raw['pressure'] = $this->dto->getPressure();
			if (isset($raw['pressure'])) $raw['pressure'] = round($raw['pressure'], 2);
		$raw['humidity'] = $this->dto->getHumidity();
			if (isset($raw['humidity'])) $raw['humidity'] = round($raw['humidity']);
		return $raw;
	}

}

?>