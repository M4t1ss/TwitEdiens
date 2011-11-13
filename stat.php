<h2 style='margin:auto auto; text-align:center;'>Twitter gardēžu statistika</h2>
<br/>
<div style='margin:auto auto; width:350px;text-align:center;'>
<?php
//Tvītu kopskaits
$kopa = mysql_query("SELECT count( * ) skaits FROM tweets");
//Tvītu skaits, kuros norādīta atrašānās vieta
$geo = mysql_query("SELECT count( geo ) skaits FROM tweets where geo!=''");
//Dažādās atrašanās vietas
$geod = mysql_query("SELECT count( distinct geo ) skaits FROM tweets where geo!=''");
//Twitter lietotāju kopskaits
$scrnme = mysql_query("SELECT count( distinct screen_name ) skaits FROM tweets");
//Dažādās atrašanās vietas
$vardi = mysql_query("SELECT count( distinct nominativs ) skaits FROM words");
//Dažādās atrašanās vietas
$vardin = mysql_query("SELECT count( distinct vards ) skaits FROM words where irediens=2");

$r=mysql_fetch_array($kopa);
echo "Kopā par ēšanas tēmām ir <b>".$r["skaits"]."</b> tvītu.<br/>";
$r=mysql_fetch_array($scrnme);
echo "Tos rakstījuši <b>".$r["skaits"]."</b> dažādi lietotāji.<br/>";
$r=mysql_fetch_array($geo);
echo "<b>".$r["skaits"]."</b> no tiem norādīta atrašanās vieta.<br/>";
$r=mysql_fetch_array($geod);
echo "Kopā ir <b>".$r["skaits"]."</b> dažādas atrašanās vietas.<br/>";
$r=mysql_fetch_array($vardi);
echo "Kopā ir pieminēti <b>".$r["skaits"]."</b> dažādi ēdieni un dzērieni.<br/>";
$r=mysql_fetch_array($vardin);
echo "Kopā <b>".$r["skaits"]."</b> vārdi, kas nav ēdieni.<br/>";

?>
</div>