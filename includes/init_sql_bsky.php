<?php
//SQL pieslēgšanās informācija
$db_server = "";
$db_database = "";
$db_user = "";
$db_password = "";

//pieslēdzamies SQL serverim
$connection = mysqli_connect($db_server, $db_user, $db_password, $db_database);
mysqli_set_charset($connection, "utf8mb4");
// mysqli_select_db($db_database);
?>