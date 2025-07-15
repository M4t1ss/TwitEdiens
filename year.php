<h2 style='margin:auto auto; text-align:center;'>Pēdējo gadu statistika</h2>
<?php
// SQL pieslēgšanās informācija
include "includes/init_sql.php";
// $year = $_GET['gads'];

for ($gads=date("Y"); $gads > 2006 ; $gads--) { 
	// Tvīti pa nedēļām
	$q = mysqli_query($connection, "SELECT COUNT( * ) AS skaits, Y, M
						FROM (
							SELECT * , Year( created_at ) AS Y, Week( created_at, 3 ) AS M
							FROM tweets
							WHERE Year(created_at) = '".$gads."'
						)t
						GROUP BY Y, M
						ORDER BY Y ASC , M ASC
	");
	$dati = array();
	while($r=mysqli_fetch_array($q)){
		$skaits=$r["skaits"];
		$gads=$r["Y"];
		$menesis=$r["M"];
		
		$dati[$menesis] = $skaits;
	}
	?>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
	  google.load("visualization", "1", {packages:["corechart"]});
	  google.setOnLoadCallback(drawChart);
	  function drawChart() {	
		var data<?php echo $gads; ?> = new google.visualization.DataTable();
		data<?php echo $gads; ?>.addColumn('string', 'Nedēļa');
		data<?php echo $gads; ?>.addColumn('number', 'Tvīti');
		data<?php echo $gads; ?>.addRows(<?php echo count($dati);?>);
	<?php
	//izdrukā populārākās stundas
	$zb = 0;
	foreach($dati as $laiks => $skaits) {
		echo "data".$gads.".setValue(".$zb.", 0, '".$laiks."');";
		echo "data".$gads.".setValue(".$zb.", 1, ".$skaits.");";
		$zb++;
	}
	?>
			var chart<?php echo $gads; ?> = new google.visualization.ColumnChart(document.getElementById('stats-weeks-<?php echo $gads; ?>'));
		chart<?php echo $gads; ?>.draw(data<?php echo $gads; ?>, {
              annotations: {
                  alwaysOutside: true,
                  textStyle: {
                      fontSize: 15,
                      color: '#000',
                      auraColor: 'none'
                  }
              },
							width: 1400, 
							height: 400,
							'backgroundColor':'transparent',
							trendlines: {
			          0: {type: 'linear', color: 'red'}
			        }, 
			        vAxis: {
			        	// viewWindow: {min: 0},
			        	textStyle: {color: 'black'}, 
			        	format: 'decimal',
			        	// title: 'Tvīti',
			        	minValue: 0,
			        	// maxValue: 20000,
			        	// ticks: [500,1000,2000,4000,8000,16000,20000]
			        }
			});
	  }
	</script>
		<p style="text-align: center; font-weight: bold;"><?php echo $gads; ?></p>
		<div style="width:1400px;margin:auto auto;" id="stats-weeks-<?php echo $gads; ?>"></div>
	<br/>
	<?php
}