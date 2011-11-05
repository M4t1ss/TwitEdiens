<h1 style='margin:auto auto; text-align:center;'>Ēšanas kalendārs</h1>
<br/>
<h3>Cikos tvīto visbiežāk</h3>
<div style='margin:auto auto;width:500px;'>
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
$max=0;
$maxd=0;
for($zb=0;$zb<24;$zb++) $stundas[$zb][skaits]=0;

$q = mysql_query("SELECT created_at FROM `tweets` WHERE created_at between '$gads-$menesis-$diena' AND '$gadss-$menesiss-$dienasz'");
while($r=mysql_fetch_array($q)){
	$laiks=$r["created_at"];
	$laiks=strtotime($laiks);
	$diena=date("D", $laiks);
	$laiks=date("G", $laiks);
	$dienas[$diena][skaits]++;
	$stundas[$laiks][skaits]++;
	if($stundas[$laiks][skaits]>$max) $max=$stundas[$laiks][skaits];
	if($dienas[$diena][skaits]>$maxd) $maxd=$dienas[$diena][skaits];
}

//izdrukā populārākās stundas
for($zb=0;$zb<24;$zb++) {
$percent = round($stundas[$zb][skaits]/$max*100);
?>
<script type="text/javascript">
	$(function(){
		$("#progressbar<?php echo $zb;?>").progressbar({
			value: <?php echo $percent;?>
		});		
	});
</script>
<div style=" font: 50% 'Trebuchet MS', sans-serif;" id="progressbar<?php echo $zb;?>"></div>
<div class="sk"><?php echo $zb.":00 - ".($zb+1).":00";?></div>
</br>
<?php
}
?>
</div>
<br/>
<h3>Kurās dienās tvīto visbiežāk</h3>
<div style='margin:auto auto;width:500px;'>
<?php
$theDate = '2011-10-31';
$timeStamp = StrToTime($theDate);
//izdrukā populārākās dienas
for($zb=0;$zb<7;$zb++) {
$ddd = date('D', $timeStamp); 
$timeStamp = StrToTime('+1 days', $timeStamp);
$percent = round($dienas[$ddd][skaits]/$maxd*100);
?>
<script type="text/javascript">
	$(function(){
		$("#progressbar<?php echo $ddd;?>").progressbar({
			value: <?php echo $percent;?>
		});		
	});
</script>
<div style=" font: 50% 'Trebuchet MS', sans-serif;" id="progressbar<?php echo $ddd;?>"></div>
<div class="sk"><?php
switch ($ddd) {
    case 'Mon':
        echo "Pirmdien";
        break;
    case 'Tue':
        echo "Otrdien";
        break;
    case 'Wed':
        echo "Trešdien";
        break;
    case 'Thu':
        echo "Ceturtdien";
        break;
    case 'Fri':
        echo "Piektdien";
        break;
    case 'Sat':
        echo "Sestdien";
        break;
    case 'Sun':
        echo "Svētdien";
        break;
}
?></div>
</br>
<?php
}
?>

</div>