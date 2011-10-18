<?php
session_start();
require_once('auth/twitteroauth/twitteroauth.php');
require_once('auth/config.php');

//Ja nav pieslēdzies, pārsūta uz pieslēgšanās lapu
if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
?>
<h1 style='margin:auto auto; text-align:center;'>Tavi Twitter draugi, kas tvītos pieminējuši ēšanu</h1>
<div style='margin:auto auto; width:151px;'>
<br/>
<a href="./auth/redirect.php"><img src="./auth/images/lighter.png" alt="Sign in with Twitter"/></a>
</div>
<?php
}else{
$access_token = $_SESSION['access_token'];
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
$usr = $connection->get('account/verify_credentials');
?>
<div style='float:right;margin-top:-22px'>Sveiki, <?php echo $usr->{'name'}?> [<a style='text-decoration:none; color:grey;' href="auth/clearsessions.php">Iziet</a>]</div><br/>
<?php
$krasa=TRUE;
echo "<table class='sortable' style='margin:auto auto;'>";
echo "<tr>
<th>Lietotājs</th>
<th>Tvīts</th>
<th style='width:135px;'>Laiks</th>
</tr>";
//dabū draugu Twitter screen name
$nextCursor = -1;
while ($nextCursor!=0){
	$content = $connection->get('statuses/friends', array('cursor' => $nextCursor));
	$nextCursor = $content->{'next_cursor_str'};
		for ($i = 0; $i < sizeof($content->{'users'}); $i++) {
			$niks =  $content->{'users'}[$i]->{'screen_name'};
			//Paskatās, vai datubāzē ir tvīti no konkrētā drauga
			$q = mysql_query("SELECT text, created_at FROM tweets where screen_name='$niks' order by created_at desc");
			while($r=mysql_fetch_array($q)){
				if ($krasa==TRUE) {$kr=" style='background-color:#E0E0E0'";}else{$kr="";}
				$teksts=$r["text"];
				$laiks=$r["created_at"];
				$laiks=strtotime($laiks);
				$laiks=date("m.d.Y H:i", $laiks);
				echo "<tr".$kr."><td><b><a style='text-decoration:none;color:#658304;' href='https://twitter.com/#!/".$niks."'>".$niks."</a></b></td><td>".$teksts."</td><td>".$laiks."</td></tr>";
				$krasa=!$krasa;
			}
		}
}
echo "</table>";
}
?>