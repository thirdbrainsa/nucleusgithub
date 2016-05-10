<!DOCTYPE html>
<meta charset="utf-8">
<style>

text {
  font: 10px sans-serif;
}

</style>
<body>
<script src="../js/d3.v3.min.js"></script>
<script>
var i=0;
function graphDone(i)
{
var diameter = 960,
    format = d3.format(",d"),
    color = d3.scale.category20c();

var bubble = d3.layout.pack()
    .sort(null)
    .size([diameter, diameter])
    .padding(1.5);

var svg = d3.select("#graphic").append("svg:svg")  
    .attr("id","bubbledisplay"+i)
    .attr("width", diameter)
    .attr("height", diameter)
    .attr("class", "bubble");
  
var userID=localStorage.getItem("userID");

d3.json("../userfiles/"+userID+"/nucleus.json?w="+i, function(error, root) {
  var node = svg.selectAll(".node")
      .data(bubble.nodes(classes(root))
      .filter(function(d) { return !d.children; }))
    .enter().append("g")
      .attr("class", "node")
      .attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });

  node.append("title")
      .text(function(d) { return d.className + ": " + format(d.value); });

  node.append("circle")
      .attr("r", function(d) { return d.r; })
      .style("fill", function(d) 
      {
      var currency=d.className.substring(0, d.r / 3);
      //alert(currency);
      var keys="potentiel_"+currency;
      var valueK=localStorage.getItem(keys);
     
     return_color="EMERGEANT";
      
      if (valueK<0)
	{
		return_color="MAJOR";
	}
      if (valueK>0)
      
	{
	return_color="MINOR";
	}
	
//alert(return_color);
      //alert(d.packageName);
     return color(return_color); 
      //return color(d.packageName); 
      
      });

  node.append("text")
      .attr("dy", ".3em")
      .style("text-anchor", "middle")
      .text(function(d) { return d.className.substring(0, d.r / 3); });
});
d3.select(self.frameElement).style("height", diameter + "px");
}
// Returns a flattened hierarchy containing all leaf nodes under the root.
function classes(root) {
  var classes = [];

  function recurse(name, node) {
    if (node.children) node.children.forEach(function(child) { recurse(node.name, child); });
    else classes.push({packageName: name, className: node.name, value: node.size});
  }

  recurse(null, root);
  return {children: classes};
}



var myVar = setInterval(function(){

//

var ii=i-2;
var im=i-1;
graphDone(i);
d3.select("#bubbledisplay"+ii).remove();
i=i+1;

}, 1000);
</script>

<div id='graphic'></div>
<?php
$no_need=1;
include("../tracking.php");
?>