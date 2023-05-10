<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');
//SQL pieslēgšanās informācija
$db_server = "localhost";
$db_database = "baumuin_food";
$db_user = "baumuin_bauma";
$db_password = "{GIwlpQ<?3>g";
//pieslēdzamies SQL serverim
$connection = mysqli_connect($db_server, $db_user, $db_password, $db_database);
mysqli_set_charset($connection, "utf8mb4");

$tweetID = $_GET["id"];
echo "Dzēsīsim tvītu ar ID ".$tweetID;
delete_trashy_tweet($tweetID);


function delete_trashy_tweet($id){
	global $connection;
	mysqli_query($connection, "DELETE FROM `words` WHERE `tvits` = $id");
	mysqli_query($connection, "DELETE FROM `mentions` WHERE `tweet_id` = $id");
	mysqli_query($connection, "DELETE FROM `media` WHERE `tweet_id` = $id");
	mysqli_query($connection, "DELETE FROM `tweets` WHERE `id` = $id");
}









