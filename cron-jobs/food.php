<?php
header('Content-Type: text/html; charset=utf-8');
require_once('../config.php');
//Pieslēgums DB
include "../includes/init_sql.php";
//Twitter autentificēšanās
require_once('twitteroauth/twitteroauth.php');
$twitter_connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_SECRET);
$content = $twitter_connection->get('account/verify_credentials');

$text = 'Šodienas dižēdāji ir';

//Sevi un ziņu portālus neslavināsim :)
$blacklist = array(
    'laiki', 'epadomi', 'edienbots', 'gardedis_lv', 
    'StilaparksLv', 'ifaktors', 'nralv', 'DelfiLV', 'Twitediens'
);

//dabū dienas ēdājus
$q = 1;
$vardi = mysqli_query($connection, "SELECT distinct screen_name, count(screen_name) skaits FROM tweets where screen_name NOT IN ('".implode("','",$blacklist)."') AND created_at between now( ) - INTERVAL 24 HOUR and now( ) group by screen_name order by skaits desc limit 0, 5");
while($r=mysqli_fetch_array($vardi)){
	$usrn = $r["screen_name"];
	$tvsk = $r["skaits"];
	$text.=' @'.$usrn.' ('.$tvsk.'x)';
	if($q<5){$text.=',';}else{
		if(strlen($text)<127) $text.=' www.twitediens.ml';
	}
	$q++;
}

//ziņas publicēšana
$twitter_connection->post('statuses/update', array('status' => $text));
?>