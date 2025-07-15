<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');
//SQL pieslēgšanās informācija
$db_server = "";
$db_database = "";
$db_database2 = "";
$db_user = "";
$db_password = "";
//pieslēdzamies SQL serverim
$connection = mysqli_connect($db_server, $db_user, $db_password, $db_database);
$connection2 = mysqli_connect($db_server, $db_user, $db_password, $db_database2);
mysqli_set_charset($connection, "utf8mb4");

$tweetID = $_GET["id"];
echo "Dzēsīsim tvītu ar ID ".$tweetID."</br>";


$rez1 = mysqli_query($connection, "DELETE FROM `words` WHERE `tvits` = $tweetID");
$rez2 = mysqli_query($connection, "DELETE FROM `mentions` WHERE `tweet_id` = $tweetID");
$rez3 = mysqli_query($connection, "DELETE FROM `media` WHERE `tweet_id` = $tweetID");
$rez4 = mysqli_query($connection, "DELETE FROM `tweets` WHERE `id` = $tweetID");
	
echo $rez1."</br>";
echo $rez2."</br>";
echo $rez3."</br>";
echo $rez4."</br>";

$rez11 = mysqli_query($connection2, "DELETE FROM `words` WHERE `tvits` = $tweetID");
$rez21 = mysqli_query($connection2, "DELETE FROM `mentions` WHERE `tweet_id` = $tweetID");
$rez31 = mysqli_query($connection2, "DELETE FROM `media` WHERE `tweet_id` = $tweetID");
$rez41 = mysqli_query($connection2, "DELETE FROM `tweets` WHERE `id` = $tweetID");
	
echo $rez11."</br>";
echo $rez21."</br>";
echo $rez31."</br>";
echo $rez41."</br>";