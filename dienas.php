<?php
include "includes/laiks.php";
?>
<h2 style='margin:auto auto; text-align:center;'>Ēšanas kalendārs</h2>
<h5 style='margin:auto auto; text-align:center;'>
<form method="post" action="?id=dienas">
No <input value="<?php echo $nn;?>" readonly size=9 type="text" id="from" name="from"/> līdz <input value="<?php echo $ll;?>" readonly size=9 type="text" id="to" name="to"/>
<INPUT TYPE="submit" name="submit" value="Parādīt"/>
</form>
</h5>
<br/>
<h3>Cikos tvīto visbiežāk</h3>
<?php

//jādabū visas dienas Mon-Sun...
//šitā ir pirmdiena...sāksim ar to
$theDate = '2011-10-31';
$timeStamp = StrToTime($theDate);
for($zb=0;$zb<7;$zb++) {
$ddd = date('D', $timeStamp); 
$timeStamp = StrToTime('+1 days', $timeStamp);
$dienas[$ddd][skaits]=0;
}

$max=0;
$maxd=0;
$maxdat=0;
for($zb=0;$zb<24;$zb++) $stundas[$zb][skaits]=0;
for($zb=1;$zb<32;$zb++) $datumi[$zb][skaits]=0;

$q = mysqli_query($connection, "SELECT created_at FROM `tweets` WHERE created_at between '$no' AND '$lidz'");
while($r=mysqli_fetch_array($q)){
	$laiks=$r["created_at"];
	$laiks=strtotime($laiks);
	$datums=date("j", $laiks);
	$diena=date("D", $laiks);
	$laiks=date("G", $laiks);
	$dienas[$diena][skaits]++;
	$stundas[$laiks][skaits]++;
	$datumi[$datums][skaits]++;
	if($stundas[$laiks][skaits]>$max) $max=$stundas[$laiks][skaits];
	if($dienas[$diena][skaits]>$maxd) $maxd=$dienas[$diena][skaits];
	if($datumi[$laiks][skaits]>$maxdat) $maxdat=$datumi[$laiks][skaits];
}
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart2);
  $(window).resize(drawChart2);
  function drawChart2() {	
	var data2 = new google.visualization.DataTable();
	data2.addColumn('string', 'Stunda');
	data2.addColumn('number', 'Tvīti');
	data2.addRows(24);
<?php
//izdrukā populārākās stundas
for($zb=0;$zb<24;$zb++) {
echo "data2.setValue(".$zb.", 0, '".$zb.":00-".($zb+1).":00');";
echo "data2.setValue(".$zb.", 1, ".$stundas[$zb][skaits].");";
}
?>
		var chart2 = new google.visualization.ColumnChart(document.getElementById('stats-hours'));
	chart2.draw(data2, {'backgroundColor':'transparent', hAxis: {slantedText:true, slantedTextAngle:45 }});
  }
</script>
	<div id="stats-hours"></div>
<br/>
<h3>Kuros datumos tvīto visbiežāk</h3>
<!-- datumi -->
<script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart1);
  $(window).resize(drawChart1);
  function drawChart1() {	
	var data3 = new google.visualization.DataTable();
	data3.addColumn('string', 'Datums');
	data3.addColumn('number', 'Tvīti');
	data3.addRows(32);
<?php
//izdrukā populārākās stundas
for($zb=1;$zb<32;$zb++) {
echo "data3.setValue(".$zb.", 0, '".$zb."');";
echo "data3.setValue(".$zb.", 1, ".$datumi[$zb][skaits].");";
}
?>
		var chart3 = new google.visualization.ColumnChart(document.getElementById('stats-dates'));
	chart3.draw(data3, {'backgroundColor':'transparent'});
  }
</script>
	<div id="stats-dates"></div>
<br/>
<h3>Kurās dienās tvīto visbiežāk</h3>
<script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart);
  $(window).resize(drawChart);
  function drawChart() {
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Diena');
	data.addColumn('number', 'Tvīti');
			 data.addRows(7);			
			 data.setValue(6, 0, "Svētdiena");data.setValue(6, 1, <?php echo $dienas['Sun'][skaits];?>);
			 data.setValue(0, 0, "Pirmdiena");data.setValue(0, 1, <?php echo $dienas['Mon'][skaits];?>);
			 data.setValue(1, 0, "Otrdiena");data.setValue(1, 1, <?php echo $dienas['Tue'][skaits];?>);
			 data.setValue(2, 0, "Trešdiena");data.setValue(2, 1, <?php echo $dienas['Wed'][skaits];?>);
			 data.setValue(3, 0, "Ceturtdiena");data.setValue(3, 1, <?php echo $dienas['Thu'][skaits];?>);
			 data.setValue(4, 0, "Piektdiena");data.setValue(4, 1, <?php echo $dienas['Fri'][skaits];?>);
			 data.setValue(5, 0, "Sestdiena");data.setValue(5, 1, <?php echo $dienas['Sat'][skaits];?>);
			 var chart = new google.visualization.ColumnChart(document.getElementById('stats-wdays'));
	chart.draw(data, {'backgroundColor':'transparent'});
	}
</script>
	<div id="stats-wdays"></div>