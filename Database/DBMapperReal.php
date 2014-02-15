<?php

class Database_DBMapperReal extends Database_DBMapper {

	protected $table = 'weather_real';
	
	public function buildInsertQuery($clean) {
		return "INSERT INTO {$this->table} VALUES (\N, {$clean['site_id']}, {$clean['date']}, 
			{$clean['high']}, {$clean['high_unit']}, {$clean['low']}, {$clean['low_unit']}, 
			{$clean['rain']}, {$clean['rain_unit']}, {$clean['snow']}, {$clean['snow_unit']},
			{$clean['precip']}, {$clean['precip_unit']}, {$clean['cloud_cover']}, 
			{$clean['wind_speed']}, {$clean['wind_unit']}, {$clean['wind_direction']}, 
			{$clean['pressure']}, {$clean['pressure_unit']}, {$clean['pressure_coefficient']},
			{$clean['humidity']})";
	}
	
	public function getRawDTOData() {
		//	make sure we have an array element for every column in the database table
		$raw = array_fill_keys(array_keys($this->columnType), 0);
		//--------------------------------------------------------------------------------------
		//		date and site ID
		$raw['site_id'] = $this->dto->getSiteID();
		$raw['date'] = $this->dto->getForecastDate();	// will be yesterday
		//--------------------------------------------------------------------------------------
		//		high temp
		$raw['high'] = $this->dto->getHighTemp();
			if (isset($raw['high'])) $raw['high'] = round($raw['high'], 1);
		$raw['high_unit'] = $this->dto->getTempUnit();
		//--------------------------------------------------------------------------------------
		//		low temp
		$raw['low'] = $this->dto->getLowTemp();
			if (isset($raw['low'])) $raw['low'] = round($raw['low'], 1);
		$raw['low_unit'] = $this->dto->getTempUnit();
		//--------------------------------------------------------------------------------------
		//		rain
		$raw['rain'] = $this->dto->getRainAmount();
			if (isset($raw['rain'])) $raw['rain'] = round($raw['rain'], 1);
		$raw['rain_unit'] = $this->dto->getRainUnit();
		//--------------------------------------------------------------------------------------
		//		snow
		$raw['snow'] = $this->dto->getSnowAmount();
			if (isset($raw['snow'])) $raw['snow'] = round($raw['snow'], 1);
		$raw['snow_unit'] = $this->dto->getSnowUnit();
		//--------------------------------------------------------------------------------------
		//		precipitation (sometimes used to measure the moisuture in snow)
		$raw['precip'] = $this->dto->getPrecipitation();
			if (isset($raw['precip'])) $raw['precip'] = round($raw['precip'], 1);
		$raw['precip_unit'] = $this->dto->getPrecipitationUnit();
		//--------------------------------------------------------------------------------------
		//		cloud cover percentage
		$raw['cloud_cover'] = $this->dto->getCloudCover();
			if (isset($raw['cloud_cover'])) $raw['cloud_cover'] = round($raw['cloud_cover']);
		//--------------------------------------------------------------------------------------
		//		wind speed
		$raw['wind_speed'] = $this->dto->getWindSpeed();
			if (isset($raw['wind_speed'])) $raw['wind_speed'] = round($raw['wind_speed']);
		$raw['wind_unit'] = $this->dto->getWindSpeedUnit();
		//--------------------------------------------------------------------------------------
		//		wind direction
		$raw['wind_direction'] = $this->dto->getWindDirection();
			if (isset($raw['wind_direction'])) $raw['wind_direction'] = round($raw['wind_direction']);
		//--------------------------------------------------------------------------------------
		//		pressure
		$raw['pressure'] = $this->dto->getPressure();
			if (isset($raw['pressure'])) $raw['pressure'] = round($raw['pressure'], 2);
		$raw['pressure_unit'] = $this->dto->getPressureUnit();
		//--------------------------------------------------------------------------------------
		//		pressure coefficient (linear regression of daily pressure measures)
		$raw['pressure_coefficient'] = $this->dto->getPressureCoefficient();
			if (isset($raw['pressure_coefficient'])) 
					$raw['pressure_coefficient'] = round($raw['pressure_coefficient'], 3);
		//--------------------------------------------------------------------------------------
		//		humidity
		$raw['humidity'] = $this->dto->getHumidity();
			if (isset($raw['humidity'])) $raw['humidity'] = round($raw['humidity']);
		return $raw;
	}

}

?>