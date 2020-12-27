<?php
include "includes/laiks.php";
?>
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
    'laiki', 'epadomi', 'edienbots', 'gardedis_lv', 'LA_lv', 'JaunsLV', 'FOLKKLUBS', 'KJ_Sievietem', '8Lounge1', 'VidzAugstskola', 
    'StilaparksLv', 'ifaktors', 'nralv', 'DelfiLV', 'Twitediens', 'budzis', 'cafeleningrad', 'RestoransChat', 'integreta_bibl', 'receptes_eu'
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