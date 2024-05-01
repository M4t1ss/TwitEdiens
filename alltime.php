<h2 style='margin:auto auto; text-align:center;'>Pēdējo gadu statistika</h2>
<?php
// SQL pieslēgšanās informācija
include "includes/init_sql.php";


// Tvīti pa mēnešiem
$q = mysqli_query($connection, "SELECT COUNT( * ) AS skaits, Y, M
					FROM (
						SELECT * , Year( created_at ) AS Y, Month( created_at ) AS M
						FROM tweets
					)t
					GROUP BY Y, M
					ORDER BY Y ASC , M ASC
");
$dati = array();
while($r=mysqli_fetch_array($q)){
	$skaits=$r["skaits"];
	$gads=$r["Y"];
	$menesis=$r["M"];
	
	$dati[$gads."-".$menesis] = $skaits;
}
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart);
  function drawChart() {	
	var data2 = new google.visualization.DataTable();
	data2.addColumn('string', 'Laiks');
	data2.addColumn('number', 'Tvīti');
	data2.addRows(<?php echo count($dati);?>);
<?php
//izdrukā populārākās stundas
$zb = 0;
foreach($dati as $laiks => $skaits) {
	echo "data2.setValue(".$zb.", 0, '".$laiks."');";
	echo "data2.setValue(".$zb.", 1, ".$skaits.");";
	$zb++;
}
?>
		var chart2 = new google.visualization.ColumnChart(document.getElementById('stats-hours'));
	chart2.draw(data2, {width: 1200, height: 400,'backgroundColor':'transparent'});
  }
</script>
	<div style="width:1200px;margin:auto auto;" id="stats-hours"></div>
<br/>
<?php
// Ēdieni pa mēnešiem
mysqli_query($connection, "set @num := 0;");
mysqli_query($connection, "set @type := '';");
$q = mysqli_query($connection, 'select vards, periods, skaits
from (  
	select vards, periods, skaits,
		  @num := if(@type = periods, @num + 1, 1) as row_number,
		  @type := periods as dummy
	from(
		SELECT vards, SUM( skaits ) AS skaits, periods
		FROM (
			SELECT * , CONCAT(Year( datums ),".",Month( datums ),".") AS periods
			FROM vardiDiena
		)t
		GROUP BY periods, vards
		ORDER BY periods ASC, skaits DESC
	)z
) as x where x.row_number <= 3
');
echo mysqli_error($connection);
$dati = array();
$visiVardi = array();
$max = 0;
while($r=mysqli_fetch_array($q)){
	$vards=$r["vards"];
	$skaits=$r["skaits"];
	$periods=$r["periods"];
	if($periods != "0.0."){
		if($r["skaits"] > $max) $max = $r["skaits"] + 1;
			
		$citiDati[$periods][$vards] = $skaits;
		$visiVardi[] = $vards;
	}
}
$visiVardi = array_unique($visiVardi);
foreach($visiVardi as $vards){
	foreach($citiDati as $periods => $value){
		if(!isset($citiDati[$periods][$vards])) $citiDati[$periods][$vards] = 0;
	}
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
	  ['x', <?php 
	  $ctr = 1;
		array_multisort($visiVardi);
		foreach($visiVardi as $vards){
		  echo "'".$vards."'";
		  if($ctr < count($visiVardi)) echo ", ";
		  $ctr++;
		} 
	  ?>],
	  <?php 
	  $ctx = 1;
	  foreach($citiDati as $periods => $value){
		echo "[";
		$ctr = 1;
		echo "'".$periods."',";
		ksort($value);
		foreach($value as $vards => $skaits){
		  echo $skaits;
		  if($ctr < count($value)) echo ", ";
		  $ctr++;
		}
		echo "]";
		if($ctx < count($citiDati)) echo ", \n";
		$ctx++;
	  } 
	  ?>
	]);
	// Create and populate the data table.
	var data_recent = google.visualization.arrayToDataTable([
	  ['x', <?php 
	  $ctr = 1;
		array_multisort($visiVardi);
		foreach($visiVardi as $vards){
		  echo "'".$vards."'";
		  if($ctr < count($visiVardi)) echo ", ";
		  $ctr++;
		} 
	  ?>],
	  <?php 
	  $ctx = 1;
	  foreach($citiDati as $periods => $value){
	  	if(substr($periods, 0, 4) > 2015){
				echo "[";
				$ctr = 1;
				echo "'".$periods."',";
				ksort($value);
				foreach($value as $vards => $skaits){
				  echo $skaits;
				  if($ctr < count($value)) echo ", ";
				  $ctr++;
				}
				echo "]";
				if($ctx < count($citiDati)) echo ", \n";
				$ctx++;
	  	}
	  } 
	  ?>
	]);
	new google.visualization.LineChart(document.getElementById('visualization')).
		draw(data, {curveType: "none",
					width: 1200, height: 800,
					'chartArea': {'width': '75%', 'height': '85%'},
                    'backgroundColor':'transparent',
					vAxis: {
					  viewWindowMode:'explicit',
					  viewWindow:{
						max:<?php echo $max; ?>,
						min:0
					  }
					}
			}
		);
	new google.visualization.LineChart(document.getElementById('visualization-recent')).
		draw(data_recent, {curveType: "none",
					width: 1200, height: 800,
					'chartArea': {'width': '75%', 'height': '85%'},
                    'backgroundColor':'transparent',
					vAxis: {
					  viewWindowMode:'explicit',
					  viewWindow:{
						max:1100,
						min:0
					  }
					}
			}
		);
  }
  google.setOnLoadCallback(drawVisualization);
</script><br/><br/><br/>
<div style="text-align:center;font-weight:bold;">Ēdieni</div>
<div id="visualization" style="margin: auto auto; width: 1200px; height: 800px;"></div>
<div id="visualization-recent" style="margin: auto auto; width: 1200px; height: 800px;"></div>