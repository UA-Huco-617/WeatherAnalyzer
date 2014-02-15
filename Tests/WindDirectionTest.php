<?php

class WindDirectionTest extends PHPUnit_Framework_TestCase {

	public function testAverageDirection() {
		$wind = array(350, 10);
		$avg = Utility_WindDirection::getAverageWindDirection($wind);
		$this->assertEquals($avg, 0);
	}
}

?>