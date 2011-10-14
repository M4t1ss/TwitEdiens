<?php
//SQL pieslēgšanās informācija
$db_server = "localhost";
$db_database = "twitter_alerts";
$db_user = "root";
$db_password = "root";

//pieslēdzamies SQL serverim
$connection = @mysql_connect($db_server, $db_user, $db_password);
mysql_set_charset("utf8", $connection);
mysql_select_db($db_database);
?>