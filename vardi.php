<?php
include 'includes/tag/classes/wordcloud.class.php';
include "includes/laiks.php";
?>
<h2 style='margin:auto auto; text-align:center;'>Populārākie produkti</h2>
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
group by nominativs, tvits");

$cloud = new wordCloud();
//jāuztaisa vēl, lai, uzklikojot uz kādu ēdienu, atvērtu visus tvītus, kas to pieminējuši...
while($r=mysqli_fetch_array($vardi)){
	$nom = $r["nominativs"];
	$cloud->addWord(array('word' => $nom, 'url' => 'vards/'.urlencode($nom)));
}
$cloud->orderBy('colour', 'desc');
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

while($r=mysqli_fetch_array($vardi)){
	$topvards = trim($r["vards"]);
	//dabū katra vārda skaitu pēdējās nedēļas laikā
	$quer = "select skaits, datums from vardiDiena where vards = '$topvards' order by datums desc limit 7";
	$vvv = mysqli_query($connection, $quer);
	
	$pirmaisDatums = true;
	for($i=0; $i<7; $i++){
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
				$dienas[$i][$uu]['datums'] =   date('Y-m-d',strtotime("-".$di." days"));
				$i++;
			}
			$pirmaisDatums = false;
		}
	
		$dienas[$i][$uu]['vards'] = $topvards;
		$dienas[$i][$uu]['skaits'] = ($rvvv["skaits"]==NULL ? '0' : $rvvv["skaits"]);
		$dienas[$i][$uu]['datums'] = $rvvv["datums"];
		if($rvvv["skaits"] > $max) $max = $rvvv["skaits"] + 1;
		$pirmaisDatums = false;
	}
	$uu++;
}
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
</script><br/><br/>
<div style="text-align:center;font-weight:bold;">Līderi</div>
<div id="vardi"></div>
</div>