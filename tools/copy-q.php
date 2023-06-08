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
$connection2 = mysqli_connect($db_server, $db_user, $db_password, "baumuin_twitediens");
mysqli_set_charset($connection, "utf8mb4");


$query = "SELECT id, quoted_id  FROM `tweets` WHERE `quoted_id` IS NOT NULL";

$vardi = mysqli_query($connection, $query);
$count = 0;
$total = 0;
$trashIDs = [];
while($r=mysqli_fetch_array($vardi)){
	$id = $r["id"];
	$quoted_id = $r["quoted_id"];
	mysqli_query($connection2, "UPDATE tweets SET quoted_id = '$quoted_id' WHERE id = $id");
}