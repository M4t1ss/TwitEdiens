<?php
header('Content-Type: text/html; charset=utf-8');

include("init_sql.php");

$select = mysql_query("SELECT id, text, screen_name, created_at
FROM `tweets`
WHERE `text` LIKE '%@%' order by created_at desc");
while($r=mysql_fetch_array($select)){
	$tvita_id = $r["id"];
	$autors = $r["screen_name"];
	$datums = $r["created_at"];
	$vardi = explode(" ", $r["text"]);
	foreach($vardi as $vards){
		if(substr($vards, 0, 1)=="@") {
			$pieminetais = str_replace("@", "", $vards);
			echo $autors." pieminēja ".$pieminetais."<br/>";
			//echo mysql_num_rows($select)."<br/>";
			//Pievieno DB
			$insert = mysql_query("insert into mentions
			(tweet_id, screen_name, mention, date) 
			VALUES ('$tvita_id','$autors','$pieminetais','$datums')");
		}
	}
}
?>