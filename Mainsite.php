<html>


<head>
</head>
<body style="background-color:powderblue;">

<h1>Rec Center Passerby Tracker</h1>
    
<h3>Specific Day Range</h3>
<form action="WeekChart.php" method="post">
StartTime: <input type="date" name="Startdate" value="2018-03-18"><br>
EndTime: <input type="date" name="Enddate" value="2018-03-25"><br>
<input type="submit">
</form>

<h3>Specific Hour range</h3>
<form action="DayChart.php" method="post">
Start Time: <input type="time" name="Starthour" value="06:00"><br>
End Time: <input type="time" name="Endhour" value="23:59"><br>
Day: <input type="date" name="Date" value ="2018-03-18"><br>
<input type="submit">
</form>

<br>
<form>
<input type="button" value="Add Dummy Data" onclick="window.location.href='http://projects.cse.tamu.edu/amiller15/DummyInput.php'" />
</form>

<form>
<input type="button" value="Admin Page" onclick="window.location.href='http://projects.cse.tamu.edu/amiller15/AdminPage.php'" />
</form>

</body>
</html>
