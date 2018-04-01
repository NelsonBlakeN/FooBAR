/* ****************************************************
    File:       AddPerson.php
    Project:    CSCE 315 Project 1, Spring 2018
    Date:       3/19/2018
    Section:    504

	This file recieves the PHP post request to add a
	person to the database, and makes an API request
	for adding the person by providing the obtained time
	and date.
******************************************************* */
<?php

	include('PhpApi.php');

	// Create API object
	$debug = false;
	$COMMON = new Common($debug);
	date_default_timezone_set("America/Chicago");

	// Input variables
	$time = ($_POST["time"]);
	$date = ($_POST["date"]);

	echo("Adding person at $time on $date<br>");

	// Set error checking values
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	$COMMON -> AddPerson($time,$date);

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
