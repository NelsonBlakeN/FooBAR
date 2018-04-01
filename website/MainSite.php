/* ****************************************************
    File:       MainSite.php
    Project:    CSCE 315 Project 1, Spring 2018
    Date:       3/19/2018
    Section:    504

    This file serves as the main front page for the
    traffic counter website. It contains options to
    view data in a specific day or hour range, as well
    as links to add simulated data or navigate to the
    administrative page.
******************************************************* */

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
            Start Time: <input type="time" name="StartHour" value="06:00"><br>
            End Time: <input type="time" name="EndHour" value="23:59"><br>
            Day: <input type="date" name="Date" value ="2018-03-18"><br>
            <input type="submit">
        </form>

        <br>

        <!-- Add Dummy Data -->
        <form>
            <input type="button" value="Add Dummy Data" onclick="window.location.href='http://projects.cse.tamu.edu/amiller15/DummyInput.php'" />
        </form>

        <!-- Link to Admin Page -->
        <form>
            <input type="button" value="Admin Page" onclick="window.location.href='http://projects.cse.tamu.edu/amiller15/AdminPage.php'" />
        </form>

    </body>
</html>
