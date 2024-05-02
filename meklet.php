<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "/home/baumuin/public_html/twitediens.tk/includes/init_sql.php";

echo "<h3>Meklēt pēc atslēgvārda</h3>";

$av = isset($_GET['atslegvards'])?$_GET['atslegvards']:"";
$nv = isset($_GET['nevards'])?$_GET['nevards']:"";


echo'
<form action="/index.php" style="text-align:center;">
	<input type="hidden" name="id" value="meklet">
	Iekļaut <input type="text" name="atslegvards" style="height:20px;margin-top:5px;" value="'.$av.'"><br/>
	Neiekļaut <input type="text" name="nevards" style="height:20px;margin-top:5px;" value="'.$nv.'"><br/>
  <input type="submit" value="Meklēt" style="margin-top:5px;padding:8px;">
</form>
';


//Atslēgvārds?
if (isset($_GET['atslegvards']) && strlen($_GET['atslegvards']) > 0){
	$vards = urldecode($_GET['atslegvards']);
	$tlvards = translit($vards);
	$tl2vards = translit2($vards);

	if (isset($_GET['nevards']) && strlen($_GET['nevards']) > 0){
		$nevards = urldecode($_GET['nevards']);
		$NOTLIKE = " AND text NOT LIKE '%$nevards%' ";
	}else{
		$NOTLIKE = "";
	}


	//Vīr.dz. <=> Siev.dz.
	if(substr($vards, -1) == "s"){
		$svards = substr($vards, 0, -1)."a";
		$tlsvards = translit($svards);
		$tl2svards = translit2($svards);
		$SELECT="OR text LIKE '%$svards%'
				OR text LIKE '%$tlsvards%'
				OR text LIKE '%$tl2svards%'
				";
	}elseif(substr($vards, -1) == "a"){
		$svards = substr($vards, 0, -1)."s";
		$tlsvards = translit($svards);
		$tl2svards = translit2($svards);
		$SELECT="OR text LIKE '%$svards%'
				OR text LIKE '%$tlsvards%'
				OR text LIKE '%$tl2svards%'
				";
	}else{
		$SELECT="";
	}
	//Iz DB
	$vardi = mysqli_query($connection, "SELECT distinct `text`, `id`, `screen_name`, `created_at`, `geo`, `emo`, `quoted_id` FROM `tweets`
										where (`text` LIKE '%$vards%'
										OR text LIKE '%$tlvards%'
										OR text LIKE '%$tl2vards%'
										".$SELECT.")".$NOTLIKE." 
										group by tweets.text order by `created_at` desc");

	$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` 
																		FROM `tweets` 
																		where (`text` LIKE '%$vards%'
																		OR text LIKE '%$tlvards%'
																		OR text LIKE '%$tl2vards%'
																		".$SELECT.")".$NOTLIKE." 
																		group by `emo` order by `skaits` desc");
	$count = mysqli_num_rows($vardi);

	//pozitīvie
	while($p=mysqli_fetch_array($emocijas)){
		$noskanojums = $p["emo"];
		$text = $p["skaits"];
		switch ($noskanojums) {
			case 0:
				$nei = $text;
				break;
			case 1:
				$poz = $text;
				break;
			case -1:
				$neg = $text;
				break;
		}
	}

	?>

	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
	  var chart;
	  google.load('visualization', '1.0', {'packages':['corechart']});
	  google.setOnLoadCallback(drawChart2);
	  $(window).resize(drawChart2);
	  function drawChart2() {
	  var data = new google.visualization.DataTable();
	  data.addColumn('string', 'Topping');
	  data.addColumn('number', 'Slices');
	  data.addRows([
		['Pozitīvi', <?php echo $poz; ?>],
		['Negatīvi', <?php echo $neg; ?>],
		['Neitrāli', <?php echo $nei; ?>]]);
	  var options = {'backgroundColor':'transparent',
					 'is3D':'true',
					 colors: ['green', 'red', 'gray'],
					 legend: 'none',
					 pieSliceText: 'label',
					 chartArea: {
					  // leave room for y-axis labels
					  height: '100%'
					}
	};
	  chart = new google.visualization.PieChart(document.getElementById('emo-stat-v'));
	  chart.draw(data, options);
	  }
	  $(window).resize(drawVisualization);
	</script>
	<!-- attēls -->
	 <div class="row">
	  <div class="column left"><a style='text-align:center;font-size:30px;font-weight:bold;margin:auto auto; width:50px;'><?php echo $vards; ?></a></div>
	  <div class="column middleright"><div class="chart" id="emo-stat-v"></div></div>
	  <div class="column right" style="padding-top: 5px;">
	  	Tekstā iekrāsoti <b style="color:#24CA12;">Twitēdiena atslēgvārdi</b> un <b style="color:#229cec;">meklētais atslēgvārds</b>.
	  	<br/><br/>Atrasti <?php echo $count;?> rezultāti. <a style="font-weight: bold" href="/includes/export.php?atslegvards=<?php echo $av;?>&nevards=<?php echo $nv;?>">Saglabāt</a>
	  </div>
	</div>
	<div>
	<?php
	$krasa=TRUE;
	$txtCol = "#229cec";
	echo "<table id='results' style='margin:auto auto;'>";
	echo "<tr>
	<th>Lietotājs</th>
	<th>Tvīts</th>
	<th style='width:150px;'>Laiks</th>
	</tr>";
	while($r=mysqli_fetch_array($vardi)){
		$niks = $r["screen_name"];
		$teksts = $r["text"];

		if(has_emojis($vards) && mb_strpos($teksts,$vards) == false)
			continue;
		
		$teksts = str_replace($vards, '<span style="font-weight: bold; text-decoration:none;color: '.$txtCol.';">'.$vards.'</span>', $teksts);
		$teksts = enrich_food($teksts, "#24CA12", $validFood);
		
		$datums = $r["created_at"];
		$laiks = strtotime($datums);
		$laiks = date("d.m.Y H:i", $laiks);
		if ($krasa==TRUE) {$kr=" class='even'";}else{$kr="";}
		echo '<tr'.$kr.'><td><b><a style="text-decoration:none;color:#658304;" href="/draugs/'.$niks.'">'.$niks.'</a></b></td><td>'.$teksts.'</td><td class="datu">'.$laiks.'</td></tr>';
		$krasa=!$krasa;
	}
	echo "</table>";
}
?>
</div>