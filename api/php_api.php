<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Common
{	
	var $conn;
	var $debug;
	
	var $db="database.cse.tamu.edu";
	var $dbname="blake.nelson";
	var $user="blake.nelson";
	var $pass="Tamu@2019";
			
	function Common($debug)
	{
		$this->debug = $debug;
		$rs = $this->connect($this->user); // db name really here
		return $rs;
	}

// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% */
	
	function connect($db)// connect to MySQL DB Server
	{
		try
		{
			$this->conn = new PDO('mysql:host='.$this->db.';dbname='.$this->dbname, $this->user, $this->pass);
	    	} catch (PDOException $e) {
        	    print "Error!: " . $e->getMessage() . "<br/>";
	            die();
        	}
	}

// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% */

	function executeQuery($sql, $filename) // execute query
	{
		if($this->debug == true) { echo("$sql <br>\n"); }
		$rs = $this->conn->query($sql) or die("Could not execute query '$sql' in $filename"); 
		return $rs;
	}	

// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% */ Our Functions

	//prints out the length of a given rs list
	function countrs($rs){
		$count = 0;
		while ($row = $rs->fetch(PDO::FETCH_ASSOC)){
			++$count;
		}
		return $count;
	}

	//returns the rs for every person in memory
	function all(){
		$sql = "SELECT * FROM `Passerbys`";
		$rs = $this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		return $rs;
	}

	//adds a person time and date
	function addperson($time, $date){
		$sql2 = "INSERT INTO Passerbys (`time`, `date`) VALUES ('$time','$date')";
		$rs = $this-> executeQuery($sql2, $_SERVER["SCRIPT_NAME"]);
	}

	//clears all persons from database
	function cleardatabase(){
		$sql2 = "DELETE FROM `Passerbys` WHERE 1";
		$rs = $this-> executeQuery($sql2, $_SERVER["SCRIPT_NAME"]);
	}

	//adds the dummy week to the database
	function adddummyweek(){
		$this -> adddummyday('2018-3-18');
		$this -> adddummyday('2018-3-19');
		$this -> adddummyday('2018-3-20');
		$this -> adddummyday('2018-3-21');
		$this -> adddummyday('2018-3-22');
		$this -> adddummyday('2018-3-23');
		$this -> adddummyday('2018-3-24');
	}

	//adds a dummy day of a random number of people based on a string input of a date
	function adddummyday($date){
		$ppl = rand(20,100);
		for ($i = 0; $i < $ppl; ++$i){
			$h = rand(0,23);
			$m = rand(0,59);
			$s = rand(0,59);
			$time = $h . ":" . $m . ":" . $s;
			$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('$time', '$date')";
			$rs = $this-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		}
	}

	//gets the rs for the current day query
	function currentdaylist(){
		$sql = "SELECT * FROM `Passerbys` WHERE date = CURRENT_DATE()";
		$rs = $this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		return $rs;
	}

	//returns the rs for a particulr date
	function daylist($date){
		$sql = "SELECT * FROM `Passerbys` WHERE date = '$date'";
		$rs = $this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		return $rs;
	}

	//returns the rs for a particular hour, takes a datetime as the input
	function hourlist(dateTime $datetime){
		$hour = $datetime->format('H');
		$date = $datetime->format('Y-m-d');
		$dt1 = $datetime -> format('Y-m-d H:i:s');
		$dt2 = $datetime ->modify('+1 hour');
		$dt2 = $dt2 -> format('Y-m-d H:i:s');
		$sql = "SELECT * FROM `Passerbys` WHERE timestamp(date,time) BETWEEN '$dt1' AND '$dt2'";
		$rs = $this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		return $rs;
	}

	//prints a table given an rs with a particular date
	function printrs($rs,$title){
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
		$sql = "SELECT * FROM `Passerbys` WHERE timestamp(date,time) BETWEEN '$ts1' AND '$ts2'";
		$rs = $this->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		return $rs;
	}

	//gives an inclusive array of dates between two dates (taken as inputs)
	function daterange($startdate,$enddate){
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

	//gives an inclusive array of datetime hours between two hours, takes datetimes as inputs
	function timerange(dateTime $starttime, dateTime $endtime){
		$times = array();
		$period = new DatePeriod($starttime, new DateInterval('PT1H'), $endtime);
		foreach ($period as $key => $value) {
     		array_push($times, $value);
		}
		return $times;
	}
	
	//outputs a array of counts for people in given days
	function dayhistogram($startdate,$enddate){
		$datearray = $this-> daterange($startdate,$enddate);
		$countarray = array();
		foreach ($datearray as $date){
			$rs = $this-> daylist("$date");
			$daycount = $this->countrs($rs);
			array_push($countarray, $daycount);
		}
		return $countarray;
	}

	//outputs a array of counts for people in given hours
	function hourhistogram(dateTime $dt1, dateTime $dt2){
		$datearray = $this->timerange($dt1,$dt2);
		$countarray = array();
		foreach ($datearray as $date){
			$rs = $this-> hourlist($date);
			$daycount = $this->countrs($rs);
			array_push($countarray, $daycount);
		}
		return $countarray;
	}

	//outputs an array of date names (Monday, tuesday ect.) between two dates
	function getdatenames($startdate, $enddate){
		$date1 = new DateTime($startdate);
		$date2 = new DateTime($enddate);
		$date2->modify('+1 day');
		$datenames = array();
		$period = new DatePeriod(
		     $date1,
		     new DateInterval('P1D'),
		     $date2
		);
		foreach ($period as $key => $value) {
     		array_push($datenames, $value->format('l'));
		}
		return $datenames;
	}

	//this assigns lables to the max and min values of data set
	function printextremes(&$chartdata){
		//the y is the data value on the y axis
		$min= $chartdata[0]["y"];
		$max= $chartdata[0]["y"];
		$maxind = 0;
		$minind = 0;
		for($i = 0; $i<sizeof($chartdata); ++$i){
			if($chartdata[$i]["y"] > $max){
				$max = $chartdata[$i]["y"];
				$maxind = $i;
			}
			if($chartdata[$i]["y"] < $min){
				$min = $chartdata[$i]["y"];
				$minind = $i;
			}
		}
		$chartdata[$maxind]["indexLabel"] = "Maximum";
		$chartdata[$minind]["indexLabel"] = "Minimum";
	}

	//this function will print basic data associated with a timeframe
	function printdata(&$chartdata){
		$values = array();
		for($i = 0; $i<sizeof($chartdata); ++$i){
			array_push($values, $chartdata[$i]["y"]);	
		}
		$average = array_sum($values)/count($values);
		$mode = $this->array_mode($values);
		$range = max($values) - min($values);
		echo("Average: $average<br>Mode: $mode<br>Range: $range<br>");
	}

	//returns the mode of an array (cited from: http://blog.room34.com/archives/5773)
	function array_mode($arr) {
  		$count = array();
  		foreach ((array)$arr as $val) {
    		if (!isset($count[$val])) { $count[$val] = 0; }
   			$count[$val]++;
  		}
  		arsort($count);
  		return key($count);
	}

	//this will modify necessary variables to set the chart to display a centain range of days
	function setchartdays(&$chartdata, &$title, $startdate, $enddate){

		//setting the chart data
		$newcdata = array();
		$dates = $this-> daterange($startdate,$enddate);
		$counts = $this-> dayhistogram($startdate,$enddate);
		$datenames = $this-> getdatenames($startdate, $enddate);
		for ($i = 0; $i < sizeof($dates); ++$i){
			array_push($newcdata, array("label"=> $datenames[$i], "y"=> $counts[$i]));
		}
		$chartdata = $newcdata;

		//setting the title
		$date1 = new DateTime($startdate);
		$date2 = new DateTime($enddate);
		$date1 = $date1->format('m-d-Y');
		$date2 = $date2->format('m-d-Y');
		$title = "Passerbys from $date1 to $date2";

		//add extremems labels
		$this->printextremes($chartdata);

		//printing other data
		$this->printdata($chartdata);
	}

	//this willset the chart to display data between certain hours of the day
	function setcharthours(&$chartdata, &$title, $starthour, $endhour, $date){
		//divide the hour input
		$time1 = explode(":",$starthour);
		$time2 = explode(":",$endhour);
		$datearray = explode("-", $date);
		$year = $datearray[0];
		$month = $datearray[1];
		$day = $datearray[2];

		//creating and setting up the datetime objects
		$dt1 = new datetime(date('m/d/Y', time()));
		$dt1 -> setTime($time1[0],"00");
		$dt1 -> setDate($datearray[0],$datearray[1],$datearray[2]);
		
		$dt2 = new datetime(date('m/d/Y', time()));
		$dt2 -> setTime($time2[0],"00");
		$dt2 -> setDate($datearray[0],$datearray[1],$datearray[2]);

		//cleanse the data
		if ($dt2 < $dt1){
			echo("Bad input given. Data adjusted to positive hour range.");
			$dt2 = new datetime(date('m/d/Y', time()));
			$dt2 -> setTime($time1[0],"00");
			$dt2 -> setDate($datearray[0],$datearray[1],$datearray[2]);
			$dt2 -> add(new DateInterval("PT3H"));
		}

		//set the chart data
		$times = $this->timerange($dt1,$dt2);
		$counts = $this -> hourhistogram($dt1,$dt2);
		$newcdata = array();
		for ($i = 0; $i < sizeof($times); ++$i){
			array_push($newcdata, array(
				"label"=> $times[$i]->format("H:i"), 
				"y"=> $counts[$i]
			));
		}
		$chartdata = $newcdata;

		//setting the title
		$t1 = $dt1->format('H:i');
		$t2 = $dt2->format('H:i');
		$day = $dt1->format('m/d/Y');
		$title = "Passerbys from $t1 to $t2 on $day";

		//labeling
		$this->printextremes($chartdata);

		//printing other data
		$this->printdata($chartdata);
	}
}

?>
