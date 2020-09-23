<?php
header('Content-Type: text/html; charset=utf-8');
require_once('../config.php');
//Pieslēgums DB
include "../includes/init_sql.php";

$text = 'Šīs dienas tvītotākie produkti ir';

//dabū dienas produktus
$q = 1;
$vardi = mysqli_query($connection, "SELECT DISTINCT ss.nominativs, count(ss.nominativs) skaits FROM(
    SELECT distinct words.tvits, words.nominativs
    FROM words, tweets 
    WHERE tweets.id = words.tvits 
    and tweets.created_at BETWEEN now( ) - INTERVAL 48 HOUR AND now( ) - INTERVAL 24 HOUR
    and words.irediens = 1 
    group by words.tvits
) ss
group by ss.nominativs
order by skaits desc limit 0, 5");
while($r=mysqli_fetch_array($vardi)){
	$usrn = $r["nominativs"];
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
	$text.=' '.$usrn.' ('.$tvsk.'x)';
	if($q<5){
		$text.=',';
	}else{
		$text.=' www.twitediens.tk/vardi';
	}
	$q++;
}


//Twitter autentificēšanās
require '/home/baumuin/public_html/foodbot/tmhOAuth/tmhOAuth2.php';
$tmhOAuth = new tmhOAuth(array(
  'consumer_key'    => CONSUMER_KEY,
  'consumer_secret' => CONSUMER_SECRET,
  'user_token'      => OAUTH_TOKEN,
  'user_secret'     => OAUTH_SECRET,
));

$path='/home/baumuin/public_html/twitediens.tk/img/food/';

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