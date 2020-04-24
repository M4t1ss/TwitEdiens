<?php
header("Content-Type: text/xml; charset=utf-8");
include "includes/init_sql.php";

//Dabū lapu un periodu
$lapa = $_GET['lapa'];
$no = $_GET['no'];
$lidz = $_GET['lidz'];

//Ja nav norādīts periods
if(!isset($no) && !isset($lidz)){
	//dabū šodienas datumu
	$menesiss = $menesis = date("m");
	$dienasz = $diena = date("d");
	$gadss = $gads = date("Y");
	//izrēķina datumu pirms mēneša
	$menesis--;
	if($menesis==0){
		$menesis=12;
		$gads--;
	}
	$no = $gads."-".$menesis."-".$diena;
	$lidz = $gadss."-".$menesiss."-".$dienasz;
}

$i=1;
//Tvītotāju tops
if ($lapa == 'tops'){
	$query = "SELECT screen_name, count( * ) skaits FROM tweets WHERE created_at between '$no' AND '$lidz' GROUP BY screen_name ORDER BY count( * ) DESC LIMIT 0 , 15";
	$resultID = mysqli_query($connection, $query, $connection) or die("Dati nav atrasti.");

	$xml_output = "<?xml version=\"1.0\"?>\n";
	$xml_output .= "<entries>\n";

	for($x = 0 ; $x < mysqli_num_rows($resultID) ; $x++){
		$row = mysqli_fetch_assoc($resultID);
		$xml_output .= "\t<entry>\n";
		$xml_output .= "\t\t<skaits>" . $row['skaits'] . "</skaits>\n";
			//Izvāc nelegālos simbolus
			$row['screen_name'] = str_replace("&", "&", $row['screen_name']);
			$row['screen_name'] = str_replace("<", "<", $row['screen_name']);
			$row['screen_name'] = str_replace(">", "&gt;", $row['screen_name']);
			$row['screen_name'] = str_replace("\"", "&quot;", $row['screen_name']);
		$xml_output .= "\t\t<screen_name>" . $row['screen_name'] . "</screen_name>\n";
		$xml_output .= "\t</entry>\n";
	}

	$xml_output .= "</entries>";

	$i++;
//Ēdienu tops
}else if($lapa == 'vardi'){
	$query = "SELECT distinct nominativs, count(nominativs) skaits FROM words, tweets where tweets.id = words.tvits and tweets.created_at between '$no' AND '$lidz' and words.nominativs != '0' group by nominativs ORDER BY `skaits` DESC LIMIT 0 , 15";
	$resultID = mysqli_query($connection, $query, $connection) or die("Dati nav atrasti.");

	$xml_output = "<?xml version=\"1.0\"?>\n";
	$xml_output .= "<entries>\n";

	for($x = 0 ; $x < mysqli_num_rows($resultID) ; $x++){
		$row = mysqli_fetch_array($resultID);
		$xml_output .= "\t<entry>\n";
		$xml_output .= "\t\t<skaits>" . $row['skaits'] . "</skaits>\n";
			//Izvāc nelegālos simbolus
			$row['nominativs'] = str_replace("&", "&", $row['nominativs']);
			$row['nominativs'] = str_replace("<", "<", $row['nominativs']);
			$row['nominativs'] = str_replace(">", "&gt;", $row['nominativs']);
			$row['nominativs'] = str_replace("\"", "&quot;", $row['nominativs']);
		$xml_output .= "\t\t<nominativs>" . $row['nominativs'] . "</nominativs>\n";
		$xml_output .= "\t</entry>\n";
	}

	$xml_output .= "</entries>";

	$i++;
}else if($lapa == 'laiki'){
	$query = "SELECT created_at FROM `tweets` WHERE created_at between '$no' AND '$lidz'";
	$resultID = mysqli_query($connection, $query, $connection) or die("Dati nav atrasti.");

	$max=0;
	for($zb=0;$zb<24;$zb++) $stundas[$zb][skaits]=0;

	while($r=mysqli_fetch_array($resultID)){
		$laiks=$r["created_at"];
		$laiks=strtotime($laiks);
		$laiks=date("G", $laiks);
		$stundas[$laiks][skaits]++;
		if($stundas[$laiks][skaits]>$max) $max=$stundas[$laiks][skaits];
	}

	$xml_output = "<?xml version=\"1.0\"?>\n";
	$xml_output .= "<entries>\n";
	
	//izdrukā populārākās stundas
	for($zb=0;$zb<24;$zb++) {
		$percent = round($stundas[$zb][skaits]/$max*100);
		if($percent!=100){$percent="0.".$percent;}else{$percent="1.0";}
		$xml_output .= "\t<entry>\n";
		$xml_output .= "\t\t<stunda>" . $zb.":00 - ".($zb+1).":00" . "</stunda>\n";
		$xml_output .= "\t\t<procenti>" . $percent . "</procenti>\n";
		$xml_output .= "\t</entry>\n";
	}

	$xml_output .= "</entries>";
}else if($lapa == 'dienas'){
	$query = "SELECT created_at FROM `tweets` WHERE created_at between '$no' AND '$lidz'";
	$resultID = mysqli_query($connection, $query, $connection) or die("Dati nav atrasti.");

	//jādabū visas dienas Mon-Sun...
	//šitā ir pirmdiena...sāksim ar to
	$theDate = '2011-10-31';
	$timeStamp = StrToTime($theDate);
	for($zb=0;$zb<7;$zb++) {
	$ddd = date('D', $timeStamp); 
	$timeStamp = StrToTime('+1 days', $timeStamp);
	$dienas[$ddd][skaits]=0;
	}

	$maxd=0;
	for($zb=0;$zb<24;$zb++) $stundas[$zb][skaits]=0;

	while($r=mysqli_fetch_array($resultID)){
		$laiks=$r["created_at"];
		$laiks=strtotime($laiks);
		$diena=date("D", $laiks);
		$dienas[$diena][skaits]++;
		if($dienas[$diena][skaits]>$maxd) $maxd=$dienas[$diena][skaits];
	}

	$xml_output = "<?xml version=\"1.0\"?>\n";
	$xml_output .= "<entries>\n";
	
	$theDate = '2011-10-31';
	$timeStamp = StrToTime($theDate);
	//izdrukā populārākās stundas
	for($zb=0;$zb<7;$zb++) {
		$ddd = date('D', $timeStamp); 
		$timeStamp = StrToTime('+1 days', $timeStamp);
		$percent = round($dienas[$ddd][skaits]/$maxd*100);
		switch ($ddd) {
			case 'Mon':
				$diena = "Pirmdien";
				break;
			case 'Tue':
				$diena = "Otrdien";
				break;
			case 'Wed':
				$diena = "Trešdien";
				break;
			case 'Thu':
				$diena = "Ceturtdien";
				break;
			case 'Fri':
				$diena = "Piektdien";
				break;
			case 'Sat':
				$diena = "Sestdien";
				break;
			case 'Sun':
				$diena = "Svētdien";
				break;
		}
		if($percent!=100){$percent="0.".$percent;}else{$percent="1.0";}
		$xml_output .= "\t<entry>\n";
		$xml_output .= "\t\t<diena>" . $diena . "</diena>\n";
		$xml_output .= "\t\t<procenti>" . $percent . "</procenti>\n";
		$xml_output .= "\t</entry>\n";
	}

	$xml_output .= "</entries>";
}else if($lapa == 'vietas'){
	$query = "SELECT distinct geo, count( * ) skaits FROM `tweets` WHERE geo!='' and created_at between '$no' AND '$lidz' GROUP BY geo ORDER BY count( * ) DESC LIMIT 0 , 15";
	$resultID = mysqli_query($connection, $query, $connection) or die("Dati nav atrasti.");
	$resultID2 = mysqli_query($connection, $query, $connection) or die("Dati nav atrasti.");

	$max=1;

	$xml_output = "<?xml version=\"1.0\"?>\n";
	$xml_output .= "<entries>\n";
	
	while($r=mysqli_fetch_array($resultID2)){
		$skaits=$r["skaits"];
		$g=$r["geo"];
		if($skaits>$max&&$g!="Riga") $max=$skaits;
	}
	
	while($r=mysqli_fetch_array($resultID)){
		$sk=$r["skaits"];
		$geo=$r["geo"];
		
		$xml_output .= "\t<entry>\n";
		$xml_output .= "\t\t<skaits>" . $sk/$max . "</skaits>\n";
			//Izvāc nelegālos simbolus
			$geo = str_replace("&", "&", $geo);
			$geo = str_replace("<", "<", $geo);
			$geo = str_replace(">", "&gt;", $geo);
			$geo = str_replace("\"", "&quot;", $geo);
		$xml_output .= "\t\t<vieta>" . $geo . "</vieta>\n";
		$xml_output .= "\t</entry>\n";
	}

	$xml_output .= "</entries>";
}

//Izdrukā visu
echo $xml_output;

?>