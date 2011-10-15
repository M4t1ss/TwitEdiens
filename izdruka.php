<?php
//Pieslēgums DB
include "init_sql.php";

//Pieslēdzamies SQL serverim
$connection = @mysql_connect($db_server, $db_user, $db_password);
mysql_set_charset("utf8", $connection);
mysql_select_db($db_database);

$q = mysql_query("SELECT text FROM  tweets");

//Izdrukā visus tvītus
while($r=mysql_fetch_array($q)){
   $teksts=$r["text"];
echo $teksts."<br/>";
}

?>
