<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('../config.php');
//Pieslēgums DB
include "../includes/init_sql.php";
//pieprasījums
// 1. Dārzeņi
// 2. random no atlikušajiem
// 3. tauki saldumi
// 4. dzērieni
$darze = mysqli_query($connection, "SELECT distinct nominativs FROM words WHERE grupa = 4 AND nominativs != '' AND nominativs != '0' ORDER BY RAND( ) LIMIT 1 ");
$parej = mysqli_query($connection, "SELECT distinct nominativs FROM words WHERE grupa IN(2,3,5,6) AND nominativs != '' AND nominativs != '0' ORDER BY RAND( ) LIMIT 1 ");
$saldu = mysqli_query($connection, "SELECT distinct nominativs FROM words WHERE grupa = 1 AND nominativs != '' AND nominativs != '0' ORDER BY RAND( ) LIMIT 1 ");
$dzeri = mysqli_query($connection, "SELECT distinct nominativs FROM words WHERE grupa IN(7, 8) AND nominativs != '' AND nominativs != '0' ORDER BY RAND( ) LIMIT 1 ");

global $normnos;
$da = mysqli_fetch_array($darze);
$pa = mysqli_fetch_array($parej);
$sa = mysqli_fetch_array($saldu);
$dz = mysqli_fetch_array($dzeri);
$normnos = array($da["nominativs"], $pa["nominativs"], $sa["nominativs"], $dz["nominativs"]);
$nosaukums = array(replace($da["nominativs"]), replace($pa["nominativs"]), replace($sa["nominativs"]), replace($dz["nominativs"]));

function replace($xxxx){
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
	return $xxxx;
}

require '../includes/tmhOAuth/tmhOAuth2.php';

$tmhOAuth = new tmhOAuth(array(
  'consumer_key'    => CONSUMER_KEY,
  'consumer_secret' => CONSUMER_SECRET,
  'user_token'      => OAUTH_TOKEN,
  'user_secret'     => OAUTH_SECRET,
));

$path='../img/food/';

//after request 
$media_id=array();
for ($i=0; $i <4 ; $i++) { 
	$code = $tmhOAuth->user_request(array(
	  'method' => 'POST',
	  'url'    => 'https://upload.twitter.com/1.1/media/upload.json',
	  'params' => array(
		'media' => file_get_contents($path.$nosaukums[$i].'.jpg'),
	  ),
	  'multipart' => true,
	));
     if ($code == 200) {
         $response = json_decode($tmhOAuth->response['response']);
         $media_id[] = $response->media_id_string;

     } else {
         $response->error = $tmhOAuth->response['response'];
     }


	if ($code == 200) {
	  var_dump(json_decode($tmhOAuth->response['response']));
	} else {
	  var_dump($tmhOAuth->response['response']);
	}
}

$med_ids = implode(',', $media_id);
  $code = $tmhOAuth->user_request(array(
    'method' => 'POST',
    'url'    => $tmhOAuth->url('1.1/statuses/update'),
    'params' => array(
      'media_ids' => $med_ids,
      'status'    => 'Pusdienās Tev jāēd '.$normnos[0].', '.$normnos[1].', '.$normnos[2].' un '.$normnos[3].'.',
    )
  ));


if ($code == 200) {
  var_dump(json_decode($tmhOAuth->response['response']));
} else {
  var_dump($tmhOAuth->response['response']);
}