<?php
//Izvada marķētos tvītus, atkarībā no parametra type:
//	get-annotated.php?type=poz - pozitīvie
//	get-annotated.php?type=nei - neitrālie
//	get-annotated.php?type=neg - negatīvie
//Pieslēgums DB
include "../includes/init_sql_latest.php";

if($_GET['type'] == 'nei'){
	$result= mysqli_query($connection, "SELECT text FROM tweets WHERE emo = 0"); 
}
if($_GET['type'] == 'poz'){
	$result= mysqli_query($connection, "SELECT text FROM tweets WHERE emo = 1"); 
}
if($_GET['type'] == 'neg'){
	$result= mysqli_query($connection, "SELECT text FROM tweets WHERE emo = -1"); 
}

while($p=mysqli_fetch_array($result)){
	echo $p["text"]."</br>";
}
		
