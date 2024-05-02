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


$text = 'Šīs dienas tvītotākie produkti ir';
//dabū dienas produktus
$q = 1;
$vardi = mysqli_query($DBconnection, "SELECT DISTINCT ss.nominativs, count(ss.nominativs) skaits FROM(
    SELECT distinct words.tvits, words.nominativs
    FROM words, tweets 
    WHERE tweets.id = words.tvits 
    and tweets.created_at BETWEEN now( ) - INTERVAL 24 HOUR AND now( ) 
    group by words.tvits
) ss
group by ss.nominativs
order by skaits desc limit 0, 5");
while($r=mysqli_fetch_array($vardi)){
	$ediens = $r["nominativs"];
	$xxxx = $r["nominativs"];
	$xxxx = str_replace('ē','e',$xxxx);
	$xxxx = str_replace('ū','u',$xxxx);
	$xxxx = str_replace('ī','i',$xxxx);
	$xxxx = str_replace('ā','a',$xxxx);
	$xxxx = str_replace('š','s',$xxxx);
	$xxxx = str_replace('ģ','g',$xxxx);
	$xxxx = str_replace('ķ','k',$xxxx);
	$xxxx = str_replace('ļ','l',$xxxx);
	$xxxx = str_replace('ž','z',$xxxx);
	$xxxx = str_replace('č','c',$xxxx);
	$xxxx = str_replace('ņ','n',$xxxx);
	$xxxx = str_replace('ñ','n',$xxxx);
	$xxxx = str_replace('ä','a',$xxxx);
	$nosaukums[] = $xxxx;
	$tvsk = $r["skaits"];
	$text.=' '.$ediens.' ('.$tvsk.'x)';
	if($q<5){
		$text.=',';
	}else{
		// $text.=' www.twitediens.tk/vardi';
	}
	$q++;
}

//dabū dienas ēdājus
$media_id = array();
$path='/home/baumuin/public_html/twitediens.tk/img/food/';

for ($i=0; $i <4 ; $i++) { 

	//Mēģināsim ielādēt 4 ēdienu attēlus
	$filename = $path.$nosaukums[$i].'.jpg';
	//Tikai tiem ēdieniem, kuriem mums ir attēli
	if(file_exists($filename) && filesize($filename) > 0){

		$connection->setApiVersion(1.1);

		$media = $connection->upload('media/upload', ['media' => $filename]);
		$media_id[] = $media->media_id_string;

		$connection->setApiVersion(2);
	}
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