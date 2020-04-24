<?php
$emo = $_GET['grupa'];
if ($emo == 'saldumi'){
	$vards = 'Tauki, saldumi';
	$vardi = mysqli_query($connection, "SELECT tvits FROM words where grupa = '1' limit 0, 500");
}else if ($emo == 'gala'){
	$vards = 'Gaļa, olas, zivis';
	$vardi = mysqli_query($connection, "SELECT tvits FROM words where grupa = '2' limit 0, 500");
}else if ($emo == 'piens'){
	$vards = 'Piena produkti';
	$vardi = mysqli_query($connection, "SELECT tvits FROM words where grupa = '3' limit 0, 500");
}else if ($emo == 'darzeni'){
	$vards = 'Dārzeņi';
	$vardi = mysqli_query($connection, "SELECT tvits FROM words where grupa = '4' limit 0, 500");
}else if ($emo == 'augli'){
	$vards = 'Augļi, ogas';
	$vardi = mysqli_query($connection, "SELECT tvits FROM words where grupa = '5' limit 0, 500");
}else if ($emo == 'maize'){
	$vards = 'Maize, graudaugu produkti, makaroni, rīsi, biezputras, kartupeļi';
	$vardi = mysqli_query($connection, "SELECT tvits FROM words where grupa = '6' limit 0, 500");
}else if ($emo == 'alkoholiskie'){
	$vards = 'Alkoholiskie dzērieni';
	$vardi = mysqli_query($connection, "SELECT tvits FROM words where grupa = '7' limit 0, 500");
}else if ($emo == 'bezalkoholiskie'){
	$vards = 'Bezalkoholiskie dzērieni';
	$vardi = mysqli_query($connection, "SELECT tvits FROM words where grupa = '8' limit 0, 500");
}else if ($emo == 'pozitivi'){
	$vards = 'Pozitīvie';
	$vardi = mysqli_query($connection, "SELECT text, screen_name FROM tweets where emo = '1' group by created_at desc limit 0, 500");
}else if ($emo == 'negativi'){
	$vards = 'Negatīvie';
	$vardi = mysqli_query($connection, "SELECT text, screen_name FROM tweets where emo = '2' group by created_at desc limit 0, 500");
}else if ($emo == 'neitrali'){
	$vards = 'Neitrālie';
	$vardi = mysqli_query($connection, "SELECT text, screen_name FROM tweets where emo = '3' group by created_at desc limit 0, 500");
}else if ($emo == 'Mon'){
	$vards = 'Pirmdienas';
	$vardi = mysqli_query($connection, "SELECT text, screen_name FROM tweets where DAYOFWEEK( created_at ) = 2 group by created_at desc limit 0, 500");
}else if ($emo == 'Tue'){
	$vards = 'Otrdienas';
	$vardi = mysqli_query($connection, "SELECT text, screen_name FROM tweets where DAYOFWEEK( created_at ) = 3 group by created_at desc limit 0, 500");
}else if ($emo == 'Wed'){
	$vards = 'Trešdienas';
	$vardi = mysqli_query($connection, "SELECT text, screen_name FROM tweets where DAYOFWEEK( created_at ) = 4 group by created_at desc limit 0, 500");
}else if ($emo == 'Thu'){
	$vards = 'Ceturtdienas';
	$vardi = mysqli_query($connection, "SELECT text, screen_name FROM tweets where DAYOFWEEK( created_at ) = 5 group by created_at desc limit 0, 500");
}else if ($emo == 'Fri'){
	$vards = 'Piektdienas';
	$vardi = mysqli_query($connection, "SELECT text, screen_name FROM tweets where DAYOFWEEK( created_at ) = 6 group by created_at desc limit 0, 500");
}else if ($emo == 'Sat'){
	$vards = 'Sestdienas';
	$vardi = mysqli_query($connection, "SELECT text, screen_name FROM tweets where DAYOFWEEK( created_at ) = 7 group by created_at desc limit 0, 500");
}else if ($emo == 'Sun'){
	$vards = 'Svētdienas';
	$vardi = mysqli_query($connection, "SELECT text, screen_name FROM tweets where DAYOFWEEK( created_at ) = 1 group by created_at desc limit 0, 500");
}else if ($emo == '0'){
	$vards = '00:00 - 01:00 rakstītie';
	$vardi = mysqli_query($connection, "SELECT text, screen_name, created_at FROM tweets having hour( created_at ) = 0  limit 0, 500");
}else if ($emo == '1'){
	$vards = '01:00 - 02:00 rakstītie';
	$vardi = mysqli_query($connection, "SELECT text, screen_name, created_at FROM tweets having hour( created_at ) = 1  limit 0, 500");
}else if ($emo == '2'){
	$vards = '02:00 - 03:00 rakstītie';
	$vardi = mysqli_query($connection, "SELECT text, screen_name, created_at FROM tweets having hour( created_at ) = 2  limit 0, 500");
}else if ($emo == '3'){
	$vards = '03:00 - 04:00 rakstītie';
	$vardi = mysqli_query($connection, "SELECT text, screen_name, created_at FROM tweets having hour( created_at ) = 3  limit 0, 500");
}else if ($emo == '4'){
	$vards = '04:00 - 05:00 rakstītie';
	$vardi = mysqli_query($connection, "SELECT text, screen_name, created_at FROM tweets having hour( created_at ) = 4  limit 0, 500");
}else if ($emo == '5'){
	$vards = '05:00 - 06:00 rakstītie';
	$vardi = mysqli_query($connection, "SELECT text, screen_name, created_at FROM tweets having hour( created_at ) = 5  limit 0, 500");
}else if ($emo == '6'){
	$vards = '06:00 - 07:00 rakstītie';
	$vardi = mysqli_query($connection, "SELECT text, screen_name, created_at FROM tweets having hour( created_at ) = 6  limit 0, 500");
}else if ($emo == '7'){
	$vards = '07:00 - 08:00 rakstītie';
	$vardi = mysqli_query($connection, "SELECT text, screen_name, created_at FROM tweets having hour( created_at ) = 7  limit 0, 500");
}else if ($emo == '8'){
	$vards = '08:00 - 09:00 rakstītie';
	$vardi = mysqli_query($connection, "SELECT text, screen_name, created_at FROM tweets having hour( created_at ) = 8  limit 0, 500");
}else if ($emo == '9'){
	$vards = '09:00 - 10:00 rakstītie';
	$vardi = mysqli_query($connection, "SELECT text, screen_name, created_at FROM tweets having hour( created_at ) = 9  limit 0, 500");
}else if ($emo == '10'){
	$vards = '10:00 - 11:00 rakstītie';
	$vardi = mysqli_query($connection, "SELECT text, screen_name, created_at FROM tweets having hour( created_at ) = 10  limit 0, 500");
}else if ($emo == '11'){
	$vards = '11:00 - 12:00 rakstītie';
	$vardi = mysqli_query($connection, "SELECT text, screen_name, created_at FROM tweets having hour( created_at ) = 11  limit 0, 500");
}else if ($emo == '12'){
	$vards = '12:00 - 13:00 rakstītie';
	$vardi = mysqli_query($connection, "SELECT text, screen_name, created_at FROM tweets having hour( created_at ) = 12  limit 0, 500");
}else if ($emo == '13'){
	$vards = '13:00 - 14:00 rakstītie';
	$vardi = mysqli_query($connection, "SELECT text, screen_name, created_at FROM tweets having hour( created_at ) = 13  limit 0, 500");
}else if ($emo == '14'){
	$vards = '14:00 - 15:00 rakstītie';
	$vardi = mysqli_query($connection, "SELECT text, screen_name, created_at FROM tweets having hour( created_at ) = 14  limit 0, 500");
}else if ($emo == '15'){
	$vards = '15:00 - 16:00 rakstītie';
	$vardi = mysqli_query($connection, "SELECT text, screen_name, created_at FROM tweets having hour( created_at ) = 15  limit 0, 500");
}else if ($emo == '16'){
	$vards = '16:00 - 17:00 rakstītie';
	$vardi = mysqli_query($connection, "SELECT text, screen_name, created_at FROM tweets having hour( created_at ) = 16  limit 0, 500");
}else if ($emo == '17'){
	$vards = '17:00 - 18:00 rakstītie';
	$vardi = mysqli_query($connection, "SELECT text, screen_name, created_at FROM tweets having hour( created_at ) = 17  limit 0, 500");
}else if ($emo == '18'){
	$vards = '18:00 - 19:00 rakstītie';
	$vardi = mysqli_query($connection, "SELECT text, screen_name, created_at FROM tweets having hour( created_at ) = 18  limit 0, 500");
}else if ($emo == '19'){
	$vards = '19:00 - 20:00 rakstītie';
	$vardi = mysqli_query($connection, "SELECT text, screen_name, created_at FROM tweets having hour( created_at ) = 19  limit 0, 500");
}else if ($emo == '20'){
	$vards = '20:00 - 21:00 rakstītie';
	$vardi = mysqli_query($connection, "SELECT text, screen_name, created_at FROM tweets having hour( created_at ) = 20  limit 0, 500");
}else if ($emo == '21'){
	$vards = '21:00 - 22:00 rakstītie';
	$vardi = mysqli_query($connection, "SELECT text, screen_name, created_at FROM tweets having hour( created_at ) = 21  limit 0, 500");
}else if ($emo == '22'){
	$vards = '22:00 - 23:00 rakstītie';
	$vardi = mysqli_query($connection, "SELECT text, screen_name, created_at FROM tweets having hour( created_at ) = 22  limit 0, 500");
}else if ($emo == '23'){
	$vards = '23:00 - 24:00 rakstītie';
	$vardi = mysqli_query($connection, "SELECT text, screen_name, created_at FROM tweets having hour( created_at ) = 23  limit 0, 500");
}
?>
<h2 style='margin:auto auto; text-align:center;'><?php echo $vards; ?> tvīti (500 jaunākie)</h2>
<br/>
<div>
<?php

$krasa=TRUE;
echo "<table id='results' style='margin:auto auto;'>";
echo "<tr>
<th>Lietotājs</th>
<th>Tvīts</th>
</tr>";
while($r=mysqli_fetch_array($vardi)){
	if($emo != 'saldumi' && $emo != 'gala' && $emo != 'piens' && $emo != 'darzeni' && $emo != 'augli' && $emo != 'maize' && $emo != 'alkoholiskie' && $emo != 'bezalkoholiskie'){
		$niks = $r["screen_name"];
		$teksts = $r["text"];
		if ($krasa==TRUE) {$kr=" class='even'";}else{$kr="";}
		echo '<tr'.$kr.'><td><b><a style="text-decoration:none;color:#658304;" href="/draugs/'.$niks.'">'.$niks.'</a></b></td><td>'.$teksts.'</td></tr>';
		$krasa=!$krasa;
	}else{
		$tvits = $r["tvits"];
		$tviti = mysqli_query($connection, "SELECT screen_name, text FROM tweets where id = '$tvits'");
		$p=mysqli_fetch_array($tviti);
		$niks = $p["screen_name"];
		$teksts = $p["text"];
		if ($krasa==TRUE) {$kr=" class='even'";}else{$kr="";}
		echo '<tr'.$kr.'><td><b><a style="text-decoration:none;color:#658304;" href="/draugs/'.$niks.'">'.$niks.'</a></b></td><td>'.$teksts.'</td></tr>';
		$krasa=!$krasa;
	}
}
echo "</table>";
?>
</div>