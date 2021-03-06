<?php
	require_once('inc/functions.php');
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
			$this->assertTrue($db->countEntries() == 0);
		}

		function testAddAlias1() {
			global $db;
			$result = $db->addAlias("test1", "http://1");
			$this->assertTrue($result);
			$this->assertTrue($db->countEntries() == 1);
		}

		function testAddAlias2() {
			global $db;
			$result = $db->addAlias("test2", "http://2");
			$this->assertTrue($result);
			$this->assertTrue($db->countEntries() == 2);
		}

		function testDuplicateAlias() {
			global $db;
			$result = $db->addAlias("test1", "http://3");
			$this->assertFalse($result);
			$this->assertTrue($db->countEntries() == 2);
		}
		
		function testFetchAlias() {
			global $db;
			$result = $db->fetchAlias("test1");
			$this->assertEqual($result, "http://1");
		}
		
		function cleanupDatabase() {
			global $db;
			$db->clearDatabase();
			$this->assertTrue($db->countEntries() == 0);
		}
	}

	class SecurityTests extends UnitTestCase {

		function validURL_1() {
			$url1 = "";
			$url2 = "hello world";
			$url3 = "><script type='text/javascript'></script><'";

			$this->assertFalse(validURL($url1));
			$this->assertFalse(validURL($url2));
			$this->assertFalse(validURL($url3));
		}

		function validURL_2() {
			$url1 = "http://google.com";
			$url2 = "wikipedia.org/en/Computer";
			$url3 = "ftp://short.en/";
			$url4 = "https://testing.com/hy-phens.js";
		
			$this->assertTrue(validURL($url1));
			$this->assertTrue(validURL($url2));
			$this->assertTrue(validURL($url3));
			$this->assertTrue(validURL($url4));
		}

		function testRedirectLoop() {
			$url1 = "short.en/Test";
			$url2 = "http://www.short.en/";

			$this->assertFalse(validURL($url1));
			$this->assertFalse(validURL($url2));	
		}
	}

?>