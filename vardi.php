<?php
include 'includes/tag/classes/wordcloud.class.php';
if($_POST['submit']) //ja piespiests parādīt
{
   //ievācam visus mainīgos
   $no = strip_tags($_POST['from']);
   $lidz = strip_tags($_POST['to']);
	if($no==""){
	$no=date("y-m-d");
	}
	if($lidz==""){
	$lidz=date("y-m-d");
	}
	if($no==$lidz) {
		$no--;
		$no = date("y-m-d",strtotime($no."-24 hours"));
	}
	$ns=strtotime($no);
	$ls=strtotime($lidz);
	if($ns>$ls){
	$x=$no;
	$no=$lidz;
	$lidz=$x;
	}
	$no=strtotime($no);
	$no=date("Y-m-d", $no);
	$lidz=strtotime($lidz);
	$lidz=date("Y-m-d", $lidz);

}else{//ja ne, lai parādās pēdējā mēneša dati...
	//dabū šodienas datumu
	$menesiss = $menesis = date("m");
	$dienasz = $diena = date("d");
	$gadss = $gads = date("Y");
	//izrēķina datumu pirms mēneša
	$menesis--;
	if($menesis==0){
		$menesis=12;
		$gads--;
	}
	$no = $gads."-".$menesis."-".$diena;
	$lidz = $gadss."-".$menesiss."-".$dienasz;
}
	$nn=strtotime($no);
	$nn=date("d-m-Y", $nn);
	$ll=strtotime($lidz);
	$ll=date("d-m-Y", $ll);
//pirms cik dienām bija pirmais tvīts?
$die = mysql_query("SELECT min( created_at ) diena FROM tweets");
$mdie=mysql_fetch_array($die);
$laiks=strtotime($mdie['diena']);
$laiks=date("U", $laiks);
$seconds = time() - $laiks;
$days = ceil($seconds / 60 / 60 / 24);
?>
<script type="text/javascript">
$(function() {
	$( "#from, #to" ).datepicker({ minDate: -<?php echo $days; ?>, maxDate: "+0D" });
	var dates = $( "#from, #to" ).datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		onSelect: function( selectedDate ) {
			var option = this.id == "from" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
	$( "#from, #to" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
	$( "#from, #to" ).datepicker($.datepicker.regional['fr']);
	$( "#to" ).datepicker({ currentText: 'Today' });
});
</script>
<h2 style='margin:auto auto; text-align:center;'>Populārākie produkti</h2>
<h5 style='margin:auto auto; text-align:center;'>
<form method="post" action="?id=vardi">
No <input value="<?php echo $nn;?>" readonly size=9 type="text" id="from" name="from"/> līdz <input value="<?php echo $ll;?>" readonly size=9 type="text" id="to" name="to"/>
<INPUT TYPE="submit" name="submit" value="Parādīt"/>
</form>
</h5>
<br/>
<div>
<?php
$vardi = mysql_query("SELECT id, tvits, nominativs FROM words, tweets where tweets.id = words.tvits and tweets.created_at between '$no' AND '$lidz' and words.nominativs != '0'");

$cloud = new wordCloud();
//jāuztaisa vēl, lai, uzklikojot uz kādu ēdienu, atvērtu visus tvītus, kas to pieminējuši...
while($r=mysql_fetch_array($vardi)){
	$nom = $r["nominativs"];
	$cloud->addWord(array('word' => $nom, 'url' => 'vards/'.urlencode($nom)));
}
$cloud->orderBy('size', 'desc');
$cloud->setLimit(100);
$myCloud = $cloud->showCloud('array');
foreach ($myCloud as $cloudArray) {
  echo ' &nbsp; <a href="'.$cloudArray['url'].'" class="word size'.$cloudArray['range'].'">'.$cloudArray['word'].'</a> &nbsp;';
}


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
	  ['<?php echo $dienas[1][1]['datums'];?>', <?php echo $dienas[1][1]['skaits'];?>, <?php echo $dienas[1][2]['skaits'];?>, <?php echo $dienas[1][3]['skaits'];?>, <?php echo $dienas[1][4]['skaits'];?>, <?php echo $dienas[1][5]['skaits'];?>],
	  ['<?php echo $dienas[0][1]['datums'];?>', <?php echo $dienas[0][1]['skaits'];?>, <?php echo $dienas[0][2]['skaits'];?>, <?php echo $dienas[0][3]['skaits'];?>, <?php echo $dienas[0][4]['skaits'];?>, <?php echo $dienas[0][5]['skaits'];?>]
	]);
	new google.visualization.LineChart(document.getElementById('visualization')).
		draw(data, {curveType: "function",
					width: 700, height: 400,
                    'backgroundColor':'transparent',
					vAxis: {maxValue: 10}}
			);
  }
  google.setOnLoadCallback(drawVisualization);
</script><br/><br/><br/>
<div style="text-align:center;font-weight:bold;">Līderi</div>
<div id="visualization" style="margin: auto auto; width: 700px; height: 400px;"></div>
</div>