<?php

class DBConnTest extends PHPUnit_Framework_TestCase {

	public function testCanGetConnection() {
		$conn = Database_DBConn::getConnection();
		$this->assertNotNull( $conn );
	}

	public function testSingletonWorks() {
		$conn1 = Database_DBConn::getConnection();
		$conn2 = Database_DBConn::getConnection();
		$this->assertSame($conn1, $conn2);
	}

}

?>