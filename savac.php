<?php
	include_once('config.php');
	$opts = array(
		'http'=>array(
			'method'	=>	"POST",
			'content'	=>	'track=garšot,garšoju,garšošu,garšo,garšoji,garšosi,garšoja,garšos,garšosiet,garšojot,garšošot,garšotu,jāgaršo,nogaršot,nogaršoju,nogaršošu,nogaršo,nogaršoji,nogaršosi,nogaršoja,nogaršos,nogaršojam,nogaršojām,nogaršosim,nogaršojat,nogaršojāt,nogaršosiet,nogaršojot,nogaršošot,nogaršotu,pagaršot,pagaršoju,pagaršošu,pagaršo,pagaršoji,pagaršosi,pagaršoja,pagaršos,pagaršojam,pagaršojām,pagaršosim,pagaršojat,pagaršojāt,pagaršosiet,pagaršojot,pagaršošot,pagaršotu,ēdu,ēdīšu,ēd,ēdi,ēdīsi,ēda,ēdīs,ēdam,ēdām,ēdīsim,ēdat,ēdāt,ēdīsiet,ēd,ēdot,ēdīšot,ēstu,jāēd,apēst,apēdu,apēdīšu,apēd,apēdi,apēdīsi,apēda,apēdīs,apēdam,apēdām,apēdīsim,apēdat,apēdāt,apēdīsiet,apēd,apēdot,apēdīšot,apēstu,atēst,atēdu,atēdīšu,atēd,atēdi,atēdīsi,atēda,atēdīs,atēdam,atēdām,atēdīsim,atēdat,atēdāt,atēdīsiet,atēd,atēdot,atēdīšot,atēstu,ieēst,ieēdu,ieēdīšu,ieēd,ieēdi,ieēdīsi,ieēda,ieēdīs,ieēdam,ieēdām,ieēdīsim,ieēdat,ieēdāt,ieēdīsiet,ieēd,ieēdot,ieēdīšot,ieēstu,izēst,izēdu,izēdīšu,izēd,izēdi,izēdīsi,izēda,izēdīs,izēdam,izēdām,izēdīsim,izēdat,izēdāt,izēdīsiet,izēd,izēdot,izēdīšot,izēstu,neēst,neēdu,neēdīšu,neēd,neēdi,neēdīsi,neēda,neēdīs,neēdam,neēdām,neēdīsim,neēdat,neēdāt,neēdīsiet,neēd,neēdot,neēdīšot,neēstu,noēst,noēdu,noēdīšu,noēd,noēdi,noēdīsi,noēda,noēdīs,noēdam,noēdām,noēdīsim,noēdat,noēdāt,noēdīsiet,noēd,noēdot,noēdīšot,noēstu,paēst,paēdu,paēdīšu,paēd,paēdi,paēdīsi,paēda,paēdīs,paēdam,paēdām,paēdīsim,paēdat,paēdāt,paēdīsiet,paēd,paēdot,paēdīšot,paēstu,uzēst,uzēdu,uzēdīšu,uzēd,uzēdi,uzēdīsi,uzēda,uzēdīs,uzēdam,uzēdām,uzēdīsim,uzēdat,uzēdāt,uzēdīsiet,uzēd,uzēdot,uzēdīšot,uzēstu,saēsties,saēdos,saēdīšos,saēdies,saēdīsies,saēdas,saēdās,saēdīsies,saēdamies,saēdāmies,saēdīsimies,saēdaties,saēdāties,saēdīsieties,saēdoties,saēstos,jāsaēdas,pārēsties,pārēdos,pārēdīšos,pārēdies,pārēdīsies,pārēdas,pārēdās,pārēdīsies,pārēdamies,pārēdāmies,pārēdīsimies,pārēdaties,pārēdāties,pārēdīsieties,pārēdoties,pārēstos,pieēsties,pieēdos,pieēdīšos,pieēdies,pieēdīsies,pieēdas,pieēdās,pieēdīsies,pieēdamies,pieēdāmies,pieēdīsimies,pieēdaties,pieēdāties,pieēdīsieties,pieēdoties,pieēstos,brokastot,brokastoju,brokastošu,brokasto,,brokastoji,brokastosi,brokastoja,brokastos,brokastojam,brokastojām,brokastosim,brokastojat,brokastojāt,brokastosiet,brokastojot,brokastošot,brokastotu,jābrokasto,pusdienot,pusdienoju,pusdienošu,pusdieno,pusdienoji,pusdienosi,pusdienoja,pusdienos,pusdienojam,pusdienojām,pusdienosim,pusdienojat,pusdienojāt,pusdienosiet,pusdienojiet,pusdienojot,pusdienošot,pusdienotu,jāpusdieno,vakariņot,vakariņoju,vakariņošu,vakariņo,vakariņoji,vakariņosi,vakariņoja,vakariņos,vakariņojam,vakariņojām,vakariņosim,vakariņojat,vakariņojāt,vakariņosiet,vakariņojiet,vakariņojot,vakariņošot,vakariņotu,iekožu,iekodīšu,iekodīsi,iekož,iekoda,iekodīs,iekožam,iekodām,iekodīsim,iekožat,iekodāt,iekodīsiet,iekožot,iekodīšot,iekostu,jāiekož,uzkožu,uzkodu,uzkodīšu,uzkodīsi,uzkož,uzkodīs,uzkožam,uzkodām,uzkodīsim,uzkožat,uzkodāt,uzkodīsiet,maltīte,garšīgs,garšīga,kārums,ņam,ņamma,apetīte,ēdiens,brokastis,pusdienas,vakariņas,brokastīs,pusdienās,vakariņās,launagā,ēst,ēdis,ēdusi,notiesāju,notiesāšu,notiesāt',
			)
	);
	
	//Pieslēgums DB
	include "init_sql.php";

	$context = stream_context_create($opts);
	$krasa=TRUE;
	echo "<table>";
	echo "<tr>
	<th>Lietotājs</th>
	<th>Tvīts</th>
	</tr>";
	while (1){
		$instream = fopen('https://m4t1ss:manalielakeda@stream.twitter.com/1/statuses/filter.json','r' ,false, $context);
		while(! feof($instream)) {
			if(! ($line = stream_get_line($instream, 20000, "\n"))) {
				continue;
			}else{
				if ($krasa==TRUE) {$kr=" style='background-color:#E0E0E0'";}else{$kr="";}
				$tweet = json_decode($line);
				//Clean the inputs before storing
				$id = mysql_real_escape_string($tweet->{'id'});
				$geo = mysql_real_escape_string($tweet->{'place'}->{'name'});
				$text = mysql_real_escape_string($tweet->{'text'});
				$screen_name = mysql_real_escape_string($tweet->{'user'}->{'screen_name'});
				//We store the new post in the database, to be able to read it later
				if ($text!="") {
				//Teksts jāsadala pa vārdiem, vārdi jānočeko, vai ir vārdu db tādi, ja ir
				//un, ja tas vārds ir ēdiens/dzēriens, jāpievieno kopā ar tvīta id,
				//ja ir un tas nav ēdiens/dzēriens, nekas nav jādara, ja nav db tāda vārda,
				//jāpievieno kopā ar tvīta id un irvards=0
				   
				//attīra
				$ntext = str_replace("\n", " ", $text);
				$ntext = str_replace("<br>", " ", $ntext);
				$ntext = str_replace("</br>", " ", $ntext);
				$ntext = str_replace(" - ", " ", $ntext);
				$ntext = str_replace(",", " ", $ntext);
				$ntext = str_replace(";", " ", $ntext);
				$ntext = str_replace("]", " ", $ntext);
				$ntext = str_replace("[", " ", $ntext);
				$ntext = str_replace(")", " ", $ntext);
				$ntext = str_replace("(", " ", $ntext);
				$ntext = str_replace("!", " ", $ntext);
				$ntext = str_replace("'", " ", $ntext);
				$ntext = str_replace('"', ' ', $ntext);
				$ntext = str_replace('#', " ", $ntext);
				$vardi = explode(" ", $ntext);
				for ($i = 0; $i < sizeof($vardi); $i++){
				   $vards = $vardi[$i];
				   if (strlen(preg_replace('/\s+/u','',$vards)) != 0 && strlen($vards) > 2 && substr($vards, 0, 4)!='http' && !preg_match('#[0-9]#',$vards) && !preg_match("/(%0A|%0D|\\n+|\\r+)/i", $vards) && !preg_match("/&/", $vards) && !preg_match("/@/", $vards)){
						$vards = str_replace(":", "", $vards);
						$vards = str_replace(".", "", $vards);
						$vards = str_replace("?", "", $vards);
					   $q = mysql_query("SELECT vards, nominativs, irediens FROM  words where vards = '$vards'");
						if(mysql_num_rows($q)==0){
							//ja nav tāda vārda vārdu datu bāzē
							$ok = mysql_query("INSERT INTO words (vards, tvits) VALUES ('$vards', '$id')");
						}else{
							//ja ir
							$r=mysql_fetch_array($q);
							$ir=$r["irediens"];
							$nominativs=$r["nominativs"];
							//ja tas ir ēdiens
							if ($ir==1){
							$ok = mysql_query("INSERT INTO words (vards, nominativs, tvits, irediens) VALUES ('$vards', '$nominativs', '$id', 1)");
							echo $vards."</br>";
							}
						}
					}
				}
				echo "<tr".$kr."><td><b><a style='text-decoration:none;color:#658304;'target='_blank' href='https://twitter.com/#!/".$screen_name."'>".$screen_name."</a></b></td><td>".$text."</td></tr>";
				$krasa=!$krasa;
				$ok = mysql_query("INSERT INTO tweets (id ,text ,screen_name, created_at, geo) VALUES ('$id', '$text', '$screen_name', NOW(), '$geo')");
				}
				flush();
				mysql_close($remote);
			}
		}
	}
echo "</table>";
?>
</body>
</html>
