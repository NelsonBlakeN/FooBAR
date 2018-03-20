<?php


include('CommonMethods.php');
$debug = false;
$COMMON = new Common($debug);

//prints out the length of a given rs list
function countrs($rs)
{
	global $debug; global $COMMON;
	$count = 0;
	while ($row = $rs->fetch(PDO::FETCH_ASSOC)){
		++$count;
	}
	return $count;
}

//returns the rs for every person in memory
function all(){
	global $debug; global $COMMON;
	$sql = "SELECT * FROM `Passerbys`";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	return $rs;
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

	$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('16:20:55', '2018-03-18')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('06:20:55', '2018-03-18')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('06:50:55', '2018-03-18')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('06:50:55', '2018-03-18')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('06:50:55', '2018-03-18')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('06:41:55', '2018-03-18')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('16:58:55', '2018-03-19')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('01:58:55', '2018-03-19')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('10:58:55', '2018-03-19')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('14:58:55', '2018-03-20')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('14:58:55', '2018-03-20')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('05:41:55', '2018-03-21')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('20:20:55', '2018-03-22')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('17:20:55', '2018-03-23')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('09:20:55', '2018-03-23')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('07:20:55', '2018-03-23')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('05:41:55', '2018-03-24')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('05:20:55', '2018-03-24')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

	$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('05:11:55', '2018-03-24')";
	$rs = $COMMON-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

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
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	return $rs;
}

//prints a table given an rs with a particular date
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


//returns the rs of all times between two timestamps
function between($ts1, $ts2){
	global $debug; 
	global $COMMON;
	$sql = "SELECT * FROM `Passerbys` WHERE timestamp(date,time) BETWEEN '$ts1' AND '$ts2'";
	$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
	return $rs;
}

//adddummyweek();
printrs(all());
echo countrs(all());
//printrs(daylist('2018-03-23'),"From date");
//printrs(currentdaylist(),"Today");
printrs(between("2018-03-18 16:20:55", "2018-03-19 14:58:55"));
echo countrs(between("2018-03-18 16:20:55", "2018-03-19 14:58:55"));




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