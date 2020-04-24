<?php
session_start();
require_once('auth/twitteroauth/twitteroauth.php');
require_once('auth/config.php');
if($_GET['unfollow'] && $_GET['unfollow']!=''){
$access_token = $_SESSION['access_token'];
$connectionT = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
$connectionT->post('friendships/destroy', array('screen_name' => $_GET['unfollow']));
echo "<script type=\"text/javascript\">setTimeout(\"window.location = '?'\",250);</script>";
}


//kārtošana
$ord=$_GET['ord'];
$sort=$_GET['sort'];
if($sort=='')$sort='sk';
if($ord=='')$ord='desc';
if($ord=='desc'){$ord0='asc';}else if($ord=='asc'){$ord0='desc';}else{$ord0='asc';}

//Ja nav pieslēdzies, pārsūta uz pieslēgšanās lapu
if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
?>
<h2 style='margin:auto auto; text-align:center;'>Tavi Twitter draugi, kas tvītos pieminējuši ēšanu</h2>
<div style='margin:auto auto; width:151px;'>
<br/>
<a href="login"><img src="./auth/images/lighter.png" alt="Sign in with Twitter"/></a>
</div>
<?php
//Ja ir pieslēdzies
}else{
$access_token = $_SESSION['access_token'];
$connectionT = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
$usr = $connectionT->get('account/verify_credentials');
$krasa=TRUE;
echo "<table id='results' style='margin:auto auto;border-spacing:0px;border:1px solid white;'>";
echo "<tr>
<th><a href='/lapa/draugi&sort=liet&ord=".$ord0."'>Lietotājs</a></th>
<th><a href='/lapa/draugi&sort=sk&ord=".$ord0."'>Tvīti</a></th>
<th></th>
</tr>";
//dabū draugu Twitter screen name
$nextCursor = -1;
while ($nextCursor!=0){
	$content = $connectionT->get('friends/list', array('cursor' => $nextCursor));
	$nextCursor = $content->{'next_cursor_str'};
		for ($i = 0; $i < sizeof($content->{'users'}); $i++) {
			$niks =  $content->{'users'}[$i]->{'screen_name'};
			$vaards =  $content->{'users'}[$i]->{'name'};
			//Paskatās, vai datubāzē ir tvīti no konkrētā drauga
			$q = mysqli_query($connection, "SELECT created_at FROM tweets where screen_name='$niks' order by created_at desc");
			//Ja kāds tomēr ir
			$skaits = mysqli_num_rows($q);
			if($skaits>0){
				//sametam masīvā un sakārtojam masīvu
				if($sort=='sk'){
					$draugi[] = array('skaits' => $skaits, 'niks' => $niks, 'vards' => $vaards);
				}else if($sort=='liet'){
					$draugi[] = array('vards' => $vaards, 'niks' => $niks, 'skaits' => $skaits);
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
	$vaards = $draugi[$i]['vards'];
	$skaits = $draugi[$i]['skaits'];
	if ($krasa==TRUE) {$kr=" class='even'";}else{$kr="";}
	echo '<tr'.$kr.'><td><b><a style="text-decoration:none;color:#808080;" href="/draugs/'.$niks.'">'.$vaards.'</a></b> ('.$niks.')</td><td style="text-align:center">'.$skaits.'</td><td><a href="?unfollow='.$niks.'"><img title="Unfollow" alt="Unfollow" src="img/unfollow.png"/></a></td></tr>';
	$krasa=!$krasa;
}
echo "</table>";
}
?>
<br/>
<div style="margin:auto auto; text-align:center;" id="pageNavPosition"></div>
<script type="text/javascript"><!--
	var pager = new Pager('results', 15); 
	pager.init(); 
	pager.showPageNav('pager', 'pageNavPosition'); 
	pager.showPage(1);
//--></script>