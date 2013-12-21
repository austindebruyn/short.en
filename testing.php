<?php
	require_once('inc/connect.php');
	require_once('simpletest/autorun.php');

	class DatabaseTest extends UnitTestCase {

		function testConnection() {
			global $db;
			$this->assertTrue($db->connected);
		}

		function testClearDatabase() {
			global $db;
			$db->clearDatabase();
			$this->assertTrue($db->countEntries() === 0);
		}

		function testAddAlias1() {
			global $db;
			$result = $db->addAlias("test1", "http://1");
			$this->assertTrue($result);
			$this->assertTrue($db->countEntries() === 1);
		}

		function testAddAlias2() {
			global $db;
			$result = $db->addAlias("test2", "http://2");
			$this->assertTrue($result);
			$this->assertTrue($db->countEntries() === 2);
		}

		function testDuplicateAlias() {
			global $db;
			$result = $db->addAlias("test1", "http://3");
			$this->assertFalse($result);
			$this->assertTrue($db->countEntries() === 2);
		}
		
		function testFetchAlias() {
			global $db;
			$result = $db->fetchAlias("test1");
			$this->assertTrue($result === "http://1");
		}
		
		function cleanupDatabase() {
			global $db;
			$db->clearDatabase();
			$this->assertTrue($db->countEntries() === 0);
		}
	}

?>