/* ****************************************************
    File:       TotalPersons.php
    Project:    CSCE 315 Project 1, Spring 2018
    Date:       3/19/2018
    Section:    504

    This file recieves a PHP request to count all
	of the entries in the database, and return that value.
******************************************************* */

<?php

	include('PhpApi.php');

	// Create the API object
	$debug = false;
	$COMMON = new Common($debug);
	date_default_timezone_set("America/Chicago");

	// Set error checking values
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	// Obtain the total number of entries
	$total = $COMMON -> CountRs( $COMMON -> All());
	echo("$total peope counted since last reset");

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
