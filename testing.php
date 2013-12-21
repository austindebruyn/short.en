<?php
	require_once('simpletest/autorun.php');
	require_once('inc/connect.php');

	class DatabaseTest extends UnitTestCase {

		function testConnection() {
			$this->assertTrue($db->connected);
		}

		function testClearDatabase() {
			$db->clearDatabase();
			$this->assertTrue($db->countEntries() === 0);
		}

		function testAddAlias1() {
			$result = $db->addAlias("test1", "http://1");
			$this->assertTrue($result);
			$this->assertTrue($db->countEntries() === 1);
		}

		function testAddAlias2() {
			$result = $db->addAlias("test2", "http://2");
			$this->assertTrue($result);
			$this->assertTrue($db->countEntries() === 2);
		}

		function testDuplicateAlias() {
			$result = $db->addAlias("test1", "http://3");
			$this->assertFalse($result);
			$this->assertTrue($db->countEntries() === 2);
		}
		
		function testFetchAlias() {
			$result = $db->fetchAlias("test1");
			$this->assertTrue($result === "http://1");
		}
		
		function cleanupDatabase() {
			$db->clearDatabase();
			$this->assertTrue($db->countEntries() === 0);
		}
	}
?>