<html>
<body>

<head>
	
</head>

<!-- ADD COMMON OPTION BUTTONS -->

<h1>Rec Center Passerby Tracker</h1>
    
<h3>Specific Day Range</h3>
<form action="WeekChart.php" method="post">
StartTime: <input type="date" name="Startdate"><br>
EndTime: <input type="date" name="Enddate"><br>
<input type="submit">
</form>

<h3>Specific Hour range</h3>
<form action="DayChart.php" method="post">
Start Time: <input type="time" name="Starthour"><br>
End Time: <input type="time" name="Endhour"><br>
Day: <input type="date" name="Date"><br>
<input type="submit">
</form>

</body>
</html>
