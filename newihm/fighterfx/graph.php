<!DOCTYPE HTML>
<html>

<head>
	<script type="text/javascript">
	window.onload = function () {

		var dps = []; // dataPoints
		
		var chart = new CanvasJS.Chart("chartContainer",{
			title :{
				text: "Live Graph"
			},	
axisY:{
   maximum: 2,
 },			
			data: [{
				type: "line",
				dataPoints: dps 
			}]
		});

		var xVal = 0;
		var yVal = 1;	
		var updateInterval = 1000;
		var dataLength = 500; // number of dataPoints visible at any point

		var updateChart = function (count) {
			count = count || 1;
			// count is number of times loop runs to generate random dataPoints.
			//
			
			//
			for (var j = 0; j < count; j++) {	
				yVal = localStorage.getItem("ask");
				alert(yVal);
				dps.push({
					x: xVal,
					y: yVal
				});
				xVal++;
			};
			if (dps.length > dataLength)
			{
				dps.shift();				
			}
			
			chart.render();		

		};

		// generates first set of dataPoints
		updateChart(dataLength); 

		// update chart after specified time. 
		setInterval(function(){updateChart()}, updateInterval); 

	}
	</script>
	<script type="text/javascript" src="js/canvasjs/canvasjs.min.js"></script>
</head>
<body>
	<div id="chartContainer" style="height: 300px; width:100%;">
	</div>
</body>
</html>
