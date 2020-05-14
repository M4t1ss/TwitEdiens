<?php
// Izvada vārdu formas tvītos ar attiecīgajām nominatīva formām, angliskajiem tulkojumiem un uzturvērtības grupām
// Formāts - python set, kur atslēga ir vārda forma tvītā
// SQL pieslēgšanās informācija
include "../includes/init_sql.php";

$q = mysqli_query($connection, "SELECT DISTINCT vards, nominativs, eng, grupa FROM words ORDER BY vards");

echo "{";
while($r = mysqli_fetch_array($q)){
	$vards		= $r["vards"];
	$nominativs	= $r["nominativs"];
	$eng		= $r["eng"];
	$grupa		= $r["grupa"];
	
	echo "'".trim($vards)."': ";
	echo "[";
	echo "'".trim($nominativs)."', ";
	echo "'".trim($eng)."', ";
	echo $grupa;
	echo "],</br>";
	
}
echo "}";