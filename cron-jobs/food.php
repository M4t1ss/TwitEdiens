<?php
header('Content-Type: text/html; charset=utf-8');
require_once('../config.php');
//Pieslēgums DB
include "../includes/init_sql.php";
//Twitter autentificēšanās
require '../includes/tmhOAuth2.php';
$tmhOAuth = new tmhOAuth(array(
  'consumer_key'    => CONSUMER_KEY,
  'consumer_secret' => CONSUMER_SECRET,
  'user_token'      => OAUTH_TOKEN,
  'user_secret'     => OAUTH_SECRET,
));

$text = 'Šodienas dižēdāji ir';

//Sevi un ziņu portālus neslavināsim :)
$blacklist = array(
    'laiki', 'epadomi', 'edienbots', 'gardedis_lv', 'LA_lv', 'JaunsLV', 'FOLKKLUBS', 'ltvzinas', 'integreta_bibl', 'receptes_eu', 'TautaRuna', 'zinicenu', 
    'StilaparksLv', 'ifaktors', 'nralv', 'DelfiLV', 'Twitediens', 'budzis', 'cafeleningrad', '8Lounge1', 'VidzAugstskola', 'IntaMolodcova', 'GalasServiss'
);
//Šie konti ir priduraki - tos noteikti @nepieminēt :)
$priduraki = array(
    'tvitermaniaks', 'SievieteR', 'cepum_s', 'ZPupola', 'atheist_from_lv', 'sku_dra'
);

//dabū dienas ēdājus
$media_id = array();
$path = "/images/";
$q = 1;
$i = 0;
$vardi = mysqli_query($connection, "SELECT distinct screen_name, count(screen_name) skaits FROM tweets where screen_name NOT IN ('".implode("','",$blacklist)."') AND created_at between now( ) - INTERVAL 24 HOUR and now( ) group by screen_name order by skaits desc limit 0, 5");
while($r=mysqli_fetch_array($vardi)){
	$usrn = $r["screen_name"];
	$tvsk = $r["skaits"];
	
	//Mēģināsim ielādēt 4 profila attēlus
	if($i < 4){
		$filename = $path.$usrn.".jpg";
		//Tikai tiem lietotājiem, kuriem mums vēl nav salgabāti attēli
		if(!file_exists($filename) || filesize($filename) == 0){
			$code = $tmhOAuth->user_request(array(
				'method' => 'GET',
				'url'    => $tmhOAuth->url('1.1/users/show'),
				'params' => array(
				  'screen_name'    => $usrn,
				)
			));
			if ($code == 200) {
				$resp = json_decode($tmhOAuth->response['response']);
				$profpic = $resp->profile_image_url_https;
				$profpic = str_replace("normal","400x400",$profpic);
			}
			file_put_contents($filename, file_get_contents_curl($profpic));
		}
		
		$code = $tmhOAuth->user_request(array(
		  'method' => 'POST',
		  'url'    => 'https://upload.twitter.com/1.1/media/upload.json',
		  'params' => array(
			'media' => file_get_contents($path.$usrn.'.jpg'),
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

//ziņas publicēšana
$med_ids = implode(',', $media_id);
var_dump($med_ids);
  $code = $tmhOAuth->user_request(array(
    'method' => 'POST',
    'url'    => $tmhOAuth->url('1.1/statuses/update'),
    'params' => array(
      'media_ids' => $med_ids,
      'status'    => $text,
    )
  ));


if ($code == 200) {
  var_dump(json_decode($tmhOAuth->response['response']));
} else {
  var_dump($tmhOAuth->response['response']);
}

function file_get_contents_curl($url) { 
    $ch = curl_init(); 
  
    curl_setopt($ch, CURLOPT_HEADER, 0); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_URL, $url); 
  
    $data = curl_exec($ch); 
    curl_close($ch); 
  
    return $data; 
} 

?>