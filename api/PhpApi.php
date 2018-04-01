/* ****************************************************
    File:       PhpApi.php
    Project:    CSCE 315 Project 1, Spring 2018
    Date:       3/19/2018
    Section:    504

    This file contains the API used to read information
	from the database, and display it on a web interface.
	It contains function relevant to reading to rows, as well
	as organizing the data into different ranges, such as
	days and hours. Functions can also create different types
	of graphs to display for visual data. Lastly, there are
	functions for administrative use, dealing with adding and
	removing people.
******************************************************* */

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Common
{
	var $conn;
	var $debug;

	var $db="database.cse.tamu.edu";
	var $dbname="XXXXX";
	var $user="XXXXX";
	var $pass="XXXXX";

	// --------------------------------
	// Name: Common
	// PreConditions:  A debug value must be present.
	// PostConditions: An API object will be created, which will be
	//				   connected to the database. It's debug level will
	//				   also be assigned based on the passed value
	//----------------------------------
	function Common($debug)
	{
		$this->debug = $debug;
		$rs = $this->connect($this->user);
		return $rs;
	}

	// --------------------------------
	// Name: Connect
	// PreConditions:  None
	// PostConditions: A valud connection will be made to the database,
	//				   or a descriptive error on a failed connection will be presented.
	//----------------------------------
	function Connect()
	{
		try
		{
			$this->conn = new PDO('mysql:host='.$this->db.';dbname='.$this->dbname, $this->user, $this->pass);
	    }
		catch (PDOException $e)
		{
        	print "Error!: " . $e->getMessage() . "<br/>";
			die();
        }
	}

	// --------------------------------
	// Name: ExecuteQuery
	// PreConditions:  A SQL query and file name must exist
	// PostConditions: A query will be executed to the database, or
	//				   a descrptive error including the filename will be presented.
	//----------------------------------
	function ExecuteQuery($sql, $filename)
	{
		if($this->debug == true) { echo("$sql <br>\n"); }
		$rs = $this->conn->query($sql) or die("Could not execute query '$sql' in $filename");
		return $rs;
	}

	// --------------------------------
	// Name: CountRs
	// PreConditions:  A list of results is presented
	// PostConditions: A value will be returned that is equal to the
	//				   length of the given result list.
	//----------------------------------
	function CountRs($rs){
		$count = 0;
		while ($row = $rs->fetch(PDO::FETCH_ASSOC)){
			++$count;
		}
		return $count;
	}

	// --------------------------------
	// Name: All
	// PreConditions:  None
	// PostConditions: A value will be returned that is equal to the
	//				   number of entries in the database.
	//----------------------------------
	function All(){
		$sql = "SELECT * FROM `Passerbys`";
		$rs = $this->ExecuteQuery($sql, $_SERVER["SCRIPT_NAME"]);
		return $rs;
	}

	// --------------------------------
	// Name: AddPerson
	// PreConditions:  Exisintg time and date values
	// PostConditions: An entry will be added to the database,
	//				   assigned to the provided date and time
	//----------------------------------
	function AddPerson($time, $date){
		$sql2 = "INSERT INTO Passerbys (`time`, `date`) VALUES ('$time','$date')";
		$rs = $this-> ExecuteQuery($sql2, $_SERVER["SCRIPT_NAME"]);
	}

	// --------------------------------
	// Name: ClearDatabase
	// PreConditions:  None
	// PostConditions: The entire database will be cleared
	//----------------------------------
	function ClearDatabase(){
		$sql2 = "DELETE FROM `Passerbys` WHERE 1";
		$rs = $this-> ExecuteQuery($sql2, $_SERVER["SCRIPT_NAME"]);
	}

	// --------------------------------
	// Name: AddDummyWeek
	// PreConditions:  None
	// PostConditions: Manually adds data on each day of a determined week.
	//----------------------------------
	function AddDummyWeek(){
		$this -> AddDummyDay('2018-3-18');
		$this -> AddDummyDay('2018-3-19');
		$this -> AddDummyDay('2018-3-20');
		$this -> AddDummyDay('2018-3-21');
		$this -> AddDummyDay('2018-3-22');
		$this -> AddDummyDay('2018-3-23');
		$this -> AddDummyDay('2018-3-24');
	}

	// --------------------------------
	// Name: AddDummyDay
	// PreConditions:  A date is given
	// PostConditions: Adds a fake day, with a random number of
	//				   people added to the database for that day
	//----------------------------------
	function AddDummyDay($date){
		$ppl = rand(20,100);
		for ($i = 0; $i < $ppl; ++$i){
			$h = rand(0,23);
			$m = rand(0,59);
			$s = rand(0,59);
			$time = $h . ":" . $m . ":" . $s;
			$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('$time', '$date')";
			$rs = $this-> ExecuteQuery($sql, $_SERVER["SCRIPT_NAME"]);
		}
	}

	// --------------------------------
	// Name: CurrentDayList
	// PreConditions:  None
	// PostConditions: A list of all entries from the current date is returned
	//----------------------------------
	function CurrentDayList() {
		$sql = "SELECT * FROM `Passerbys` WHERE date = CURRENT_DATE()";
		$rs = $this->ExecuteQuery($sql, $_SERVER["SCRIPT_NAME"]);
		return $rs;
	}

	// --------------------------------
	// Name: DayList
	// PreConditions:  A date is given
	// PostConditions: A list of all entries from the given date is returned
	//----------------------------------
	function DayList($date) {
		$sql = "SELECT * FROM `Passerbys` WHERE date = '$date'";
		$rs = $this->ExecuteQuery($sql, $_SERVER["SCRIPT_NAME"]);
		return $rs;
	}

	// --------------------------------
	// Name: HourList
	// PreConditions:  An hour timestamp is given
	// PostConditions: A list of all entries from the given hour is returned
	//----------------------------------
	function HourList(dateTime $dateTime) {
		$hour = $dateTime->format('H');
		$date = $dateTime->format('Y-m-d');
		$date1 = $dateTime -> format('Y-m-d H:i:s');
		$date2 = $dateTime ->modify('+1 hour');
		$date2 = $date2 -> format('Y-m-d H:i:s');
		$sql = "SELECT * FROM `Passerbys` WHERE timestamp(date,time) BETWEEN '$date1' AND '$date2'";
		$rs = $this->ExecuteQuery($sql, $_SERVER["SCRIPT_NAME"]);
		return $rs;
	}

	// --------------------------------
	// Name: PrintRs
	// PreConditions:  A result list and title is given
	// PostConditions: A table of all the results from the list is presented,
	//				   and titled with the given title.
	//----------------------------------
	function PrintRs($rs,$title) {
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

	// --------------------------------
	// Name: Between
	// PreConditions:  Two timestamps are given
	// PostConditions: A list of entries that are assigned a time
	//				   between the two given timestamps is returned.
	//----------------------------------
	function Between($time1, $time2) {
		$sql = "SELECT * FROM `Passerbys` WHERE timestamp(date,time) BETWEEN '$time1' AND '$time2'";
		$rs = $this->ExecuteQuery($sql, $_SERVER["SCRIPT_NAME"]);
		return $rs;
	}

	// --------------------------------
	// Name: DateRange
	// PreConditions:  Two timestamps are given
	// PostConditions: A list of entries that are assigned a time
	//				   between the two given timestamps is returned.
	//----------------------------------
	function DateRange($startDate,$endDate) {
		$date1 = new DateTime($startdate);
		$date2 = new DateTime($enddate);
		$date2->modify('+1 day');

		$dates = array();
		$period = new DatePeriod(
		     $date1,
		     new DateInterval('P1D'),
		     $date2
		);
		foreach ($period as $key => $value) {
     		array_push($dates, $value->format('Y-m-d'));
		}
		return $dates;
	}

	// --------------------------------
	// Name: TimeRange
	// PreConditions:  Two timestamps are given
	// PostConditions: A list of times
	//				   between the two given timestamps is returned.
	//----------------------------------
	function TimeRange(dateTime $startTime, dateTime $endTime) {
		$times = array();
		$period = new DatePeriod($starttime, new DateInterval('PT1H'), $endtime);
		foreach ($period as $key => $value) {
     		array_push($times, $value);
		}
		return $times;
	}

	// --------------------------------
	// Name: DayHistogram
	// PreConditions:  Two dates are given
	// PostConditions: A histogram is created, using data from between the two dates
	//----------------------------------
	function DayHistogram($startDate, $endDate) {
		$dateArray = $this-> DateRange($startDate,$endDate);
		$countArray = array();
		foreach ($dateArray as $date){
			$rs = $this-> DayList("$date");
			$dayCount = $this->countrs($rs);
			array_push($countArray, $dayCount);
		}
		return $countArray;
	}

	// --------------------------------
	// Name: HourHistogram
	// PreConditions:  Two timestamps are given
	// PostConditions: A histogram is created, using data from between the two times
	//----------------------------------
	function HourHistogram(dateTime $date1, dateTime $date2) {
		$dateArray = $this->TimeRange($date1,$date2);
		$countArray = array();
		foreach ($dateArray as $date){
			$rs = $this-> HourList($date);
			$dayCount = $this->countrs($rs);
			array_push($countArray, $dayCount);
		}
		return $countArray;
	}

	// --------------------------------
	// Name: GetDateNames
	// PreConditions:  Two dates are given
	// PostConditions: A list of dates with names are returned
	//----------------------------------
	function GetDateNames($startDate, $endDate) {
		$date1 = new DateTime($startDate);
		$date2 = new DateTime($endDate);
		$date2->modify('+1 day');
		$dateNames = array();
		$period = new DatePeriod(
		     $date1,
		     new DateInterval('P1D'),
		     $date2
		);
		foreach ($period as $key => $value) {
     		array_push($dateNames, $value->format('l'));
		}
		return $dateNames;
	}

	// --------------------------------
	// Name: PrintExtremes
	// PreConditions:  Chart data is given
	// PostConditions: The highest and lowest point of the chart is labeled appropriately
	//----------------------------------
	function PrintExtremes(&$chartData) {
		// Y: the data value on the y axis
		$min = $chartData[0]["y"];
		$max = $chartData[0]["y"];
		$maxIndex = 0;
		$minIndex = 0;
		for($i = 0; $i < sizeof($chartData); ++$i){
			if($chartData[$i]["y"] > $max){
				$max = $chartData[$i]["y"];
				$maxIndex = $i;
			}
			if($chartData[$i]["y"] < $min){
				$min = $chartData[$i]["y"];
				$minIndex = $i;
			}
		}
		$chartdata[$maxIndex]["indexLabel"] = "Maximum";
		$chartdata[$minIndex]["indexLabel"] = "Minimum";
	}

	// --------------------------------
	// Name: PrintData
	// PreConditions:  Chart data is given
	// PostConditions: Dtatistical data based on the chart is displayed.
	//----------------------------------
	function PrintData(&$chartdata) {
		$values = array();
		for($i = 0; $i<sizeof($chartdata); ++$i){
			array_push($values, $chartdata[$i]["y"]);
		}
		$average = array_sum($values)/count($values);
		$mode = $this->ArrayMode($values);
		$range = max($values) - min($values);
		echo("Average: $average<br>Mode: $mode<br>Range: $range<br>");
	}

	// --------------------------------
	// Name: Array
	// PreConditions:  An array given
	// PostConditions: The counted key is returned
	//----------------------------------
	function ArrayMode($array) {
  		$count = array();
  		foreach ((array)$array as $val) {
    		if (!isset($count[$val])) { $count[$val] = 0; }
   			$count[$val]++;
  		}
  		arsort($count);
  		return key($count);
	}

	// --------------------------------
	// Name: SetCharDays
	// PreConditions:  Chart data, a title, start, and end dates are given
	// PostConditions: A chart is created with the appropriate data.
	//----------------------------------
	function SetChartDays(&$chartData, &$title, $startDate, $endDate) {
		// Setting the chart data
		$newChartData = array();
		$dates = $this -> DateRange($startDate, $endDate);
		$counts = $this -> DayHistogram($startDate, $endDate);
		$dateNames = $this -> GetDateNames($startDate, $endDate);
		for ($i = 0; $i < sizeof($dates); ++$i){
			array_push($newChartData, array("label" => $dateNames[$i], "y" => $counts[$i]));
		}
		$chartData = $newChartData;

		// Setting the title
		$date1 = new DateTime($startDate);
		$date2 = new DateTime($endDate);
		$date1 = $date1->format('m-d-Y');
		$date2 = $date2->format('m-d-Y');
		$title = "Passerbys from $date1 to $date2";

		// Label extremes
		$this->PrintExtremes($chartdata);

		// Print stats
		$this->PrintData($chartdata);
	}

	// --------------------------------
	// Name: SetChartHours
	// PreConditions:  Chart data, a title, two time stamps, and a date are given
	// PostConditions: A chart is created with pedestrian data between two
	//				   timestamps on a given date is created.
	//----------------------------------
	function SetChartHours(&$chartData, &$title, $startHour, $endHour, $date) {
		// Divide the hour input
		$time1 = explode(":",$startHour);
		$time2 = explode(":",$endHour);
		$dateArray = explode("-", $date);
		$year = $dateArray[0];
		$month = $dateArray[1];
		$day = $dateArray[2];

		// Creating and setting up the datetime objects
		$date1 = new datetime(date('m/d/Y', time()));
		$date1 -> setTime($time1[0], "00");
		$date1 -> setDate($dateArray[0], $dateArray[1], $dateArray[2]);

		$date2 = new datetime(date('m/d/Y', time()));
		$date2 -> setTime($time2[0], "00");
		$date2 -> setDate($dateArray[0], $dateArray[1], $dateArray[2]);

		// Set the chart data
		$times = $this->TimeRange($date1,$date2);
		$counts = $this -> HourHistogram($date1,$date2);
		$newChartData = array();
		for ($i = 0; $i < sizeof($times); ++$i){
			array_push($newChartData, array(
				"label"=> $times[$i]->format("H:i"),
				"y"=> $counts[$i]
			));
		}
		$chartData = $newChartData;

		// Setting the title
		$t1 = $date1->format('H:i');
		$t2 = $date2->format('H:i');
		$day = $date1->format('m/d/Y');
		$title = "Passerbys from $t1 to $t2 on $day";

		// Label Extremes
		$this->PrintExtremes($chartdata);

		// Print stats
		$this->PrintData($chartdata);
	}
}

?>
