<?php
//Izvada marķētos tvītus, atkarībā no parametra type:
//	get-annotated.php?type=poz - pozitīvie
//	get-annotated.php?type=nei - neitrālie
//	get-annotated.php?type=neg - negatīvie
//Pieslēgums DB
include "../includes/init_sql_latest.php";

if($_GET['type'] == 'nei'){
	$result= mysqli_query($connection, "SELECT id, screen_name, text FROM tweets WHERE emo = 0"); 
}
if($_GET['type'] == 'poz'){
	$result= mysqli_query($connection, "SELECT id, screen_name, text FROM tweets WHERE emo = 1"); 
}
if($_GET['type'] == 'neg'){
	$result= mysqli_query($connection, "SELECT id, screen_name, text FROM tweets WHERE emo = -1"); 
}else{
	$result= mysqli_query($connection, "SELECT emo, id, screen_name, text FROM tweets WHERE emo IS NOT NULL"); 
	
	echo "[</br>";
	while($p=mysqli_fetch_array($result)){
		switch($p["emo"]){
			case -1:
				$sentiment = "neg";
				break;
			case 0:
				$sentiment = "neu";
				break;
			case 1:
				$sentiment = "pos";
				break;
		}
		
		echo "&nbsp;&nbsp;&nbsp;{</br>";
		echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"sentiment":"'.$sentiment.'",</br>';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"screen_name":"'.$p["screen_name"].'",</br>';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"tweet_id":"'.$p["id"].'",</br>';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"tweet_text":"'.json_replacements(replacements($p["text"])).'"</br>';
		echo "&nbsp;&nbsp;&nbsp;},</br>";
	}
	echo "]";
	die;
}

while($p=mysqli_fetch_array($result)){
	echo $p["id"]."\t".$p["screen_name"]."\t".replacements($p["text"])."\n";
}
		
function json_replacements($text){
	$text = str_replace('\\', '\\\\"', $text);
	$text = str_replace('"', '\"', $text);
	return $text;
}
function replacements($text){
	for ($i=0; $i<10; $i++){
		$text = str_replace("\r\n", " ", $text);
		$text = str_replace("  ", " ", $text);
	}
	for ($i=0; $i<10; $i++){
		$text = str_replace("\n", " ", $text);
		$text = str_replace("  ", " ", $text);
	}
	for ($i=0; $i<10; $i++){
		$text = str_replace("  ", " ", $text);
	}
	
	return $text;
}