<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('memory_limit', '2G');
header('Content-type: text/html; charset=utf-8');
error_reporting(E_ALL);
//Kopē marķētos tvītus no mazās datubāzs uz lielo
//Pieslēgums DB
include "/home/baumuin/public_html/twitediens.tk/includes/init_sql_latest.php";
include "/home/baumuin/public_html/twitediens.tk/classify/evaluate_bayes.php";

// $db_database2 = "baumuin_food";
// $connection2 = mysqli_connect($db_server, $db_user, $db_password, $db_database2);
// mysqli_set_charset($connection2, "utf8mb4");

$i = 0;
echo "Sākam darbu.</br>";
//Load model
$model = file_get_contents("/home/baumuin/public_html/twitediens.tk/classify/model-proc2-nohash-smile-latest.json");
$classifier = new \Niiknow\Bayes();
$classifier->fromJson($model);

$result= mysqli_query($connection, "SELECT * FROM tweets WHERE emo IS NULL ORDER BY created_at DESC"); 

while($p=mysqli_fetch_array($result)){
	$id = $p["id"];
	$text = $p["text"];
	$emo = null;
	
	$pred = classify($text, $classifier);
	switch ($pred){
		case "pos":
			$emo = 1;
			break;
		case "neg":
			$emo = -1;
			break;
		case "nei":
			$emo = 0;
			break;
		default:
			echo "Kaut kas sabruka ar klasifikāciju!</br>";
			echo "<pre>";
			var_dump($pred);
			var_dump($id);
			// var_dump($text);
			echo "</pre>";
			echo "$text</br>";
			echo " <a style='color: black' href='/tools/del.php?id=".$id."'>Dzēst?</a> | ";
			echo " <a style='color: red' href='/tools/annotate.php?id=".$id."&val=-1'>Negatīvs</a> | ";
			echo " <a style='color: grey' href='/tools/annotate.php?id=".$id."&val=0'>Neitrāls</a> | ";
			echo " <a style='color: green' href='/tools/annotate.php?id=".$id."&val=1'>Pozitīvs</a></br>";
			continue 2;
	}
	$updateQuery = "UPDATE tweets SET emo = $emo WHERE id = $id and emo IS NULL";
	
	mysqli_query($connection, $updateQuery);
	$i++;
	if($i % 5 == 0) echo "Klasificēti ".$i." tvīti.</br>";
}

echo "Darbs pabeigts.</br>";

// $ct= mysqli_query($connection, "SELECT count(*) count FROM tweets WHERE emo IS NULL"); 
// $cr=mysqli_fetch_array($ct);
// $remaining = $cr["count"];
// $ct= mysqli_query($connection, "SELECT count(*) count FROM tweets WHERE emo IS NOT NULL"); 
// $cr=mysqli_fetch_array($ct);
// $done = $cr["count"];

// echo "Marķēti - $done</br>";
// echo "Atlikuši - $remaining</br>";