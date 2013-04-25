<?php
header('Content-Type: text/html; charset=utf-8');
//SQL pieslēgšanās informācija
$db_server = "mysql:3306";
$db_database = "baumuin_food";
$db_user = "baumuin_bauma";
$db_password = "{GIwlpQ<?3>g";
//pieslēdzamies SQL serverim
$connection = @mysql_connect($db_server, $db_user, $db_password);
mysql_set_charset("utf8", $connection);
mysql_select_db($db_database);

//sākumā paņem pēdējās dienas piecus vārdus un tad paskatās to vārdu skaitu pa nedēļu...
$vardi = mysql_query("SELECT *
FROM `vardiDiena`
WHERE datums = curdate( ) - interval 24 hour
ORDER BY `vardiDiena`.`skaits` DESC
LIMIT 0 , 5");
$uu = 1;
while($r=mysql_fetch_array($vardi)){
	$topvards = $r["vards"];
	//dabū katra vārda skaitu pēdējās nedēļas laikā
		$vvv = mysql_query("select skaits, datums from vardiDiena where vards = '$topvards' order by datums desc limit 7");
		
	for($i=0; $i<7; $i++){$rvvv=mysql_fetch_array($vvv);
		$dienas[$i][$uu]['vards'] = $topvards;
		$dienas[$i][$uu]['skaits'] = $rvvv["skaits"];
		$dienas[$i][$uu]['datums'] = $rvvv["datums"];
	}
	$uu++;
}
?>

<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
  google.load('visualization', '1', {packages: ['corechart']});
</script>
<script type="text/javascript">
  function drawVisualization() {
	// Create and populate the data table.
	var data = google.visualization.arrayToDataTable([
	  ['x', <?php echo "'".$dienas[1][1]['vards']."'";?>, <?php echo "'".$dienas[1][2]['vards']."'";?>, <?php echo "'".$dienas[1][3]['vards']."'";?>, <?php echo "'".$dienas[1][4]['vards']."'";?>, <?php echo "'".$dienas[1][5]['vards']."'";?>],
	  ['<?php echo $dienas[6][1]['datums'];?>', <?php echo $dienas[6][1]['skaits'];?>, <?php echo $dienas[6][2]['skaits'];?>, <?php echo $dienas[6][3]['skaits'];?>, <?php echo $dienas[6][4]['skaits'];?>, <?php echo $dienas[6][5]['skaits'];?>],
	  ['<?php echo $dienas[5][1]['datums'];?>', <?php echo $dienas[5][1]['skaits'];?>, <?php echo $dienas[5][2]['skaits'];?>, <?php echo $dienas[5][3]['skaits'];?>, <?php echo $dienas[5][4]['skaits'];?>, <?php echo $dienas[5][5]['skaits'];?>],
	  ['<?php echo $dienas[4][1]['datums'];?>', <?php echo $dienas[4][1]['skaits'];?>, <?php echo $dienas[4][2]['skaits'];?>, <?php echo $dienas[4][3]['skaits'];?>, <?php echo $dienas[4][4]['skaits'];?>, <?php echo $dienas[4][5]['skaits'];?>],
	  ['<?php echo $dienas[3][1]['datums'];?>', <?php echo $dienas[3][1]['skaits'];?>, <?php echo $dienas[3][2]['skaits'];?>, <?php echo $dienas[3][3]['skaits'];?>, <?php echo $dienas[3][4]['skaits'];?>, <?php echo $dienas[3][5]['skaits'];?>],
	  ['<?php echo $dienas[2][1]['datums'];?>', <?php echo $dienas[2][1]['skaits'];?>, <?php echo $dienas[2][2]['skaits'];?>, <?php echo $dienas[2][3]['skaits'];?>, <?php echo $dienas[2][4]['skaits'];?>, <?php echo $dienas[2][5]['skaits'];?>],
	  ['Vakar', <?php echo $dienas[1][1]['skaits'];?>, <?php echo $dienas[1][2]['skaits'];?>, <?php echo $dienas[1][3]['skaits'];?>, <?php echo $dienas[1][4]['skaits'];?>, <?php echo $dienas[1][5]['skaits'];?>],
	  ['Šodien', <?php echo $dienas[0][1]['skaits'];?>, <?php echo $dienas[0][2]['skaits'];?>, <?php echo $dienas[0][3]['skaits'];?>, <?php echo $dienas[0][4]['skaits'];?>, <?php echo $dienas[0][5]['skaits'];?>]
	]);
  
	// Create and draw the visualization.
	new google.visualization.LineChart(document.getElementById('visualization')).
		draw(data, {curveType: "function",
					width: 900, height: 600,
					vAxis: {maxValue: 10}}
			);
  }
  

  google.setOnLoadCallback(drawVisualization);
</script>
<div id="visualization" style="width: 900px; height: 600px;"></div>