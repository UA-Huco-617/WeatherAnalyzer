<?php

class StatisticsTest extends PHPUnit_Framework_TestCase {

	public function testLinearRegression() {
		$array = array(101, 100.8, 100.6, 100.4, 100.2, 100, 99.8, 
		99.7, 99.6, 99.6, 99.6, 99.6, 99.7, 99.7, 99.8, 99.9, 
		100, 100, 100, 100.1, 100.1, 100, 100, 100);
		$slope = Utility_Statistics::getLinearRegressionCoefficient($array);
		$slope = round($slope, 2);
		$this->assertEquals(-0.02, $slope);
	}
}

?>