<?php
//pirms cik dienām bija pirmais tvīts?
$die = mysqli_query($connection, "SELECT min( created_at ) diena FROM tweets");
$mdie=mysqli_fetch_array($die);
$laiks=strtotime($mdie['diena']);
$laiks=date("U", $laiks);
$seconds = time() - $laiks;
$days = ceil($seconds / 60 / 60 / 24);

//pirms cik dienām bija jaunākais tvīts?
$die = mysqli_query($connection, "SELECT max( created_at ) diena FROM tweets");
$mdie=mysqli_fetch_array($die);
$laiks=strtotime($mdie['diena']);
$laiks=date("U", $laiks);
$seconds = time() - $laiks;
$maxdays = floor($seconds / 60 / 60 / 24);

if(isset($_POST['submit'])) //ja piespiests parādīt
{
	header('Content-type: text/HTML; charset=utf-8');
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
	$lidz =date("y-m-d", $laiks);
	$no = date("y-m-d", strtotime("-1 months", $laiks));
}
	$nn=strtotime($no);
	$nn=date("d-m-Y", $nn);
	$ll=strtotime($lidz);
	$ll=date("d-m-Y", $ll);
?>
<script type="text/javascript">
$(function() {
	$( "#from, #to" ).datepicker({ minDate: -<?php echo $days; ?>, maxDate: -<?php echo $maxdays; ?> });
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
<h2 style='margin:auto auto; text-align:center;'>Twitter gardēžu TOPS</h2>
<h5 style='margin:auto auto; text-align:center;'>
<form method="post" action="?id=tops">
No <input value="<?php echo $nn;?>" readonly size=9 type="text" id="from" name="from"/> līdz <input value="<?php echo $ll;?>" readonly size=9 type="text" id="to" name="to"/>
<INPUT TYPE="submit" name="submit" value="Parādīt"/>
</form>
</h5>
<br/>
<div id="toptable">
<?php
$krasa=TRUE;
$i=1;
echo "<table class='sortable' id='toptable2'>";
echo "<tr>
<th class='tb1'>Nr.</th>
<th class='tb2'>Lietotājs</th>
<th class='tb3'>Tvīti</th>
<th class='tb4'>Ēdieni</th>
<th class='tb5'>Vietas</th>
</tr>";

//Sevi un ziņu portālus neslavināsim :)
$blacklist = array(
    'laiki', 'epadomi', 'edienbots', 'gardedis_lv', 'LA_lv', 'JaunsLV', 'FOLKKLUBS', 
    'StilaparksLv', 'ifaktors', 'nralv', 'DelfiLV', 'Twitediens', 'budzis', 'cafeleningrad'
);

$q = mysqli_query($connection, "SELECT screen_name, count( * ) skaits FROM tweets 
								WHERE screen_name NOT IN ('".implode("','",$blacklist)."') 
								AND created_at between '$no' AND '$lidz' 
								GROUP BY screen_name 
								ORDER BY count( * ) DESC 
								LIMIT 0 , 20");

$qv = mysqli_query($connection, "SELECT screen_name, count( words.tvits ) varduskaits FROM tweets 
								JOIN words on tweets.id = words.tvits
								WHERE screen_name NOT IN ('".implode("','",$blacklist)."') 
								AND created_at between '$no' AND '$lidz' 
								GROUP BY screen_name 
								ORDER BY count( * ) DESC 
								LIMIT 0 , 100");
								
while($rx=mysqli_fetch_array($qv)){
	$edieni[$rx["screen_name"]] = $rx["varduskaits"];
	$users[] = $rx["screen_name"];
}

$qa = mysqli_query($connection, "SELECT screen_name, count( tweets.geo ) geoskaits FROM tweets 
								WHERE geo != ''
								AND screen_name IN ('".implode("','",$users)."') 
								AND created_at between '$no' AND '$lidz' 
								GROUP BY screen_name 
								ORDER BY geoskaits DESC 
								LIMIT 0 , 400");
while($rz=mysqli_fetch_array($qa)){
	$geo[$rz["screen_name"]] = $rz["geoskaits"];
}
while($r=mysqli_fetch_array($q)){
	if ($krasa==TRUE) {$kr=" class='even'";}else{$kr="";}
	$vards=$r["screen_name"];
	$skaits=$r["skaits"];
	echo "<tr".$kr.">
		<td class='tb1'>".$i.".</td>
		<td class='tb2'><b><a style='text-decoration:none;color:#808080;' href='/draugs/".$vards."'>".$vards."</a></b></td>
		<td class='tb3'>".$skaits."</td>
		<td class='tb4'>".$edieni[$vards]."</td>
		<td class='tb5'> ".$geo[$vards]."</td>
	</tr>";
	$krasa=!$krasa;
	$i++;
}
echo "</table>";
?>
</div>