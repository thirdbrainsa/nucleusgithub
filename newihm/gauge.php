<?php
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  	<head>
    	<meta http-equiv="content-type" content="text/html;charset=utf-8">
    	<title>d3.js gauges</title>
		
		<style>
		
			body
			{
			  	font: 10px arial;
			}
			
		</style>
		
		<script type="text/javascript" src="js/d3.js"></script>
		<script type="text/javascript" src="js/gauge.js"></script>
 
		<script>
						
				
			var gauges = [];
			
			function createGauge(name, label, min, max)
			{
				var config = 
				{
					size: 120,
					label: label,
					min: undefined != min ? min : 0,
					max: undefined != max ? max : 2000,
					minorTicks: 5
				}
				
				var range = config.max - config.min;
				config.yellowZones = [{ from: config.min + range*0.10, to: config.min + range*0.30 }];
				config.redZones = [{ from: config.min + range*0.3, to: config.max }];
				
				gauges[name] = new Gauge(name + "GaugeContainer", config);
				gauges[name].render();
			}
			function createGauge_gain(name, label, min, max)
			{
				var config = 
				{
					size: 120,
					label: label,
					min: undefined != min ? min : 0,
					max: undefined != max ? max : 2000,
					minorTicks: 5
				}
				
				var range = config.max - config.min;
				//config.yellowZones = [{ from: config.min + range*0.25, to: config.min + range*0.5 }];
				//config.redZones = [{ from: config.min + range*0.5, to: config.max }];
				
				gauges[name] = new Gauge(name + "GaugeContainer", config);
				gauges[name].render();
			}
			
			function createGauges()
			{
				createGauge("memory", "RISK");
				createGauge_gain("cpu", "GAIN");
				
			}
			
			function updateGauges()
			{
				var i=0;
				var value=0;
				for (var key in gauges)
				{
				i=i+1;
				if (i==1)
				{
				//window.alert("i>"+i);
				//window.alert(localStorage.getItem("history_profile"));
				 value=<?php echo abs($drawdown) ?> 
				}
				if (i==2)
				{
				//window.alert("i>"+i);
				//window.alert(localStorage.getItem("history_profile"));
				value=<?php echo $profit ?>
				}
			
			
					if (value==0) { value = getRandomValue(gauges[key]);}
					gauges[key].redraw(value);
				}
			}
			
			function getRandomValue(gauge)
			{
				var overflow = 0; //10;
				return gauge.config.min - overflow + (gauge.config.max - gauge.config.min + overflow*2) *  Math.random();
			}
			
			function initialize()
			{
				createGauges();
				setInterval(updateGauges, 1000);
			}
			
		</script>
		
		
	</head>
	
	<body onload="initialize()">
		<span id="memoryGaugeContainer"></span>
		<span id="cpuGaugeContainer"></span>
		</body>
	
</html>