<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);
include_once("includes/arc2/ARC2.php");
//Vārds, atslēgvārds, grupa vai vieta?
if(isset($_GET['vards'])){
	$vards = urldecode($_GET['vards']);
	$vardi = mysqli_query($connection, "SELECT screen_name, text, created_at, emo, tvits, eng FROM words
																		JOIN tweets on id = tvits
																		where nominativs = '$vards'
																		group by tweets.id
																		order by created_at desc");

	$emocijas = mysqli_query($connection, "SELECT distinct emo, count( * ) skaits 
																		FROM tweets 
																		JOIN words on tvits = id
																		WHERE nominativs = '$vards' 
																		group by emo order by skaits desc");
} elseif (isset($_GET['grupa'])){
	$emo = urldecode($_GET['grupa']);
	if ($emo == 'saldumi'){
		$vards = 'Tauki, saldumi';
		$vardi = mysqli_query($connection, "SELECT * FROM words JOIN tweets on words.tvits = tweets.id where grupa = '1' limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																					JOIN words on words.tvits = tweets.id where grupa = '1'
																					group by `emo` order by `skaits` desc");
	}else if ($emo == 'gala'){
		$vards = 'Gaļa, olas, zivis';
		$vardi = mysqli_query($connection, "SELECT * FROM words JOIN tweets on words.tvits = tweets.id where grupa = '2' limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																					JOIN words on words.tvits = tweets.id where grupa = '2'
																					group by `emo` order by `skaits` desc");
	}else if ($emo == 'piens'){
		$vards = 'Piena produkti';
		$vardi = mysqli_query($connection, "SELECT * FROM words JOIN tweets on words.tvits = tweets.id where grupa = '3' limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																					JOIN words on words.tvits = tweets.id where grupa = '3'
																					group by `emo` order by `skaits` desc");
	}else if ($emo == 'darzeni'){
		$vards = 'Dārzeņi';
		$vardi = mysqli_query($connection, "SELECT * FROM words JOIN tweets on words.tvits = tweets.id where grupa = '4' limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																					JOIN words on words.tvits = tweets.id where grupa = '4'
																					group by `emo` order by `skaits` desc");
	}else if ($emo == 'augli'){
		$vards = 'Augļi, ogas';
		$vardi = mysqli_query($connection, "SELECT * FROM words JOIN tweets on words.tvits = tweets.id where grupa = '5' limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																					JOIN words on words.tvits = tweets.id where grupa = '5'
																					group by `emo` order by `skaits` desc");
	}else if ($emo == 'maize'){
		$vards = 'Maize, graudaugu produkti, makaroni, rīsi, biezputras, kartupeļi';
		$vardi = mysqli_query($connection, "SELECT * FROM words JOIN tweets on words.tvits = tweets.id where grupa = '6' limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																					JOIN words on words.tvits = tweets.id where grupa = '6'
																					group by `emo` order by `skaits` desc");
	}else if ($emo == 'alkoholiskie'){
		$vards = 'Alkoholiskie dzērieni';
		$vardi = mysqli_query($connection, "SELECT * FROM words JOIN tweets on words.tvits = tweets.id where grupa = '7' limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																					JOIN words on words.tvits = tweets.id where grupa = '7'
																					group by `emo` order by `skaits` desc");
	}else if ($emo == 'bezalkoholiskie'){
		$vards = 'Bezalkoholiskie dzērieni';
		$vardi = mysqli_query($connection, "SELECT * FROM words JOIN tweets on words.tvits = tweets.id where grupa = '8' limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																					JOIN words on words.tvits = tweets.id where grupa = '8'
																					group by `emo` order by `skaits` desc");
	}else if ($emo == 'pozitivi'){
		$vards = 'Pozitīvie';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets where emo = '1' group by created_at desc limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where emo = '1'
																		group by `emo` order by `skaits` desc");
	}else if ($emo == 'negativi'){
		$vards = 'Negatīvie';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets where emo = '-1' group by created_at desc limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where emo = '-1'
																		group by `emo` order by `skaits` desc");
	}else if ($emo == 'neitrali'){
		$vards = 'Neitrālie';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets where emo = '0' group by created_at desc limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where emo = '0'
																		group by `emo` order by `skaits` desc");
	}else if ($emo == 'Mon'){
		$vards = 'Pirmdienas';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets where DAYOFWEEK( created_at ) = 2 group by created_at desc limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where DAYOFWEEK( created_at ) = 2
																		group by `emo` order by `skaits` desc");
	}else if ($emo == 'Tue'){
		$vards = 'Otrdienas';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets where DAYOFWEEK( created_at ) = 3 group by created_at desc limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where DAYOFWEEK( created_at ) = 3
																		group by `emo` order by `skaits` desc");
	}else if ($emo == 'Wed'){
		$vards = 'Trešdienas';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets where DAYOFWEEK( created_at ) = 4 group by created_at desc limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where DAYOFWEEK( created_at ) = 4
																		group by `emo` order by `skaits` desc");
	}else if ($emo == 'Thu'){
		$vards = 'Ceturtdienas';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets where DAYOFWEEK( created_at ) = 5 group by created_at desc limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where DAYOFWEEK( created_at ) = 5
																		group by `emo` order by `skaits` desc");
	}else if ($emo == 'Fri'){
		$vards = 'Piektdienas';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets where DAYOFWEEK( created_at ) = 6 group by created_at desc limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where DAYOFWEEK( created_at ) = 6
																		group by `emo` order by `skaits` desc");
	}else if ($emo == 'Sat'){
		$vards = 'Sestdienas';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets where DAYOFWEEK( created_at ) = 7 group by created_at desc limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where DAYOFWEEK( created_at ) = 7
																		group by `emo` order by `skaits` desc");
	}else if ($emo == 'Sun'){
		$vards = 'Svētdienas';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets where DAYOFWEEK( created_at ) = 1 group by created_at desc limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where DAYOFWEEK( created_at ) = 1
																		group by `emo` order by `skaits` desc");
	}else if ($emo == '0'){
		$vards = '00:00 - 01:00 rakstītie';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets having hour( created_at ) = $emo limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where hour( created_at ) = $emo
																		group by `emo` order by `skaits` desc");
	}else if ($emo == '1'){
		$vards = '01:00 - 02:00 rakstītie';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets having hour( created_at ) = $emo limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where hour( created_at ) = $emo
																		group by `emo` order by `skaits` desc");
	}else if ($emo == '2'){
		$vards = '02:00 - 03:00 rakstītie';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets having hour( created_at ) = $emo limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where hour( created_at ) = $emo
																		group by `emo` order by `skaits` desc");
	}else if ($emo == '3'){
		$vards = '03:00 - 04:00 rakstītie';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets having hour( created_at ) = $emo limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where hour( created_at ) = $emo
																		group by `emo` order by `skaits` desc");
	}else if ($emo == '4'){
		$vards = '04:00 - 05:00 rakstītie';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets having hour( created_at ) = $emo limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where hour( created_at ) = $emo
																		group by `emo` order by `skaits` desc");
	}else if ($emo == '5'){
		$vards = '05:00 - 06:00 rakstītie';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets having hour( created_at ) = $emo limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where hour( created_at ) = $emo 
																		group by `emo` order by `skaits` desc");
	}else if ($emo == '6'){
		$vards = '06:00 - 07:00 rakstītie';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets having hour( created_at ) = $emo limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where hour( created_at ) = $emo
																		group by `emo` order by `skaits` desc");
	}else if ($emo == '7'){
		$vards = '07:00 - 08:00 rakstītie';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets having hour( created_at ) = $emo limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where hour( created_at ) = $emo
																		group by `emo` order by `skaits` desc");
	}else if ($emo == '8'){
		$vards = '08:00 - 09:00 rakstītie';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets having hour( created_at ) = $emo limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where hour( created_at ) = $emo
																		group by `emo` order by `skaits` desc");
	}else if ($emo == '9'){
		$vards = '09:00 - 10:00 rakstītie';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets having hour( created_at ) = $emo limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where hour( created_at ) = $emo
																		group by `emo` order by `skaits` desc");
	}else if ($emo == '10'){
		$vards = '10:00 - 11:00 rakstītie';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets having hour( created_at ) = $emo limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where hour( created_at ) = $emo
																		group by `emo` order by `skaits` desc");
	}else if ($emo == '11'){
		$vards = '11:00 - 12:00 rakstītie';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets having hour( created_at ) = $emo limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where hour( created_at ) = $emo
																		group by `emo` order by `skaits` desc");
	}else if ($emo == '12'){
		$vards = '12:00 - 13:00 rakstītie';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets having hour( created_at ) = $emo limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where hour( created_at ) = $emo
																		group by `emo` order by `skaits` desc");
	}else if ($emo == '13'){
		$vards = '13:00 - 14:00 rakstītie';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets having hour( created_at ) = $emo limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where hour( created_at ) = $emo
																		group by `emo` order by `skaits` desc");
	}else if ($emo == '14'){
		$vards = '14:00 - 15:00 rakstītie';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets having hour( created_at ) = $emo limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where hour( created_at ) = $emo
																		group by `emo` order by `skaits` desc");
	}else if ($emo == '15'){
		$vards = '15:00 - 16:00 rakstītie';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets having hour( created_at ) = $emo limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where hour( created_at ) = $emo
																		group by `emo` order by `skaits` desc");
	}else if ($emo == '16'){
		$vards = '16:00 - 17:00 rakstītie';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets having hour( created_at ) = $emo limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where hour( created_at ) = $emo
																		group by `emo` order by `skaits` desc");
	}else if ($emo == '17'){
		$vards = '17:00 - 18:00 rakstītie';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets having hour( created_at ) = $emo limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where hour( created_at ) = $emo
																		group by `emo` order by `skaits` desc");
	}else if ($emo == '18'){
		$vards = '18:00 - 19:00 rakstītie';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets having hour( created_at ) = $emo limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where hour( created_at ) = $emo
																		group by `emo` order by `skaits` desc");
	}else if ($emo == '19'){
		$vards = '19:00 - 20:00 rakstītie';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets having hour( created_at ) = $emo limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where hour( created_at ) = $emo
																		group by `emo` order by `skaits` desc");
	}else if ($emo == '20'){
		$vards = '20:00 - 21:00 rakstītie';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets having hour( created_at ) = $emo limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where hour( created_at ) = $emo
																		group by `emo` order by `skaits` desc");
	}else if ($emo == '21'){
		$vards = '21:00 - 22:00 rakstītie';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets having hour( created_at ) = $emo limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where hour( created_at ) = $emo
																		group by `emo` order by `skaits` desc");
	}else if ($emo == '22'){
		$vards = '22:00 - 23:00 rakstītie';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets having hour( created_at ) = $emo limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where hour( created_at ) = $emo
																		group by `emo` order by `skaits` desc");
	}else if ($emo == '23'){
		$vards = '23:00 - 24:00 rakstītie';
		$vardi = mysqli_query($connection, "SELECT * FROM tweets having hour( created_at ) = $emo limit 0, 500");
		$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` FROM `tweets` 
																		where hour( created_at ) = $emo
																		group by `emo` order by `skaits` desc");
	}
} elseif (isset($_GET['atslegvards'])){
	$vards = urldecode($_GET['atslegvards']);
	$tlvards = translit($vards);
	$tl2vards = translit2($vards);
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
	$vardi = mysqli_query($connection, "SELECT * FROM `tweets`
										where `text` LIKE '%$vards%'
										OR text LIKE '%$tlvards%'
										OR text LIKE '%$tl2vards%'
										".$SELECT." group by tweets.id
										order by `created_at` desc");

	$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` 
																		FROM `tweets` 
																		where `text` LIKE '%$vards%'
																		OR text LIKE '%$tlvards%'
																		OR text LIKE '%$tl2vards%'
																		".$SELECT." 
																		group by `emo` order by `skaits` desc");
} elseif (isset($_GET['vieta'])) {
	$vards = urldecode($_GET['vieta']);
	$vardi = mysqli_query($connection, "SELECT `screen_name`, `text`, `created_at`, `emo` FROM tweets 
																		WHERE `geo` = '$vards' order by `created_at` desc");
	
	$emocijas = mysqli_query($connection, "SELECT distinct `emo`, count( * ) `skaits` 
																		FROM `tweets` 
																		WHERE `geo` = '$vards' 
																		group by `emo` order by `skaits` desc");
}
//Iz DB
$ee=mysqli_fetch_array($vardi);
$eng = $ee["eng"];

//Info no DBPedia
$parser = ARC2::getRDFParser();
$parser->parse('http://dbpedia.org/data/'.$eng.'.rdf');
$triples = $parser->getSimpleIndex(0);

foreach($triples as $triple){
	//dabū anglisku aprakstu
	if (array_key_exists('http://dbpedia.org/ontology/abstract', $triple)){
		
		for ($xxx=0;$xxx<sizeof($triple['http://dbpedia.org/ontology/abstract']);$xxx++){
			if ($triple['http://dbpedia.org/ontology/abstract'][$xxx]['lang'] == 'en') {
					$apraksts = $triple['http://dbpedia.org/ontology/abstract'][$xxx]['value'];
				}
		}
	}
	//dabū sīkattēlu
	if (isset($triple['http://dbpedia.org/ontology/thumbnail'][0]['value'])) {
		$attels = $triple['http://dbpedia.org/ontology/thumbnail'][0]['value'];
	}
	//dabū lielo attēlu
	if (isset($triple['http://xmlns.com/foaf/0.1/depiction'][0]['value'])) {
		$lattels = $triple['http://xmlns.com/foaf/0.1/depiction'][0]['value'];
	}
}


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
  <div class="column middleleft"><img style="height:100px;" src="<?php echo $attels;?>"></div>
  <div class="column middleright"><div class="chart" id="emo-stat-v"></div></div>
  <div class="column right"><b>Apraksts [eng]:</b> <?php echo $apraksts; ?><br/>
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
	$tvits = $r["tvits"];
	$niks = $r["screen_name"];
	$teksts = $r["text"];

	if(has_emojis($vards) && mb_strpos($teksts,$vards) == false)
		continue;
	
	$teksts = str_replace($vards, '<span style="font-weight: bold; text-decoration:none;color: '.$txtCol.';">'.$vards.'</span>', $teksts);
	$teksts = enrich_text($teksts, "#229cec", $validFood);
	
	$datums = $r["created_at"];
	$laiks = strtotime($datums);
	$laiks = date("d.m.Y H:i", $laiks);
	if ($krasa==TRUE) {$kr=" class='even'";}else{$kr="";}
	echo '<tr'.$kr.'><td><b><a style="text-decoration:none;color:#658304;" href="/draugs/'.$niks.'">'.$niks.'</a></b></td><td>'.$teksts.'</td><td class="datu">'.$laiks.'</td></tr>';
	$krasa=!$krasa;
}
echo "</table>";
?>
</div>