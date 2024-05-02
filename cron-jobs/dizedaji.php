<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ignore_user_abort(true);
set_time_limit(600);
//Twitter autentificēšanās
require 'alternative/oauth/vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
// require_once('twitteroauth/twitteroauth.php');
require_once('/home/baumuin/public_html/twitediens.tk/includes/config.php');
require '/home/baumuin/public_html/twitediens.tk/includes/blacklist.php';

header('Content-Type: text/html; charset=utf-8');
//SQL pieslēgšanās informācija
$db_server = "";
$db_database = "";
$db_user = "";
$db_password = "";
//pieslēdzamies SQL serverim
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_SECRET);
$DBconnection = mysqli_connect($db_server, $db_user, $db_password, $db_database);
mysqli_set_charset($DBconnection, "utf8mb4");


$text = 'Šodienas dižēdāji ir';
//dabū dienas ēdājus
$media_id = array();
$path = "/home/baumuin/public_html/twitediens.tk/auth/images/";
$q = 1;
$i = 0;
$vardi = mysqli_query($DBconnection, "SELECT distinct screen_name, count(screen_name) skaits FROM tweets where screen_name NOT IN ('".implode("','",$blacklist)."') AND created_at between now( ) - INTERVAL 24 HOUR and now( ) group by screen_name order by skaits desc limit 0, 5");
while($r=mysqli_fetch_array($vardi)){
	$usrn = $r["screen_name"];
	$tvsk = $r["skaits"];

	//Mēģināsim ielādēt 4 profila attēlus
	if($i < 4){
		$filename = $path.$usrn.".jpg";
		//Tikai tiem lietotājiem, kuriem mums vēl nav salgabāti attēli
		if(file_exists($filename) && filesize($filename) > 0){

		$connection->setApiVersion(1.1);

		$media = $connection->upload('media/upload', ['media' => $filename]);
		$media_id[] = $media->media_id_string;

		$connection->setApiVersion(2);
		}
	}

	if($q > 3 || in_array($usrn, $priduraki)){
		$mentionsign = ' ';
	}else{
		$mentionsign = ' @';
		$q++;
	}
	
	$text.=$mentionsign.$usrn.' ('.$tvsk.'x)';
	$i++;
}

//ziņas teksts
echo $text."</br>";
var_dump($media_id);

$parameters = [
    'text' => $text,
    'media' => ['media_ids' => $media_id]
];
$result = $connection->post('tweets', $parameters, true);

var_dump($result);