<?php
include_once("includes/arc2/ARC2.php");
$vards=urldecode($_GET['vards']);
$tlvards = translit($vards);
$tl2vards = translit2($vards);
//Vīr.dz. <=> Siev.dz.
if(substr($vards, -1) == "s"){
	$svards = substr($vards, 0, -1)."a";
	$tlsvards = translit($svards);
	$tl2svards = translit2($svards);
	$SELECT="OR text LIKE '%$svards%'
OR text LIKE '%$tlsvards%'
OR text LIKE '%$tl2svards%'
";
}elseif(substr($vards, -1) == "a"){
	$svards = substr($vards, 0, -1)."s";
	$tlsvards = translit($svards);
	$tl2svards = translit2($svards);
	$SELECT="OR text LIKE '%$svards%'
OR text LIKE '%$tlsvards%'
OR text LIKE '%$tl2svards%'
";
}else{
	$SELECT="";
}
//Iz DB
$vardi = mysqli_query($connection, "SELECT * FROM tweets
where text LIKE '%$vards%'
OR text LIKE '%$tlvards%'
OR text LIKE '%$tl2vards%'
".$SELECT." group by tweets.id
order by created_at desc
");
$ee=mysqli_fetch_array($vardi);
$eng = $ee["eng"];
$krasa=TRUE;
echo "<table id='results' style='margin:auto auto;'>";
echo "<tr>
<th>Lietotājs</th>
<th>Tvīts</th>
<th>Tvītots</th>
</tr>";
while($r=mysqli_fetch_array($vardi)){
	$tvits = $r["tvits"];
	$niks = $r["screen_name"];
	$teksts = $r["text"];
	
	#Iekrāso un izveido saiti uz katru pieminēto lietotāju tekstā
	#Šo vajadzētu visur...
	$matches = array();
	if (preg_match_all('/@[^[:space:]]+/', $teksts, $matches)) {
		foreach ($matches[0] as $match){
			$teksts = str_replace(trim($match), '<a style="text-decoration:none;color:#658304;" href="/draugs/'.str_replace('@','',trim($match)).'">'.trim($match).'</a> ', $teksts);
		}
	}
	$teksts = str_replace($vards, '<span style="font-weight: bold; text-decoration:none;color: red;">'.$vards.'</span>', $teksts);
	$teksts = str_replace($tlvards, '<span style="font-weight: bold; text-decoration:none;color: red;">'.$tlvards.'</span>', $teksts);
	$teksts = str_replace($tl2vards, '<span style="font-weight: bold; text-decoration:none;color: red;">'.$tl2vards.'</span>', $teksts);
	$teksts = str_replace($svards, '<span style="font-weight: bold; text-decoration:none;color: red;">'.$svards.'</span>', $teksts);
	$teksts = str_replace($tlsvards, '<span style="font-weight: bold; text-decoration:none;color: red;">'.$tlsvards.'</span>', $teksts);
	$teksts = str_replace($tl2svards, '<span style="font-weight: bold; text-decoration:none;color: red;">'.$tl2svards.'</span>', $teksts);
	
	$datums = $r["created_at"];
	if ($krasa==TRUE) {$kr=" class='even'";}else{$kr="";}
	echo '<tr'.$kr.'><td><b><a style="text-decoration:none;color:#658304;" href="/draugs/'.$niks.'">'.$niks.'</a></b></td><td>'.$teksts.'</td><td class="datu">'.$datums.'</td></tr>';
	$krasa=!$krasa;
}
echo "</table>";



function translit($word){
	$word = str_replace("ī","i",$word);
	$word = str_replace("ū","u",$word);
	$word = str_replace("ē","e",$word);
	$word = str_replace("ā","a",$word);
	$word = str_replace("š","s",$word);
	$word = str_replace("ģ","g",$word);
	$word = str_replace("ķ","k",$word);
	$word = str_replace("ļ","l",$word);
	$word = str_replace("ž","z",$word);
	$word = str_replace("č","c",$word);
	$word = str_replace("ņ","n",$word);
	return $word;
}

function translit2($word){
	$word = str_replace("ī","ii",$word);
	$word = str_replace("ū","uu",$word);
	$word = str_replace("ē","ee",$word);
	$word = str_replace("ā","aa",$word);
	$word = str_replace("š","sh",$word);
	$word = str_replace("ģ","gj",$word);
	$word = str_replace("ķ","kj",$word);
	$word = str_replace("ļ","lj",$word);
	$word = str_replace("ž","zh",$word);
	$word = str_replace("č","ch",$word);
	$word = str_replace("ņ","nj",$word);
	return $word;
}