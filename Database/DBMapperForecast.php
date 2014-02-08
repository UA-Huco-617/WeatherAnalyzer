<?php

class Database_DBMapperForecast extends Database_DBMapper {

	protected $table = 'weather_forecast';
	
	public function buildInsertQuery($clean) {
		return "INSERT INTO {$this->table} VALUES (\N, {$clean['site_id']}, 
			{$clean['scrape_date']}, {$clean['forecast_date']}, {$clean['high']}, {$clean['high_unit']}, 
			{$clean['low']}, {$clean['low_unit']}, {$clean['rain_amount']}, {$clean['rain_unit']}, 
			{$clean['snow_amount']}, {$clean['snow_unit']}, {$clean['chance_of_precip']}, {$clean['precip_amount']}, 
			{$clean['precip_unit']}, {$clean['wind_speed']}, {$clean['wind_unit']}, {$clean['wind_direction']},  
			{$clean['prose_forecast']})";
	}
	
	public function getRawDTOData() {
		//	make sure we have an array element for every column in the database table
		$raw = array_fill_keys(array_keys($this->columnType), 0);
		
		//	collect data from $this->dto
		$raw['site_id'] = $this->dto->getSiteID();
		$raw['scrape_date'] = $this->dto->getTodayAsSQL();
		$raw['forecast_date'] = $this->dto->getForecastDate();
		$raw['high'] = $this->dto->getHighTemp(); 
		$raw['high_unit'] = $this->dto->getTempUnit();
		$raw['low'] = $this->dto->getLowTemp();
		$raw['low_unit'] = $this->dto->getTempUnit();
		$raw['rain_amount'] = $this->dto->getRainAmount();
		$raw['rain_unit'] = $this->dto->getRainUnit();
		$raw['snow_amount'] = $this->dto->getSnowAmount();
		$raw['snow_unit'] = $this->dto->getSnowUnit();
		$raw['chance_of_precip'] = $this->dto->getChanceOfPrecip();
		$raw['precip_amount'] = $this->dto->getPrecipitation();
		$raw['precip_unit'] = $this->dto->getPrecipitationUnit();
		$raw['wind_speed'] = $this->dto->getWindSpeed();
		$raw['wind_unit'] = $this->dto->getWindSpeedUnit();
		$raw['wind_direction'] = $this->dto->getWindDirection();
		$raw['prose_forecast'] = $this->dto->getProseDescription();
		return $raw;
	}

}

?>