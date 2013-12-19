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

	//Open the dbconfig file to read host, user, pass
	$fname = "inc/dbconfig"; 
	if (!$handle = fopen($fname, 'r+'))
		abort("Couldn't open dbconfig. Perhaps you haven't installed?");
	$host = rtrim(fgets($handle), "\r\n");
	$user = rtrim(fgets($handle), "\r\n");
	$pass = rtrim(fgets($handle), "\r\n");
	fclose($handle);

	$con = mysqli_connect($host, $user, $pass, 'shorten');
	if (mysqli_connect_errno())
		abort("MySQL Error: " . mysqli_connect_error());

?>