<?php
session_start();
require_once('auth/twitteroauth/twitteroauth.php');
require_once('auth/config.php');

//kārtošana
$ord=$_GET['ord'];
$sort=$_GET['sort'];
if($sort=='')$sort='sk';
if($ord=='')$ord='desc';
if($ord=='desc'){$ord0='asc';}else if($ord=='asc'){$ord0='desc';}else{$ord0='asc';}

//Ja nav pieslēdzies, pārsūta uz pieslēgšanās lapu
if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
?>
<h1 style='margin:auto auto; text-align:center;'>Tavi Twitter draugi, kas tvītos pieminējuši ēšanu</h1>
<div style='margin:auto auto; width:151px;'>
<br/>
<a href="./auth/redirect.php"><img src="./auth/images/lighter.png" alt="Sign in with Twitter"/></a>
</div>
<?php
//Ja ir pieslēdzies
}else{
$access_token = $_SESSION['access_token'];
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
$usr = $connection->get('account/verify_credentials');
?>
<div style='float:right;margin-top:-22px'>Sveiki, <?php echo $usr->{'name'}?> [<a style='text-decoration:none; color:grey;' href="auth/clearsessions.php">Iziet</a>]</div><br/>
<?php
$krasa=TRUE;
echo "<table id='results' style='margin:auto auto;'>";
echo "<tr>
<th><a href='?id=draugi&sort=liet&ord=".$ord0."'>Lietotājs</a></th>
<th><a href='?id=draugi&sort=sk&ord=".$ord0."'>Tvītu skaits</a></th>
</tr>";
//dabū draugu Twitter screen name
$nextCursor = -1;
while ($nextCursor!=0){
	$content = $connection->get('statuses/friends', array('cursor' => $nextCursor));
	$nextCursor = $content->{'next_cursor_str'};
		for ($i = 0; $i < sizeof($content->{'users'}); $i++) {
			$niks =  $content->{'users'}[$i]->{'screen_name'};
			//Paskatās, vai datubāzē ir tvīti no konkrētā drauga
			$q = mysql_query("SELECT created_at FROM tweets where screen_name='$niks' order by created_at desc");
			//Ja kāds tomēr ir
			$skaits = mysql_num_rows($q);
			if($skaits>0){
				//sametam masīvā un sakārtojam masīvu
				if($sort=='sk'){
					$draugi[] = array('skaits' => $skaits, 'niks' => $niks);
				}else if($sort=='liet'){
					$draugi[] = array('niks' => $niks, 'skaits' => $skaits);
				}
			}
		}
}
//pārkārtojam masīvu
if ($ord=='desc'){
array_multisort($draugi, SORT_DESC);
}else if ($ord=='asc'){
array_multisort($draugi, SORT_ASC);
}
for($i=0;$i<sizeof($draugi);$i++){
	$niks = $draugi[$i]['niks'];
	$skaits = $draugi[$i]['skaits'];
	if ($krasa==TRUE) {$kr=" style='background-color:#E0E0E0'";}else{$kr="";}
	echo '<tr'.$kr.'><td><b><a style="text-decoration:none;color:#658304;" href="?id=draugs&dra='.$niks.'">'.$niks.'</a></b></td><td>'.$skaits.'</td></tr>';
	$krasa=!$krasa;
}
echo "</table>";
}
?>
<div style="margin:auto auto; text-align:center;" id="pageNavPosition"></div>
<script type="text/javascript"><!--
	var pager = new Pager('results', 15); 
	pager.init(); 
	pager.showPageNav('pager', 'pageNavPosition'); 
	pager.showPage(1);
//--></script>