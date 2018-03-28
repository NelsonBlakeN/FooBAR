<?php

include('php_api.php');

//create the common class
$debug = false;
$COMMON = new Common($debug);
	
//error checking
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//add and report dummy data 
$COMMON-> adddummyweek();
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
