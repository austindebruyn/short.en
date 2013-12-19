<?php
	error_reporting(0);

	//Gracefully quit the script
	function abort($error) {
		$print = "<html><head><title>Install aborted</title></head>";
		$print = $print."<body><h1>Install aborted</h1>";
		$print = $print."<p>Something has gone wrong while creating the database.<br> The script ".
						"returned the following error:</p>";
		$print = $print."<p style='text-size: 0.8em; font-family: Courier;'>";
		$print = $print.$error;
		$print = $print."</p></body></html>";
		die($print);
	}

	//Re-entry from POST form, do not run this on first parse
	if (isset($_POST['host'])) {
		$host = $_POST['host'];
		$user = $_POST['user'];
		$pass = $_POST['pass'];

		$con = mysqli_connect($host, $user, $pass);

		//Test 1: Connect to MySQL
		if (mysqli_connect_errno()) {
			abort("MySQL Error: " . mysqli_connect_error());
		}

		//Test 2: Create a database
		$sql="CREATE DATABASE IF NOT EXISTS shorten";
		if (!mysqli_query($con, $sql)) {
			abort("MySQL Error: " . mysqli_error($con));
		}

		//Test 3: Select the database
		$con = new mysqli($host, $user, $pass, 'shorten');
		if ($con->connect_errno > 0) {
			abort("MySQL Error: " . $con->connect_error);
		}

		//Install tables we need
		$sql = 	"CREATE TABLE IF NOT EXISTS links ( ".
				"	alias 	VARCHAR(8) PRIMARY KEY,".
				"	href	VARCHAR(1024),".
				"	valid 	BIT(1) NOT NULL".
				")";
		if (!$result = $con->query($sql))	
			abort("MySQL Error: " . $con->error);

		$fname = "inc/dbconfig"; 
		$handle = fopen($fname, 'x');
		$success = fwrite($handle, "$host\n$user\n$pass\n");
		fclose($handle);

		if (!$success)
			abort("Could not write the config file. Check your permissions.");
		?>
		
		<html>
			<head>
				<title>Install completed</title>
			</head>
			<body>
				<h2>The install succeeded.</h2>
				<p>
					You can now return to the <a href="/">home page</a>.
				</p>
			</body>
		</html>

		<?
		exit;
	}


?>
<html>
	<head>
		<title>Install short.en</title>
	</head>
	<body>
		<h1>Install</h1>
		<h2>Connect to MySQL</h2>
		<form action="install.php" method="POST">
			MySQL Host: <input type="text" name="host" id="host" value="example.com"><br>
			Username: <input type="text" name="user" id="user"><br>
			Password: <input type="password" name="pass" id="pass"><br>
			<input type="submit" value="Create Database">
		</form>
	</body>
</html>
