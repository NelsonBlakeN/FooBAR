/* ****************************************************
    File:       ClearPersons.php
    Project:    CSCE 315 Project 1, Spring 2018
    Date:       3/19/2018
    Section:    504

	This file recieves the PHP post request to clear
	all data from the database. It makes an API request
	that empties all entries from the table.
******************************************************* */

<?php

	include('PhpApi.php');

	// Create the API object
	$debug = false;
	$COMMON = new Common($debug);
	date_default_timezone_set("America/Chicago");

	echo("clearing all persons<br>");

	$COMMON->ClearDatabase();

	// Set error checking values
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

?>

<html>
	<head>
	</head>
	<body style="background-color:powderblue;">

		<form>
			<input type="button" value="Return" onclick="window.location.href='http://projects.cse.tamu.edu/amiller15/Mainsite.php'" />
		</form>

	</body>
</html>
