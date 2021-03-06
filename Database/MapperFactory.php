<?php

class Database_MapperFactory {

	public static function getDatabaseMapper($client = null) {
		$type = get_class($client);
		switch (strtolower($type)) {
			case 'weather_weatherdto':
				return new Database_DBMapperForecast($client);
				break;
			case 'weather_realweatherdto':
				return new Database_DBMapperReal($client);
				break;
			default:
				return new Database_DBMapperForecast($client);
				
		}
	}
}
?>