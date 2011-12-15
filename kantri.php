<?php
header("Content-type: text/html; charset=utf-8");
include "includes/init_sql.php";
//Paņem dažādās vietas
$q = mysql_query("SELECT distinct geo, count( * ) skaits FROM `tweets` WHERE geo!='' GROUP BY geo ORDER BY count( * ) DESC");
while($r=mysql_fetch_array($q)){
   $vieta=$r["geo"];
	$string = file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=".str_replace(" ", "%20",$vieta)."&sensor=true");
	$json=json_decode($string, true);
	$gar = sizeof($json["results"][0]["address_components"]);
	for ($i = 0; $i < $gar; $i++){
	if($json["results"][0]["address_components"][$i]['types'][0] == 'country')$valsts = $json["results"][0]["address_components"][$i]['long_name'];
	}
	echo $vieta.' - '.$valsts.'<br/>';
	$ok = mysql_query("UPDATE vietas set valsts = '$valsts' where nosaukums = '$vieta'");
}
?>