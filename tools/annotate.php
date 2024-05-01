<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');
//SQL pieslēgšanās informācija
$db_server = "localhost";
// $db_database = "baumuin_food";
$db_database = "baumuin_twitediens";
$db_user = "baumuin_bauma";
$db_password = "{GIwlpQ<?3>g";
//pieslēdzamies SQL serverim
$connection = mysqli_connect($db_server, $db_user, $db_password, $db_database);
mysqli_set_charset($connection, "utf8mb4");

$tweetID = $_GET["id"];
$value = $_GET["val"];
echo "Marķēsim tvītu ar ID ".$tweetID." kā ".$value."</br>";

if(isset($tweetID) && isset($value) && is_numeric($tweetID) && is_numeric($value)){
	$rez1 = mysqli_query($connection, "UPDATE `tweets` SET `emo` = $value WHERE `id` = $tweetID");
	echo $rez1."</br>";
}else{
	var_dump($tweetID,$value);
	var_dump(isset($tweetID), isset($value), is_numeric($tweetID), is_numeric($value));
}
