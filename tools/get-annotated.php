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
}

while($p=mysqli_fetch_array($result)){
	echo $p["id"]."\t".$p["screen_name"]."\t".replacements($p["text"])."\n";
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