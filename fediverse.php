<h2 style='margin:auto auto; text-align:center;'>Bluesky dati</h2>
<?php
// SQL pieslēgšanās informācija
include "includes/init_sql_bsky.php";


// Tvīti pa mēnešiem
$q = mysqli_query($connection, "SELECT COUNT( * ) AS skaits, Y, M
					FROM (
						SELECT * , Year( created_at ) AS Y, Month( created_at ) AS M
						FROM posts
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
	data2.addColumn('number', 'Ieraksti');
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
		chart2.draw(data2, {
													width: 1200, 
													height: 400,
													'backgroundColor':'transparent',
								          vAxis: {
								            viewWindowMode:'explicit',
								            viewWindow: {
								              max:200,
								              min:0
								            }
								          }
		});
  }
</script>
	<div style="width:1200px;margin:auto auto;" id="stats-hours"></div>
<br/>
<h2 style='margin:auto auto; text-align:center;'>Mastodon dati</h2>
<?php
// SQL pieslēgšanās informācija
include "includes/init_sql_masto.php";


// Tvīti pa mēnešiem
$q = mysqli_query($connection, "SELECT COUNT( * ) AS skaits, Y, M
					FROM (
						SELECT * , Year( created_at ) AS Y, Month( created_at ) AS M
						FROM statuses
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
	var data3 = new google.visualization.DataTable();
	data3.addColumn('string', 'Laiks');
	data3.addColumn('number', 'Ieraksti');
	data3.addRows(<?php echo count($dati);?>);
<?php
//izdrukā populārākās stundas
$zb = 0;
foreach($dati as $laiks => $skaits) {
	echo "data3.setValue(".$zb.", 0, '".$laiks."');";
	echo "data3.setValue(".$zb.", 1, ".$skaits.");";
	$zb++;
}
?>
		var chart3 = new google.visualization.ColumnChart(document.getElementById('stats-hours-masto'));
		chart3.draw(data3, {
													width: 1200, 
													height: 400,
													'backgroundColor':'transparent',
								          vAxis: {
								            viewWindowMode:'explicit',
								            viewWindow: {
								              // max:70000,
								              min:0
								            }
								          }
		});
  }
</script>
	<div style="width:1200px;margin:auto auto;" id="stats-hours-masto"></div>
<br/>
