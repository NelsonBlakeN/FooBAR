/* ****************************************************
    File:       AdminPage.php
    Project:    CSCE 315 Project 1, Spring 2018
    Date:       3/19/2018
    Section:    504

    This file recieves the PHP post request to add a
	dummy week to the table. It makes an API request to
	add simulated data for an entire, hardcoded week into
	the database.
******************************************************* */

<?php

	include('PhpApi.php');

	// Create the API object
	$debug = false;
	$COMMON = new Common($debug);

	// Set error checking levels
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	$COMMON-> AddDummyWeek();
	echo("Dummy data added to week of 3-18-2018")

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
