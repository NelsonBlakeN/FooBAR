<?php 

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

	//simulates the adding of a person at the current time
	function adddummyperson(){

		//add a new element
		$sql2 = "INSERT INTO Passerbys (`time`, `date`, `year`) VALUES (CURRENT_TIME(), CURRENT_DATE(), CURRENT_DATE())";
		$rs = $this-> executeQuery($sql2, $_SERVER["SCRIPT_NAME"]);
	}

	//adds the dummy week to the database
	function adddummyweek(){

		//add a new element

		$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('16:20:55', '2018-03-18')";
		$rs = $this-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

		$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('06:20:55', '2018-03-18')";
		$rs = $this-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

		$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('06:50:55', '2018-03-18')";
		$rs = $this-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

		$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('06:50:55', '2018-03-18')";
		$rs = $this-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

		$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('06:50:55', '2018-03-18')";
		$rs = $this-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

		$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('06:41:55', '2018-03-18')";
		$rs = $this-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

		$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('16:58:55', '2018-03-19')";
		$rs = $this-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

		$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('01:58:55', '2018-03-19')";
		$rs = $this-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

		$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('10:58:55', '2018-03-19')";
		$rs = $this-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

		$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('14:58:55', '2018-03-20')";
		$rs = $this-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

		$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('14:58:55', '2018-03-20')";
		$rs = $this-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

		$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('05:41:55', '2018-03-21')";
		$rs = $this-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

		$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('20:20:55', '2018-03-22')";
		$rs = $this-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

		$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('17:20:55', '2018-03-23')";
		$rs = $this-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

		$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('09:20:55', '2018-03-23')";
		$rs = $this-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

		$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('07:20:55', '2018-03-23')";
		$rs = $this-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

		$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('05:41:55', '2018-03-24')";
		$rs = $this-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

		$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('05:20:55', '2018-03-24')";
		$rs = $this-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

		$sql= "INSERT INTO Passerbys (`time`, `date`) VALUES ('05:11:55', '2018-03-24')";
		$rs = $this-> executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
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

}

?>
