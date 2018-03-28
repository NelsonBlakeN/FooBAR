<html>


<head>
</head>
<body style="background-color:powderblue;">
<!-- ADD COMMON OPTION BUTTONS -->

<h1>Rec Center Passerby Tracker</h1>
    
<h3>Add Person Manually</h3>
<form action="Addperson.php" method="post">
Time: <input type="time" name="time" value="12:00"><br>
Date: <input type="date" name="date" value="2018-03-18"><br>
<input type="submit">
</form>

<h3>Clear the table</h3>
<form>
<input type="button" value="Clear All Persons" onclick="window.location.href='http://projects.cse.tamu.edu/amiller15/Clearpersons.php'" />
</form>

<h3>Get Total persons Counted</h3>
<form>
<input type="button" value="Go to Total" onclick="window.location.href='http://projects.cse.tamu.edu/amiller15/TotalPersons.php'" />
</form>

<form>
<input type="button" value="Return" onclick="window.location.href='http://projects.cse.tamu.edu/amiller15/Mainsite.php'" />
</form>

</body>
</html>