/* ****************************************************
    File:       Testing.php
    Project:    CSCE 315 Project 1, Spring 2018
    Date:       3/19/2018
    Section:    504

    This file serves to test all major functions of the front
	end pedestrian counter portal.
******************************************************* */

<?php

	include('PhpApi.php');

	// Create API object
	$debug = false;
	$COMMON = new Common($debug);
	date_default_timezone_set("America/Chicago");

	// Set error checking values
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	// --------------------------------
	// Name: TestClear
	// PreConditions:  None
	// PostConditions: The database will be attempted to be cleared,
	//				   and the success will be validated.
	//----------------------------------
	function TestClear(){
		global $COMMON;
		$COMMON-> ClearDatabase();
		return ($COMMON->CountRs($COMMON->All()));
	}

	// --------------------------------
	// Name: TestDataLoad
	// PreConditions:  None
	// PostConditions: Simulated data will be added, and the
	//				   success of the request will be evaluated.
	//----------------------------------
	function TestDataLoad(){
		global $COMMON;
		$COMMON-> ClearDatabase();
		$COMMON-> AddDummyWeek();
		return ($COMMON->CountRs($COMMON->All()));
	}

	// --------------------------------
	// Name: TestRanges
	// PreConditions:  None
	// PostConditions: A range of dates will be attempted to be
	//				   created, and the success will be evaluated.
	//----------------------------------
	function TestRanges(){
		global $COMMON;
		$dates = $COMMON -> DateRange("2018-03-18","2018-03-22");
		foreach ($dates as $date) {
     		echo("$date<br>");
		}

		$date1 = new datetime(date('m/d/Y', time()));
		$date1 -> setTime("06","00");
		$date1 -> setDate("2018","03","18");

		$date2 = new datetime(date('m/d/Y', time()));
		$date2 -> setTime("10","00");
		$date2 -> setDate("2018","03","18");

		$hours = $COMMON -> TimeRange($date1,$date2);
		foreach($hours as $hour){
			echo($hour->format("H:i"));
			echo("<br>");
		}
	}

	// --------------------------------
	// Name: TestMain
	// PreConditions:  None
	// PostConditions: All previous tests will be run, and
	//				   their success rate will be clear.
	//----------------------------------
	function TestMain(){
		$clearRs = TestClear();
		echo("Testing ClearDatabase(), CountRs(), All()... should be 0: $clearRs<br>");
		$clearRs = TestDataLoad();
		echo("Testing AddDummyDay(), AddDummyWeek(), AddPerson()... should be more than 100 or so: $clearRs<br>");
		echo("Date and hour range test...<br>");
		TestRanges();
	}

	TestMain();

?>
