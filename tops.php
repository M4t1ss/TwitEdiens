<?php
if($_POST['submit']) //ja piespiests parādīt
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
$die = mysqli_query($connection, "SELECT min( created_at ) diena FROM tweets");
$mdie=mysqli_fetch_array($die);
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
<h2 style='margin:auto auto; text-align:center;'>Twitter gardēžu TOPS</h2>
<h5 style='margin:auto auto; text-align:center;'>
<form method="post" action="?id=tops">
No <input value="<?php echo $nn;?>" readonly size=9 type="text" id="from" name="from"/> līdz <input value="<?php echo $ll;?>" readonly size=9 type="text" id="to" name="to"/>
<INPUT TYPE="submit" name="submit" value="Parādīt"/>
</form>
</h5>
<br/>
<div style='margin:auto auto; width:299px;text-align:center;'>
<?php
$krasa=TRUE;
$i=1;
echo "<table style='text-align:center;border-spacing:0px;border:1px solid white;'>";
echo "<tr>
<th>Vieta</th>
<th>Lietotājs</th>
<th>Tvītu skaits</th>
</tr>";

//Sevi un ziņu portālus neslavināsim :)
$blacklist = array(
    'laiki', 'epadomi', 'edienbots', 'gardedis_lv', 'LA_lv', 'JaunsLV', 
    'StilaparksLv', 'ifaktors', 'nralv', 'DelfiLV', 'Twitediens', 'budzis'
);

$q = mysqli_query($connection, "SELECT screen_name, count( * ) skaits FROM tweets WHERE screen_name NOT IN ('".implode("','",$blacklist)."') AND created_at between '$no' AND '$lidz' GROUP BY screen_name ORDER BY count( * ) DESC LIMIT 0 , 15");
while($r=mysqli_fetch_array($q)){
if ($krasa==TRUE) {$kr=" class='even'";}else{$kr="";}
$vards=$r["screen_name"];
$skaits=$r["skaits"];
echo "<tr".$kr."><td>".$i.".</td><td><b><a style='text-decoration:none;color:#808080;' href='/draugs/".$vards."'>".$vards."</a></b></td><td>".$skaits." tvīti</td></tr>";
$krasa=!$krasa;
$i++;
}
echo "</table>";
?>
</div>