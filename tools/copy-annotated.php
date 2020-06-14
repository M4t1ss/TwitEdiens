<?php
//Kopē marķētos tvītus no mazās datubāzs uz lielo
//Pieslēgums DB
include "../includes/init_sql_latest.php";

$db_database2 = "baumuin_food";
$connection2 = mysqli_connect($db_server, $db_user, $db_password, $db_database2);
mysqli_set_charset($connection2, "utf8mb4");

$i = 0;
$j = 0;

$result= mysqli_query($connection, "SELECT * FROM tweets WHERE emo IS NOT NULL"); 
while($p=mysqli_fetch_array($result)){
	$id = $p["id"];
	$emo = $p["emo"];
	$result2 = mysqli_query($connection2, "SELECT * FROM tweets WHERE id = $id and emo IS NULL");
	if(mysqli_num_rows($result2)){
		//jāpievieno marķējums
		mysqli_query($connection2, "UPDATE tweets SET emo = $emo WHERE id = $id and emo IS NULL");
		$i++;
	}else{
		$j++;
	}
}

echo "Pārkopēti ".$i." marķējumi.</br>";
echo "Jau bija ".$j." marķējumi.";