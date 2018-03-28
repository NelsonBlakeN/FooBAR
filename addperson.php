<?php

include('php_api.php');

//global variables
$debug = false;
$COMMON = new Common($debug);
date_default_timezone_set("America/Chicago");

//input variables
$time = ($_POST["time"]);
$date = ($_POST["date"]);

echo("Adding person at $time on $date<br>");
	
//error checking
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//adding he person through the common class
$COMMON -> addperson($time,$date);

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