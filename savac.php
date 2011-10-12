<?php
	set_time_limit(72000);

	include_once('config.php');

	$opts = array(
		'http'=>array(
			'method'	=>	"POST",
			'content'	=>	'track='.WORDS_TO_TRACK,
		)
	);
	//SQL pieslēgšanās informācija
	$db_server = "localhost";
	$db_database = "twitter_alerts";
	$db_user = "root";
	$db_password = "root";

	//pieslēdzamies SQL serverim
	$connection = @mysql_connect($db_server, $db_user, $db_password);
	mysql_set_charset("utf8", $connection);
	mysql_select_db($db_database);

	$context = stream_context_create($opts);
	while (1){
		//Pieslēgšanās ar savu twitter kontu
		$instream = fopen('https://'.TWITTER_USERNAME.':'.TWITTER_PASSWORD.'@stream.twitter.com/1/statuses/filter.json','r' ,false, $context);
		while(! feof($instream)) {
			if(! ($line = stream_get_line($instream, 20000, "\n"))) {
				continue;
			}else{
				$tweet = json_decode($line);
				//Attīra no īpašajiem simboliem
				$id = mysql_real_escape_string($tweet->{'id'});
				$geo = mysql_real_escape_string($tweet->{'geo'});
				$text = mysql_real_escape_string($tweet->{'text'});
				$screen_name = mysql_real_escape_string($tweet->{'user'}->{'screen_name'});
				$followers_count = mysql_real_escape_string($tweet->{'user'}->{'followers_count'});
				//Izdrukā uz ekrāna un saglabā datubāzē
				if ($text!="") {
				echo $text."<br/>";
				$ok = mysql_query("INSERT INTO tweets (id ,text ,screen_name ,followers_count, created_at, geo) VALUES ('$id', '$text', '$screen_name', '$followers_count', NOW(), '$geo')");
				}
				flush();
			}
		}
	}
?>