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

				$this->con = new mysqli($host, $user, $pass, 'shorten');
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
			$sql = "SELECT COUNT(`alias`) FROM `links`";
			$result = $this->con->query($sql);
			if(!$result)
  				abort("MySQL Error: ".$this->con->error);

			return $result->fetch_object();
		}

		public function addAlias($alias, $href) {
			if (strlen($alias) < 2 || strlen($href) < 2)
				return false;

			//Make sure this alias doesn't already exist in the table
			$sql = "SELECT * FROM `links` WHERE `alias`='$alias'";
			$result = $this->con->query($sql);
			if(!$result) {
  				abort("MySQL Error: ".$this->con->error);
  				return false;
  			}
  			if ($result->num_rows > 0){
  				return false;
  			}

			//Insert and error check
			$sql = "INSERT INTO `links` (alias, href) VALUES ('$alias', '$href')";
			$result = $this->con->query($sql);
			if(!$result) {
  				abort("MySQL Error: ".$this->con->error);
  				return false;
  			}

			return true;
		}

		public function fetchAlias($alias) {
			if (strlen($alias) < 2)
				return false;

			$sql = "SELECT alias, href FROM `links` WHERE `alias`='$alias' AND `valid`=1";
			$result = $this->con->query($sql);
			if(!$result) {
  				abort("MySQL Error: ".$this->con->error);
  				return false;
  			}

  			if ($result->num_rows > 0){
  				return false;
  			}

  			$row = $result->fetch_row(MYSQL_NUM);
  			return $row[1];
		}

		public function clearDatabase() {
			$sql = "DELETE FROM `links`";
			$result = $this->con->query($sql);
			if(!$result) {
  				abort("MySQL Error: ".$this->con->error);
  				return false;
  			}

			return true;			
		}
	}

	$db = new databaseConnection();

?>