/* ****************************************************
    File:       WeekChart.php
    Project:    CSCE 315 Project 1, Spring 2018
    Date:       3/19/2018
    Section:    504

    This file creates a chart of pedestrian data for a given
	week, with labels provided by the request. This chart is
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

	// Set input variables.
	$startDate = ($_POST["StartDate"]);
	$endDate = ($_POST["EndDate"]);

	// Sanitize the input
	$interval = date_diff(new datetime($startDate), new datetime($endDate));
	if ($interval-> d > 6 || $interval-> m !=0){
		global $endDate;
		$newED = new datetime($startDate);
		$newED = $newED -> modify('+6 day');
		$endDate = $newED ->format('Y-m-d');
	}

	// Set error checking values.
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	// Set the chart properties
	$COMMON->SetChartDays($dataPoints, $chartTitle, $startDate, $endDate);

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
					text: <?php echo json_encode($chartTitle); ?>
				},
				data: [{
					// Type can be set to bar, line, area, pie, etc.
					type: "column",
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
