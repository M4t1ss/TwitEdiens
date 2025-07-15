<h2 style='margin:auto auto; text-align:center;'>Pēdējo gadu statistika no Bluesky</h2>
<?php
// SQL pieslēgšanās informācija
include "includes/init_sql_bsky.php";
// $year = $_GET['gads'];

for ($gads=date("Y"); $gads > 2023 ; $gads--) { 
	// code...

	$datesInYear = getAllMonthDateCombinations($gads);

	// Ieraksti pa nedēļām
	$q = mysqli_query($connection, "SELECT COUNT( * ) AS skaits, Y, M
						FROM (
							SELECT * , Year( created_at ) AS Y, DATE_FORMAT(created_at, '%m-%d') AS M
							FROM posts
							WHERE Year(created_at) = '".$gads."'
						)t
						GROUP BY Y, M
						ORDER BY Y ASC , M ASC
	");
	$dati = $datumi = array();
	while($r=mysqli_fetch_array($q)){
		$skaits=$r["skaits"];
		$gads=$r["Y"];
		$menesis=$r["M"];
		
		$datumi[] = $menesis;
		$dati[$menesis] = $skaits;
	}
	$result = array_diff($datesInYear, $datumi);
	?>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
	  google.load("visualization", "1", {packages:["corechart"]});
	  google.setOnLoadCallback(drawChart);
	  function drawChart() {	
		var data<?php echo $gads; ?> = new google.visualization.DataTable();
		data<?php echo $gads; ?>.addColumn('string', 'Nedēļa');
		data<?php echo $gads; ?>.addColumn('number', 'Ieraksti');
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
		var chart<?php echo $gads; ?> = new google.visualization.ColumnChart(document.getElementById('bstats-weeks-<?php echo $gads; ?>'));
		chart<?php echo $gads; ?>.draw(data<?php echo $gads; ?>, {
              annotations: {
                  alwaysOutside: true,
                  textStyle: {
                      fontSize: 15,
                      color: '#000',
                      auraColor: 'none'
                  }
              },
							width: 1500, 
							height: 400,
							'backgroundColor':'transparent',
							trendlines: {
			          0: {type: 'linear', color: 'red'}
			        }, 
			        vAxis: {
			        	// viewWindow: {min: 0},
			        	textStyle: {color: 'black'}, 
			        	format: 'decimal',
			        	// title: 'Ieraksti',
			        	minValue: 0,
			        	// maxValue: 20000,
			        	// ticks: [500,1000,2000,4000,8000,16000,20000]
			        },
			        chartArea : { 
			        	left: 50,
			        	width: '95%'
		         	},
			        legend: { position: 'none' }
			});
	  }
	</script>
		<p style="text-align: center;">
			<span style="font-weight: bold;">
				<?php echo $gads; ?>
			</span>
			<?php echo " (".count($dati)." dienas, ".number_format(array_sum($dati), 0, ".", ",")." ieraksti)"; ?>
		</p>
		<div style="width:100%;" id="bstats-weeks-<?php echo $gads; ?>"></div>
	<br/>
	<?php
	// if($gads > 2009 && $gads != date("Y"))
	// 	foreach ($result as $trukstosais) {
	// 		// code...
	// 		echo $gads."-".$trukstosais."<br/>";
	// 	}
}


?>

<h2 style='margin:auto auto; text-align:center;'>Pēdējo gadu statistika no Mastodon</h2>
<?php
// SQL pieslēgšanās informācija
include "includes/init_sql_masto.php";
// $year = $_GET['gads'];

for ($gads=date("Y"); $gads > 2021 ; $gads--) { 
	// code...

	$datesInYear = getAllMonthDateCombinations($gads);

	// Ieraksti pa nedēļām
	$q = mysqli_query($connection, "SELECT COUNT( * ) AS skaits, Y, M
						FROM (
							SELECT * , Year( created_at ) AS Y, DATE_FORMAT(created_at, '%m-%d') AS M
							FROM statuses
							WHERE Year(created_at) = '".$gads."'
						)t
						GROUP BY Y, M
						ORDER BY Y ASC , M ASC
	");
	$dati = $datumi = array();
	while($r=mysqli_fetch_array($q)){
		$skaits=$r["skaits"];
		$gads=$r["Y"];
		$menesis=$r["M"];
		
		$datumi[] = $menesis;
		$dati[$menesis] = $skaits;
	}
	$result = array_diff($datesInYear, $datumi);
	?>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
	  google.load("visualization", "1", {packages:["corechart"]});
	  google.setOnLoadCallback(drawChart);
	  function drawChart() {	
		var data<?php echo $gads; ?> = new google.visualization.DataTable();
		data<?php echo $gads; ?>.addColumn('string', 'Nedēļa');
		data<?php echo $gads; ?>.addColumn('number', 'Ieraksti');
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
		var chart<?php echo $gads; ?> = new google.visualization.ColumnChart(document.getElementById('mstats-weeks-<?php echo $gads; ?>'));
		chart<?php echo $gads; ?>.draw(data<?php echo $gads; ?>, {
              annotations: {
                  alwaysOutside: true,
                  textStyle: {
                      fontSize: 15,
                      color: '#000',
                      auraColor: 'none'
                  }
              },
							width: 1500, 
							height: 400,
							'backgroundColor':'transparent',
							trendlines: {
			          0: {type: 'linear', color: 'red'}
			        }, 
			        vAxis: {
			        	// viewWindow: {min: 0},
			        	textStyle: {color: 'black'}, 
			        	format: 'decimal',
			        	// title: 'Ieraksti',
			        	minValue: 0,
			        	// maxValue: 20000,
			        	// ticks: [500,1000,2000,4000,8000,16000,20000]
			        },
			        chartArea : { 
			        	left: 50,
			        	width: '95%'
		         	},
			        legend: { position: 'none' }
			});
	  }
	</script>
		<p style="text-align: center;">
			<span style="font-weight: bold;">
				<?php echo $gads; ?>
			</span>
			<?php echo " (".count($dati)." dienas, ".number_format(array_sum($dati), 0, ".", ",")." ieraksti)"; ?>
		</p>
		<div style="width:100%;" id="mstats-weeks-<?php echo $gads; ?>"></div>
	<br/>
	<?php
	// if($gads > 2009 && $gads != date("Y"))
	// 	foreach ($result as $trukstosais) {
	// 		// code...
	// 		echo $gads."-".$trukstosais."<br/>";
	// 	}
}

function getAllMonthDateCombinations($year) {
    $datesArray = array();

    // Loop through months
    for ($month = 1; $month <= 12; $month++) {
        // Get the number of days in the month
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        
        // Loop through days
        for ($day = 1; $day <= $daysInMonth; $day++) {
            // Add the month and date combination to the array
            $datesArray[] = sprintf("%02d-%02d", $month, $day);
        }
    }

    return $datesArray;
}