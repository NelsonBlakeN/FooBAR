<?php


include('CommonMethods.php');
$debug = false;
$COMMON = new Common($debug);

//prints out the current number of persons in the list
function printcount()
{
	global $debug; global $COMMON;
	
	$sql1 = "SELECT * FROM Passerbys";
	$rs = $COMMON-> executeQuery($sql1, $_SERVER["SCRIPT_NAME"]);
	$count = 0;
	while ($row = $rs->fetch(PDO::FETCH_ASSOC)){
		++$count;
	}
	echo "Passerbys seen: ";
	echo $count;
	
}

//simulates the adding of a person at the current time
function adddummyperson(){
	global $debug; global $COMMON;

	//add a new element
	$sql2 = "INSERT INTO Passerbys (`time`, `date`, `year`) VALUES (CURRENT_TIME(), CURRENT_DATE(), CURRENT_DATE())";
	$rs = $COMMON-> executeQuery($sql2, $_SERVER["SCRIPT_NAME"]);
}

function adddummyweek(){
	global $debug; global $COMMON;

	//add a new element

	$sql= "INSERT INTO Passerbys (`time`, `date`, `year`) VALUES ('16:20:55', '2018-03-18', '2018')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`, `year`) VALUES ('6:20:55', '2018-03-18', '2018')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`, `year`) VALUES ('6:50:55', '2018-03-18', '2018')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`, `year`) VALUES ('6:50:55', '2018-03-18', '2018')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`, `year`) VALUES ('6:50:55', '2018-03-18', '2018')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`, `year`) VALUES ('6:41:55', '2018-03-18', '2018')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`, `year`) VALUES ('16:58:55', '2018-03-19', '2018')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`, `year`) VALUES ('1:58:55', '2018-03-19', '2018')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`, `year`) VALUES ('10:58:55', '2018-03-19', '2018')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`, `year`) VALUES ('14:58:55', '2018-03-20', '2018')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`, `year`) VALUES ('14:58:55', '2018-03-20', '2018')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`, `year`) VALUES ('5:41:55', '2018-03-21', '2018')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`, `year`) VALUES ('20:20:55', '2018-05-22', '2018')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`, `year`) VALUES ('17:20:55', '2018-05-23', '2018')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`, `year`) VALUES ('9:20:55', '2018-05-23', '2018')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`, `year`) VALUES ('7:20:55', '2018-05-23', '2018')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`, `year`) VALUES ('5:41:55', '2018-05-24', '2018')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`, `year`) VALUES ('5:20:55', '2018-05-24', '2018')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`, `year`) VALUES ('5:11:55', '2018-05-24', '2018')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

}

//prints the entirety of Passerby list
function printtable()
{
	global $debug; global $COMMON;
	$sql = "select * from Passerbys";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	echo "<br>\nStatus of table<br>\n";
	echo("<table border='1px'>");
	while($row = $rs->fetch(PDO::FETCH_ASSOC))
	{
		echo("<tr>");
		foreach ($row as $element)
		{ 
			echo("<td>".$element."</td>");
		}
		echo("</tr>");
	}
	echo("</table>");
}

//gets the rs for the current day query
function currentdaylist(){
	global $debug; global $COMMON;
	$sql = "SELECT * FROM `Passerbys` WHERE date = CURRENT_DATE()";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	return $rs;
}

//returns the rs for a particulr date
function daylist($date){
	global $debug; global $COMMON;
	$sql = "SELECT * FROM `Passerbys` WHERE date = '$date'";
	if ($date = NULL || $date = ''){
		echo "date null";
		$sql = "SELECT * FROM `Passerbys` WHERE date = CURRENT_DATE()";
	}
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	return $rs;
}

//prints a table given an rs with a particular title
function printrs($rs,$title){
	global $debug; global $COMMON;
	echo "<br>\n$title<br>\n";
	echo("<table border='1px'>");
	while($row = $rs->fetch(PDO::FETCH_ASSOC))
	{
		echo("<tr>");
		foreach ($row as $element)
		{ 
			echo("<td>".$element."</td>");
		}
		echo("</tr>");
	}
	echo("</table>");
}

//adddummyweek();

printcount();
printtable();
//printrs(daylist('2018-03-24'),"From the 24th");
printrs(daylist(),"Today");
//printrs(currentdaylist(),"Today");




/*
basic

1. Number of students in certain timeframe (hour, day, week, month, year)

2. Average number of students for given timeframe

3. Graph data points for visual representation

4. Able to analyze highest and lowest points in day, week

5. Other statistical functions to analyze data (median, mode, etc) based on certain time frame

 

extra

1. Display count and timestamp of people entering/existing

2. plot the number of people entering/exiting  (hour, day, week, month, year)

3. Admin page to reset counts and manually remove/add people

4. How many people since the very beginning

5. Have user input range of time and program will return number or people counted at that time


*/

?>