<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="lv" lang="lv">
<head>
<title>TwitEdiens</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<style type="text/css">
  img {border-width: 0}
  * {font-family:'Lucida Grande', sans-serif;}
</style>
</head>
<body>
<h1>Tavi Twitter draugi, kas tvītos pieminējuši ēšanu</h1>
<?php
require_once('auth/twitteroauth/twitteroauth.php');
require_once('auth/config.php');

//Pieslēgums DB
include "init_sql.php";

//Ja nav pieslēdzies, pārsūta uz pieslēgšanās lapu
if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
	?>
	<a href="./auth/redirect.php"><img src="./auth/images/lighter.png" alt="Sign in with Twitter"/></a>
	<?php
}else{
?>
<a href="auth/clearsessions.php">Iziet</a><br/>
<?php
}
$access_token = $_SESSION['access_token'];
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

//dabū draugu Twitter screen name
$nextCursor = -1;
while ($nextCursor!=0){
	$content = $connection->get('statuses/friends', array('cursor' => $nextCursor));
	$nextCursor = $content->{'next_cursor_str'};
		for ($i = 0; $i < sizeof($content->{'users'}); $i++) {
			$niks =  $content->{'users'}[$i]->{'screen_name'};
			//Paskatās, vai datubāzē ir tvīti no konkrētā drauga
			$q = mysql_query("SELECT text FROM tweets where screen_name='$niks'");
			while($r=mysql_fetch_array($q)){
				$teksts=$r["text"];
				echo "<b>".$niks."</b>: ".$teksts."<br/>";
			}
			
		}

}
?>
</body>
</html>