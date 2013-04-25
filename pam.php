<?php
error_reporting(0);
ignore_user_abort(true);
set_time_limit(0);
	$opts = array(
		'http'=>array(
			'method'	=>	"POST",
			'content'	=>	'track=garšot,garšoju,garšošu,garšo,garšoji,garšosi,garšoja,garšos,garšojot,garšotu,jāgaršo,nogaršot,nogaršoju,nogaršošu,nogaršo,nogaršoji,nogaršosi,nogaršoja,nogaršos,nogaršojam,nogaršojām,nogaršosim,nogaršojat,nogaršojāt,nogaršojot,nogaršotu,pagaršot,pagaršoju,pagaršošu,pagaršo,pagaršoji,pagaršosi,pagaršoja,pagaršos,pagaršojam,pagaršojām,pagaršosim,pagaršojat,pagaršojāt,pagaršojot,pagaršotu,ēdu,ēdīšu,ēd,ēdi,ēdīsi,ēda,ēdīs,ēdam,ēdām,ēdīsim,ēdat,ēdāt,ēdīsiet,ēd,ēdot,ēdīšot,ēstu,jāēd,apēst,apēdu,apēdīšu,apēd,apēdi,apēdīsi,apēda,apēdīs,apēdam,apēdām,apēdīsim,apēdat,apēdāt,apēdīsiet,apēd,apēdot,apēdīšot,apēstu,atēst,atēdu,atēd,atēd,ieēst,ieēdu,ieēdīšu,ieēd,ieēdi,ieēdīsi,ieēda,ieēdīs,ieēdam,ieēdām,ieēdīsim,ieēd,ieēdot,ieēstu,izēst,izēdu,izēdīšu,izēd,izēdi,izēdīsi,izēda,izēdīs,izēdam,izēdām,izēdīsim,izēdat,izēdāt,izēdīsiet,izēd,izēstu,neēst,neēdu,neēdīšu,neēd,neēdi,neēdīsi,neēda,neēdīs,neēdam,neēdām,neēdīsim,neēdat,neēdāt,neēd,neēdot,neēdīšot,neēstu,noēst,noēdu,noēdīšu,noēd,noēdi,noēdīsi,noēda,noēdīs,noēdam,noēdām,noēdīsim,noēd,noēdot,noēstu,paēst,paēdu,paēdīšu,paēd,paēdi,paēdīsi,paēda,paēdīs,paēdam,paēdām,paēdīsim,paēdat,paēdāt,paēd,paēdot,paēstu,uzēst,uzēdu,uzēdīšu,uzēd,uzēdi,uzēdīsi,uzēda,uzēdīs,uzēdam,uzēdām,uzēdīsim,uzēdat,uzēdāt,uzēdīsiet,uzēd,uzēdot,uzēstu,saēsties,saēdos,saēdīšos,saēdies,saēdīsies,saēdas,saēdās,saēdīsies,saēdamies,saēdāmies,saēdīsimies,saēdaties,saēdāties,saēdoties,saēstos,jāsaēdas,pārēsties,pārēdos,pārēdīšos,pārēdies,pārēdīsies,pārēdas,pārēdās,pārēdīsies,pārēdamies,pārēdāmies,pārēdīsimies,pārēdoties,pārēstos,pieēsties,pieēdos,pieēdīšos,pieēdies,pieēdīsies,pieēdas,pieēdās,pieēdīsies,pieēdamies,pieēdāmies,pieēdīsimies,pieēdoties,pieēstos,brokastot,brokastoju,brokastošu,brokasto,,brokastoji,brokastosi,brokastoja,brokastos,brokastojam,brokastojām,brokastosim,brokastojat,brokastojāt,brokastojot,jābrokasto,pusdienot,pusdienoju,pusdienošu,pusdieno,pusdienoji,pusdienosi,pusdienoja,pusdienos,pusdienojam,pusdienojām,pusdienosim,pusdienojat,pusdienojāt,pusdienojot,pusdienotu,jāpusdieno,vakariņot,vakariņoju,vakariņošu,vakariņo,vakariņoji,vakariņosi,vakariņoja,vakariņos,vakariņojam,vakariņojām,vakariņosim,vakariņojot,iekožu,iekodīšu,iekodīsi,iekož,iekoda,iekodīs,iekožam,iekodām,iekodīsim,iekožot,iekostu,jāiekož,uzkožu,uzkodu,uzkodīšu,uzkodīsi,uzkož,uzkodīs,uzkožam,uzkodām,uzkodīsim,uzkožat,maltīte,garšīgs,garšīga,kārums,ņam,ņamma,apetīte,ēdiens,brokastis,pusdienas,vakariņas,brokastīs,pusdienās,vakariņās,launagā,ēst,ēdis,ēdusi,notiesāju,notiesāšu,notiesāt,mandarīnus,saldējumu,tēju,pankūkas,šokolādi,šokolādes,kūku,čipšus,kafija,tēja,gaļu,končās,pelmeņus,piparkūkas,maizītes,mērci,ābolu,gaļas,kartupeļu,šokolāde,salātus,saldumus,hesītī,mandarīnu,kūkas,kartupeļus,mērce,tomātu,mandarīni,pelmeņi,Apelsīnu,Dārzeņu,salāti,saldējuma,Saldējums,kartupeļiem,tējas,maķītī,krēmzupa,Kārums,bulciņas,salātiem,zemeņu,piparkūku,maizīti,tējiņu,kūciņu,kāpostu,čipsi,sīpolu,vīnogas,krējumu,biešu,burkānu,rīsiem,dārzeņiem,sēnes',
			)
	);

	$context = stream_context_create($opts);
	while (1){
		$instream = fopen('https://jo_kapec_gan:baumas10@stream.twitter.com/1/statuses/filter.json','r' ,false, $context);
		while(! feof($instream)) {
			if(! ($line = stream_get_line($instream, 20000, "\n"))) {
				continue;
			}else{
				$remote = @mysql_connect("sql4.nano.lv:3306", "baumuin_bauma", "{GIwlpQ<?3>g");
				mysql_set_charset("utf8", $remote);
				mysql_select_db("baumuin_tweettest", $remote); 
				$tweet = json_decode($line);
				//Clean the inputs before storing
				$id = mysql_real_escape_string($tweet->{'id'});
				$geo = mysql_real_escape_string($tweet->{'place'}->{'name'});
				$text = mysql_real_escape_string($tweet->{'text'});
				$screen_name = mysql_real_escape_string($tweet->{'user'}->{'screen_name'});
				//We store the new post in the database, to be able to read it later
				if ($text!="") {
				$ok_r = mysql_query("INSERT INTO tweets (id ,text ,screen_name, created_at, geo) VALUES ('$id', '$text', '$screen_name', NOW(), '$geo')",$remote);
				}
				flush();
				mysql_close($remote);
			}
		}
	}
?>