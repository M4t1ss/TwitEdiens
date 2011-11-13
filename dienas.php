<?php
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
<h2 style='margin:auto auto; text-align:center;'>Ēšanas kalendārs</h2>
<h5 style='margin:auto auto; text-align:center;'>
<form method="post" action="?id=dienas">
No <input value="<?php echo $nn;?>" readonly size=7 type="text" id="from" name="from"/> līdz <input value="<?php echo $ll;?>" readonly size=7 type="text" id="to" name="to"/>
<INPUT TYPE="submit" name="submit" value="Parādīt"/>
</form>
</h5>
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

$max=0;
$maxd=0;
for($zb=0;$zb<24;$zb++) $stundas[$zb][skaits]=0;

$q = mysql_query("SELECT created_at FROM `tweets` WHERE created_at between '$no' AND '$lidz'");
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