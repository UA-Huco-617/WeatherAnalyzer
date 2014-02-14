<?php

class Utility_Statistics {
	
	public static function getLinearRegressionCoefficient($array) {
		$mult = array();
		$avg_x = array_sum(array_keys($array)) / count($array);
		$avg_y = array_sum($array) / count($array);
		foreach ($array as $key => $value) {
			$x1[$key] = $key - $avg_x;
			$y1[$key] = $value - $avg_x;
			$mult[] = $x1[$key] * $y1[$key];
			$square_x[] = $x1[$key] * $x1[$key];
		}
		return array_sum($mult) / array_sum($square_x);
	}
}

?>