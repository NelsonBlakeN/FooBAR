/* ****************************************************
    File:       DayChart.php
    Project:    CSCE 315 Project 1, Spring 2018
    Date:       3/19/2018
    Section:    504

    This file creates a chart of pedestrian data for a given
	day, with labels provided by the request. This chart is
	created using JavaScript.
******************************************************* */

<?php

	include('PhpApi.php');

	// Create API object and instatiate input variables.
	$debug = false;
	$COMMON = new Common($debug);
	date_default_timezone_set("America/Chicago");
	$dataPoints;
	$chartTitle;

	// Set input variables
	$startHour = ($_POST["StartHour"]);
	$endHour = ($_POST["EndHour"]);
	$date = ($_POST["Date"]);

	// Set error checking values
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	// Setting the chart properties
	$COMMON -> SetChartHours($dataPoints, $chartTitle, $startHour, $endHour, $date);

?>

<!DOCTYPE HTML>
<html>
	<head>
		<script>
		window.onload = function () {

			var chart = new CanvasJS.Chart("chartContainer", {
				animationEnabled: true,
				exportEnabled: true,
				theme: "light1",
				title:{
					text: <?php echo json_encode($charttitle); ?>
				},
				data: [{
					// Type can be set to bar, line, area, pie, etc
					type: "area",
					indexLabelFontColor: "#5A5757",
					indexLabelPlacement: "outside",
					dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
				}]
			});
			chart.render();

		}
	</script>
	</head>
	<body style="background-color:powderblue;">
		<div id="chartContainer" style="height: 370px; width: 100%;"></div>
		<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
	</body>
</html>
