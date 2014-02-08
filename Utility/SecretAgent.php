<?php

class Utility_SecretAgent {

	public static function getURL($url = null) {
		if (is_null($url)) return null;
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_USERAGENT, self::getAgent());
		curl_setopt($curl, CURLOPT_TIMEOUT, 25); // in seconds
		$html = curl_exec($curl);
		$error = curl_error($curl);
		if (!empty($error)) Utility_Logger::log('Curl error: ' . $error);
		curl_close($curl);
		return $html;
	}
	
	public static function getAgent() {
		$db = Database_DBConn::getConnection();
		$res = $db->query('SELECT agent FROM weather_agent ORDER BY RAND() LIMIT 1');
		if ($res->num_rows != 1) {
			Utility_Logger:log("Database Error: Retrieved {$res->num_rows} user agents in " . __CLASS__ );
			return null; //	probably OK to keep fetching page, so don't exit
		}
		$row = $res->fetch_assoc();
		return $row['agent'];
	}

}

?>