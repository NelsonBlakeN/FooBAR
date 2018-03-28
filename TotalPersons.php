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

$total = $COMMON -> countrs( $COMMON-> all());
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