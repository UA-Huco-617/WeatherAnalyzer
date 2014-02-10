<?php

class Utility_WindDirection {

	protected static $angles = array(
		array('abbrev' => 'N', 'direction' => 'North', 'degree' => 0),
		array('abbrev' => 'NNE', 'direction' => 'North-northeast', 'degree' => 22.5),
		array('abbrev' => 'NE', 'direction' => 'NorthEast', 'degree' => 45),
		array('abbrev' => 'ENE', 'direction' => 'East-northeast', 'degree' => 67.5),
		array('abbrev' => 'E', 'direction' => 'East', 'degree' => 90),
		array('abbrev' => 'ESE', 'direction' => 'East-southeast', 'degree' => 112.5),
		array('abbrev' => 'SE', 'direction' => 'SouthEast', 'degree' => 135),
		array('abbrev' => 'SSE', 'direction' => 'South-southeast', 'degree' => 157.5),
		array('abbrev' => 'S', 'direction' => 'South', 'degree' => 180),
		array('abbrev' => 'SSW', 'direction' => 'South-southwest', 'degree' => 202.5),
		array('abbrev' => 'SW', 'direction' => 'Southwest', 'degree' => 225),
		array('abbrev' => 'WSW', 'direction' => 'West-southwest', 'degree' => 247.5),
		array('abbrev' => 'W', 'direction' => 'West', 'degree' => 270),
		array('abbrev' => 'WNW', 'direction' => 'West-northwest', 'degree' => 292.5),
		array('abbrev' => 'NW', 'direction' => 'Northwest', 'degree' => 315),
		array('abbrev' => 'NNW', 'direction' => 'North-northwest', 'degree' => 337.5)
	);
	
	public function getAverageWindDirection($rows) {
		//	Use trig -- convert to (x,y) points on the unit circle
		//	and average, then find the arctangent of the averaged point.
		$sum_x = $sum_y = 0;
		$count = count($rows);
		foreach ($rows as $direction) {
			$sum_x += cos(deg2rad($direction));
			$sum_y += sin(deg2rad($direction));
		}
		$avg_x = $sum_x / $count;
		$avg_y = $sum_y / $count;
		$angle = rad2deg(atan($avg_y / $avg_x));
		if ($angle < 0) $angle += 360;
		if ($angle > 360) $angle =- 360;
		if ($angle == 360) $angle = 0;
		return round($angle);
	}

	public static function getDirection($degree) {
		//	each unit is 22.5 degrees;
		//	divide and round to get nearest direction;
		//	but do it modulo 16
		$index = round($degree/22.5) % 16;
		return self::$angles[$index]['direction'];
	}
	
	public static function getDegrees($direction) {
		if (!preg_match('/[^.0-9]/', $direction)) return (float) $direction;
		$direction = strtoupper($direction);
		//	Weather-in-Canada.com uses 'V' for 'W'
		$direction = str_replace('V', 'W', $direction);
		if (strlen($direction) > 3) $direction = self::abbreviate($direction);
		if (is_null($direction)) return null;
		foreach (self::$angles as $d) {
			if ($d['abbrev'] == $direction) return $d['degree'];
		}
		return null;
	}
	
	public static function abbreviate($direction) {
		//	convert a longish description to an abbrevation
		$direction = self::cleanup($direction);
		foreach (self::$angles as $d) {
			if ($direction == self::cleanup($d['direction'])) return $d['abbrev'];
		}
		return null;
	}
	
	public static function cleanup($string) {
		$string = preg_replace('/\W+/', '', $string);
		return trim(strtolower($string));
	}




}