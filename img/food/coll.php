<?php
//pieslēdzamies vietējam SQL serverim
$db_server = "mysql:3306";
$db_database = "baumuin_food";
$db_user = "baumuin_bauma";
$db_password = "{GIwlpQ<?3>g";
//pieslēdzamies SQL serverim
$connection = @mysql_connect($db_server, $db_user, $db_password);
mysql_set_charset("utf8", $connection);
mysql_select_db($db_database);
//pieprasījums
$vardi = mysql_query("SELECT distinct nominativs FROM words WHERE nominativs != '' AND nominativs != '0' ORDER BY RAND( ) LIMIT 4 ");
while($r=mysql_fetch_array($vardi)){
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
}
$collageSpec = array();
$collageSpec['height'] = 400;
$collageSpec['width'] = 400;
$collageSpec['images'] = array(
	array(
		'url' => 'http://twitediens.tk/img/food/'.$nosaukums[0].'.jpg',
		'x' => 0,
		'y' => 0,
		'width' => 200,
		'height' => 200,
	),
	array(
		'url' => 'http://twitediens.tk/img/food/'.$nosaukums[1].'.jpg',
		'x' => 200,
		'y' => 0,
		'width' => 200,
		'height' => 200,
	),
	array(
		'url' => 'http://twitediens.tk/img/food/'.$nosaukums[2].'.jpg',
		'x' => 200,
		'y' => 200,
		'width' => 200,
		'height' => 200,
	),
	array(
		'url' => 'http://twitediens.tk/img/food/'.$nosaukums[3].'.jpg',
		'x' => 0,
		'y' => 200,
		'width' => 200,
		'height' => 200,
	),
);

$json = json_encode($collageSpec);

$ch = curl_init('http://collageapi.congolabs.com/create_collage.json');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

header('Content-Type: image/jpeg');
curl_exec($ch);

curl_close($ch);

?>