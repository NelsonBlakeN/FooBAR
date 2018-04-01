<?php

include('php_api.php');

//global variables
$debug = false;
$COMMON = new Common($debug);
date_default_timezone_set("America/Chicago");
	
//error checking
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//test the clearing of the database
function testclear(){
	global $COMMON; 
	$COMMON-> cleardatabase();
	return ($COMMON->countrs($COMMON->all()));
}

//test the loading of data onto the database
function testdataload(){
	global $COMMON;
	$COMMON-> cleardatabase();
	$COMMON-> adddummyweek();
	return ($COMMON->countrs($COMMON->all()));
}

//test the range functions (daterange() and timerange())
function testranges(){
	global $COMMON;
	$dates = $COMMON -> daterange("2018-03-18","2018-03-22");
	foreach ($dates as $date) {
     	echo("$date<br>");
	}
	
	$dt1 = new datetime(date('m/d/Y', time()));
	$dt1 -> setTime("06","00");
	$dt1 -> setDate("2018","03","18");
	
	$dt2 = new datetime(date('m/d/Y', time()));
	$dt2 -> setTime("10","00");
	$dt2 -> setDate("2018","03","18");
	
	$hours = $COMMON -> timerange($dt1,$dt2);
	foreach($hours as $hour){
		echo($hour->format("H:i"));
		echo("<br>"); 
	}
}

//this will run
function testmain(){
	$clearrs = testclear();
	echo("testing cleardatabase(), countrs(), all()... should be 0: $clearrs<br>");
	$clearrs = testdataload();
	echo("testing adddummyday(), adddummyweek(), addperson()... should be more than 100 or so: $clearrs<br>");
	echo("Date and hour range test...<br>");
	testranges();
}

/*
in addition to running this testmain successfully, a few inputs into the chart inputs 
on the main site of the website will complete a thurough testing of the interface. Make sure to test with bad (ie. impossible) values and date reanges that are too long. If the outputs are correct, everything is in order
*/

testmain();

?>