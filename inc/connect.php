<?php

	//Gracefully quit the script
	function abort($error) {
		$print = "<html><head><title>Install aborted</title></head>";
		$print = $print."<body><h1>Install aborted</h1>";
		$print = $print."<p>Something went wrong when creating this page.<br> The script ".
						"returned the following error:</p>";
		$print = $print."<p style='text-size: 0.8em; font-family: Courier;'>";
		$print = $print.$error;
		$print = $print."</p></body></html>";
		die($print);
	}

	class databaseConnection {

		private $numEntries = 0;
		private $con;

		public $connected = false;

		function __construct() {
			//Open the dbconfig file to read host, user, pass
			$fname = "inc/dbconfig"; 
			if (!$handle = fopen($fname, 'r+')) 
				abort("Couldn't open dbconfig. Perhaps you haven't installed?");
			else {
				$host = rtrim(fgets($handle), "\r\n");
				$user = rtrim(fgets($handle), "\r\n");
				$pass = rtrim(fgets($handle), "\r\n");
				fclose($handle);

				$this->con = mysqli_connect($host, $user, $pass, 'shorten');
				if (mysqli_connect_errno())
					abort("MySQL Error: " . mysqli_connect_error());
				else
					$this->connected = true;
			}
		}

		function __destruct() {
			if ($this->connected)
				$this->con->close();
		}

		public function countEntries() {

		}

		public function addAlias($alias, $href) {

		}

		public function fetchAlias($alias) {

		}

		public function clearDatabase() {

		}
	}

	$db = new databaseConnection();

?>