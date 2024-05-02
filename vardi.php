<?php
include 'includes/tag/classes/wordcloud.class.php';
include "includes/laiks.php";
?>
<h2 style='margin:auto auto; text-align:center;'>Populārākie produkti (<a href="emoji">😆</a>)</h2>
<h5 style='margin:auto auto; text-align:center;'>
<form method="post" action="?id=vardi">
No <input value="<?php echo $nn;?>" readonly size=9 type="text" id="from" name="from"/> līdz <input value="<?php echo $ll;?>" readonly size=9 type="text" id="to" name="to"/>
<INPUT TYPE="submit" name="submit" value="Parādīt"/>
</form>
</h5>
<br/>
<div style="text-align:center;">
<?php
$vardi = mysqli_query($connection, "SELECT id, tvits, nominativs 
FROM words, tweets 
where tweets.id = words.tvits and tweets.created_at between '$no' AND '$lidz' 
and words.nominativs != '0'
group by nominativs, tvits
order by nominativs asc");

$cloud = new wordCloud();
//jāuztaisa vēl, lai, uzklikojot uz kādu ēdienu, atvērtu visus tvītus, kas to pieminējuši...
while($r=mysqli_fetch_array($vardi)){
	$nom = $r["nominativs"];
	$cloud->addWord(array('word' => $nom, 'url' => 'vards/'.urlencode($nom)));
}
// $cloud->orderBy('colour', 'desc');
$cloud->setLimit(500);
$myCloud = $cloud->showCloud('array');
foreach ($myCloud as $cloudArray) {
  echo ' &nbsp; <div style="display:inline-block;"><a href="'.$cloudArray['url'].'" class="word size'.$cloudArray['range'].'">'.$cloudArray['word'].'</a></div> &nbsp;';
}

//Cik rādīt?
$showing = 15;

// $date = date("Y-m-d");
// $from = $date." 00:00:01";
// $to = $date." 23:59:59";

//sākumā paņem pēdējo 3 dienu X populārākos vārdus un tad paskatās to vārdu skaitu pa nedēļu...
$vardi = mysqli_query($connection, "SELECT vards, AVG(skaits) as sk
FROM `vardiDiena`
WHERE datums BETWEEN curdate( ) - INTERVAL ".(($maxdays*24)+144)." HOUR AND curdate( ) - INTERVAL ".($maxdays*24)." HOUR
GROUP BY vards
ORDER BY sk DESC
LIMIT 0 , ".$showing);
$uu = 1;
$max = 0;

$today = date("Y-m-d");
$tod = date_create($today);

$maxE = 0;
$emoDienas = array();
for ($e = -1; $e < 2; $e++){
	$QRY = "SELECT count(`emo`) skaits,  DATE_FORMAT(created_at, '%m-%d') datums 
					FROM `tweets` 
					WHERE `emo` = $e 
					AND `created_at` BETWEEN curdate( ) - INTERVAL 336 HOUR AND curdate( )
					GROUP BY datums";
	$Qrez = mysqli_query($connection, $QRY);
	$cnt = 0;
	while($rez = mysqli_fetch_array($Qrez)){
		$emoDienas[$cnt]['sum'] += $rez["skaits"];
		$emoDienas[$cnt][$e+1]['skaits'] = $rez["skaits"];
		$emoDienas[$cnt][$e+1]['datums'] = $rez["datums"];
		if($rez["skaits"] > $maxE) $maxE = $rez["skaits"] + 1;
		$cnt++;
	}

}



while($r=mysqli_fetch_array($vardi)){
	$topvards = trim($r["vards"]);
	//dabū katra vārda skaitu pēdējās nedēļas laikā
	$quer = "select skaits, datums from vardiDiena where vards = '$topvards' order by datums desc limit 14";
	$vvv = mysqli_query($connection, $quer);
	
	$pirmaisDatums = true;
	for($i=0; $i<14; $i++){
		$rvvv=mysqli_fetch_array($vvv);
		$dd = substr($rvvv["datums"], -2);
		
		$prev = date_create($rvvv["datums"]);
		$diff = date_diff($prev, $tod);
		$difference = $diff->format("%a");
		
		if($pirmaisDatums && (0 != $difference)){
			//Laikam šim produktam šodien vēl nav tvītu... jāieliek nullīte
			for($di=0+$maxdays; $di < $difference; $di++){
				$dienas[$i][$uu]['vards'] = $topvards;
				$dienas[$i][$uu]['skaits'] = '0';
				$dienas[$i][$uu]['datums'] =   date('m-d',strtotime("-".$di." days"));
				$i++;
			}
			$pirmaisDatums = false;
		}
	
		$dienas[$i][$uu]['vards'] = $topvards;
		$dienas[$i][$uu]['skaits'] = ($rvvv["skaits"]==NULL ? '0' : $rvvv["skaits"]);
		$dienas[$i][$uu]['datums'] = substr($rvvv["datums"], 5);
		if($rvvv["skaits"] > $max) $max = $rvvv["skaits"] + 1;
		$pirmaisDatums = false;
	}
	$uu++;
}
// var_dump($dienas[7]);
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
  google.load('visualization', '1', {packages: ['corechart']});
</script>
<script type="text/javascript">
  function drawVisualization() {
	// Create and populate the data table.
	var data = google.visualization.arrayToDataTable([
	  ['x', <?php for ($skai=1;$skai<$showing+1;$skai++) { echo "'".$dienas[1][$skai]['vards']."'"; if($skai<$showing) echo ", "; }  ?>],
	  ['<?php echo $dienas[13][1]['datums'];?>', <?php for ($skai=1;$skai<$showing+1;$skai++) { echo $dienas[13][$skai]['skaits']; if($skai<$showing) echo ", "; }  ?>],
	  ['<?php echo $dienas[12][1]['datums'];?>', <?php for ($skai=1;$skai<$showing+1;$skai++) { echo $dienas[12][$skai]['skaits']; if($skai<$showing) echo ", "; }  ?>],
	  ['<?php echo $dienas[11][1]['datums'];?>', <?php for ($skai=1;$skai<$showing+1;$skai++) { echo $dienas[11][$skai]['skaits']; if($skai<$showing) echo ", "; }  ?>],
	  ['<?php echo $dienas[10][1]['datums'];?>', <?php for ($skai=1;$skai<$showing+1;$skai++) { echo $dienas[10][$skai]['skaits']; if($skai<$showing) echo ", "; }  ?>],
	  ['<?php echo $dienas[9][1]['datums'];?>', <?php for ($skai=1;$skai<$showing+1;$skai++) { echo $dienas[9][$skai]['skaits']; if($skai<$showing) echo ", "; }  ?>],
	  ['<?php echo $dienas[8][1]['datums'];?>', <?php for ($skai=1;$skai<$showing+1;$skai++) { echo $dienas[8][$skai]['skaits']; if($skai<$showing) echo ", "; }  ?>],
	  ['<?php echo $dienas[7][1]['datums'];?>', <?php for ($skai=1;$skai<$showing+1;$skai++) { echo $dienas[7][$skai]['skaits']; if($skai<$showing) echo ", "; }  ?>],
	  ['<?php echo $dienas[6][1]['datums'];?>', <?php for ($skai=1;$skai<$showing+1;$skai++) { echo $dienas[6][$skai]['skaits']; if($skai<$showing) echo ", "; }  ?>],
	  ['<?php echo $dienas[5][1]['datums'];?>', <?php for ($skai=1;$skai<$showing+1;$skai++) { echo $dienas[5][$skai]['skaits']; if($skai<$showing) echo ", "; }  ?>],
	  ['<?php echo $dienas[4][1]['datums'];?>', <?php for ($skai=1;$skai<$showing+1;$skai++) { echo $dienas[4][$skai]['skaits']; if($skai<$showing) echo ", "; }  ?>],
	  ['<?php echo $dienas[3][1]['datums'];?>', <?php for ($skai=1;$skai<$showing+1;$skai++) { echo $dienas[3][$skai]['skaits']; if($skai<$showing) echo ", "; }  ?>],
	  ['<?php echo $dienas[2][1]['datums'];?>', <?php for ($skai=1;$skai<$showing+1;$skai++) { echo $dienas[2][$skai]['skaits']; if($skai<$showing) echo ", "; }  ?>],
	  ['<?php echo $dienas[1][1]['datums'];?>', <?php for ($skai=1;$skai<$showing+1;$skai++) { echo $dienas[1][$skai]['skaits']; if($skai<$showing) echo ", "; }  ?>],
	  ['<?php echo $dienas[0][1]['datums'];?>', <?php for ($skai=1;$skai<$showing+1;$skai++) { echo $dienas[0][$skai]['skaits']; if($skai<$showing) echo ", "; }  ?>]
	]);
	new google.visualization.LineChart(document.getElementById('vardi')).
		draw(data, {curveType: "none",
					'chartArea': {'width': '75%', 'height': '90%'},
                    'backgroundColor':'transparent',
					vAxis: {
					  viewWindowMode:'explicit',
					  viewWindow:{
						max:<?php echo $max; ?>,
						min:0
					  }
			  }}
			);
  }
  google.setOnLoadCallback(drawVisualization);
  $(window).resize(drawVisualization);

  function drawVisualizationE() {
	// Create and populate the data table.
	var dataE = google.visualization.arrayToDataTable([
	  ['x', 'Negatīvs %','Neitrāls %', 'Pozitīvs %'],
	  <?php
		$MaxEmo = 0;
		$maxPast = count($emoDienas)<14?count($emoDienas):14;

		for ($cc = 0; $cc < $maxPast; $cc++){
			$datums = $emoDienas[$cc][1]['datums'];
			$skaits_neg = round($emoDienas[$cc][0]['skaits']/$emoDienas[$cc]['sum']*100,2);
			$skaits_nei = round($emoDienas[$cc][1]['skaits']/$emoDienas[$cc]['sum']*100,2);
			$skaits_poz = round($emoDienas[$cc][2]['skaits']/$emoDienas[$cc]['sum']*100,2);
			$MaxEmo = max($MaxEmo,$skaits_neg, $skaits_nei, $skaits_poz);
			echo "['$datums', $skaits_neg, $skaits_nei, $skaits_poz]".($cc<13?",\n":"\n");
		}
	  
	  ?>
	]);
	new google.visualization.LineChart(document.getElementById('emoChart')).
		draw(dataE, {
				curveType: "none",
					'chartArea': {'width': '75%', 'height': '90%'},
                    'backgroundColor':'transparent',
				vAxis: {
				  viewWindowMode:'explicit',
				  viewWindow:{
						max:<?php echo $MaxEmo; ?>,
						min:0
				  }
			  },
    		colors: ['red','grey','green']
  	});
  }
  google.setOnLoadCallback(drawVisualizationE);
  $(window).resize(drawVisualizationE);
</script>

<br/><br/>
<div style="text-align:center;font-weight:bold;">Līderi</div>
<div id="vardi"></div>
<br/><br/>
<div style="text-align:center;font-weight:bold;">Sentiments</div>
<div id="emoChart" style="height: 400px;"></div>
</div>