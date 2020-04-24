<?php
//SQL pieslēgšanās informācija
$db_server = "localhost";
$db_database = "twitter_alerts";
$db_user = "root";
$db_password = "root";

//pieslēdzamies SQL serverim
$connection = mysqli_connect($db_server, $db_user, $db_password, $db_database);
mysqli_set_charset($connection, "utf8");
// mysql_select_db($db_database);
?>