<?php

	//Gracefully quit the script
	function abort($error) {
		$print = "<html><head><title>Aborted</title></head>";
		$print = $print."<body><h1>Page aborted</h1>";
		$print = $print."<p>Something went wrong when creating this page.<br> The script ".
						"returned the following error:</p>";
		$print = $print."<p style='text-size: 0.8em; font-family: Courier;'>";
		$print = $print.$error;
		$print = $print."</p></body></html>";
		die($print);
	}

	/* validURL
	 *	Checks if a URL is safe for database input
	 *	@param href a url to sanitize
	 */
	function validURL($href) {
		if (strlen($href) < 5)
			return false;

		$filter = "/((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/";
		return preg_match($filter, $href);
	}

?>