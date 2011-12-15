<?php
header("Content-type: text/html; charset=utf-8");
$vards = $_GET['vards'];
include "../../init_sql.php";
$vardi = mysql_query("SELECT grupa, eng FROM words where nominativs = '$vards'");
$ee=mysql_fetch_array($vardi);
$eng = $ee["eng"];
$grupa = $ee["grupa"];
echo $eng;
echo $grupa;
echo $vards;

?>
