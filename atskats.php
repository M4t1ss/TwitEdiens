<meta name="viewport" content="width=device-width, initial-scale=0.25">
<?php
session_start();
require_once('auth/twitteroauth/twitteroauth.php');
require_once('auth/config.php');
require_once('/home/baumuin/public_html/twitediens.tk/config.php');
require '/home/baumuin/public_html/foodbot/tmhOAuth/tmhOAuth2.php';
//Twitter autentificēšanās
$tmhOAuth = new tmhOAuth(array(
  'consumer_key'    => CONSUMER_KEY,
  'consumer_secret' => CONSUMER_SECRET,
  'user_token'      => OAUTH_TOKEN,
  'user_secret'     => OAUTH_SECRET,
));

//Ja nav pieslēdzies, pārsūta uz pieslēgšanās lapu
if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
?>
<h2 style='margin:auto auto; text-align:center; font-size:28px;'>Pieslēdzies, lai redzētu savu gada atskatu</h2>
<div style='margin:auto auto; width:492px;'>
<br/>
<a href="login?page=atskats"><img src="./auth/images/twitter_button.png" alt="Pieslēdzies ar Twitter"/></a>
</div>
<?php
//Ja ir pieslēdzies
}else{
$access_token = $_SESSION['access_token'];
$connectionT = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
$usr = $connectionT->get('account/verify_credentials');

$total_tweets = $usr->{'statuses_count'};
$username = $usr->{'screen_name'};
if(isset($_GET['uzr'])) $username = $_GET['uzr'];
$userpic = $usr->{'profile_image_url_https'};

/*
Izskatās, ka nevar ērti izmantot ārējus attēlus. Nekas. Saglabāsim uz servera autentificētā lietotāja attēlu un lietosim to kā lokālo...
*/
include "includes/init_sql.php";

//Tvīti kopā
$q = mysqli_query($connection, "SELECT COUNT(*) AS skaits FROM tweets where screen_name='$username'");
$kopa = 0;
if (mysqli_num_rows($q)){
	$r = mysqli_fetch_array($q);
	$kopa = $r["skaits"];
}

//Tvīti pēdējā gadā
$q = mysqli_query($connection, "SELECT COUNT(*) AS skaits FROM tweets where screen_name='$username' AND created_at between NOW() - INTERVAL 1 YEAR AND NOW()");
$gada = 0;
if (mysqli_num_rows($q)){
	$r = mysqli_fetch_array($q);
	$gada = $r["skaits"];
}

//Pieminētie lietotāji pēdējā gadā
$q = mysqli_query($connection, "SELECT COUNT(*) AS skaits FROM `mentions` where screen_name = '$username' AND date between NOW() - INTERVAL 1 YEAR AND NOW()");
$lietotaji = 0;
if (mysqli_num_rows($q)){
	$r = mysqli_fetch_array($q);
	$lietotaji = $r["skaits"];
}

//Pieminētie lietotāji pēdējā gadā
$q = mysqli_query($connection, "SELECT COUNT(*) AS count, HOUR(created_at) as hour FROM `tweets` WHERE `screen_name` LIKE '$username' GROUP BY hour ORDER BY count DESC LIMIT 1");
$stunda = -1;
if (mysqli_num_rows($q)){
	$r = mysqli_fetch_array($q);
	$stunda = $r["hour"];
}

//Pieminētākie ēdieni pēdējā gadā
$fq = mysqli_query($connection, "SELECT nominativs, COUNT(nominativs) skaits from tweets, words where tweets.screen_name = '$username' 
and words.tvits = tweets.id and nominativs != '0' and tweets.created_at between NOW() - INTERVAL 1 YEAR AND NOW() GROUP BY nominativs ORDER BY skaits DESC LIMIT 0, 5");
$i = 1;

//Pieminētākās produktu grupas ēdieni pēdējā gadā
$gq = mysqli_query($connection, "SELECT grupa, COUNT(grupa) skaits from tweets, words where tweets.screen_name = '$username' 
and words.tvits = tweets.id and grupa != '0' and tweets.created_at between NOW() - INTERVAL 1 YEAR AND NOW() GROUP BY grupa ORDER BY skaits DESC LIMIT 0, 5");
$j = 1;

$grupas=array(0,"Tauki, saldumi","Gaļa, olas, zivis","Piena produkti","Augļi, ogas","Dārzeņi",
"Maize, graudaugi, kartupeļi","Alkoholiski dzērieni","Bezalkoholiski dzērieni",);

//Pieminētākie sarunu biedri pēdējā gadā
$bq = mysqli_query($connection, "SELECT mention, count(mention) skaits FROM `mentions` where screen_name = '$username' 
AND date between NOW() - INTERVAL 1 YEAR AND NOW() GROUP BY mention ORDER BY skaits DESC LIMIT 0, 5");

//Cik daudz citē citus?
//Atrašanās vietas?
//Kuros laikos?

?>

<script type="text/javascript" src="includes/js/html2canvas.min.js"></script>
<script type="text/javascript" src="includes/js/FileSaver.js"></script>
<script type="text/javascript" src="includes/js/canvas-toBlob.js"></script>
<script type="text/javascript">
$(function() { 
    $("#btnSave").click(function() {
		$("#burger").show();
		html2canvas(document.querySelector("#capture"),{scale: 1.25}).then(canvas => {
			document.body.appendChild(canvas);
			
			// var link = document.createElement('a');
			// link.download = 'atskats.png';
			// link.href = document.body.lastChild.toDataURL()
			// document.body.appendChild(link);
			// link.click();
			
			canvas.toBlob(function(blob) {
				var newImg = document.createElement('img'), url = URL.createObjectURL(blob);

				newImg.onload = function() {
					// no longer need to read the blob so it's revoked
					URL.revokeObjectURL(url);
				};
				newImg.src = url;
				
				saveAs(url, 'atskats.png');  
			});
			$("#burger").hide();
			
			setTimeout(
				function() {
				canvas.style.display = "none";
			}, 100);
		});
    });
}); 
</script>
<button id="btnSave">Saglabāt<img id="burger" src="/img/burg.gif" style="height: 50px;margin-bottom: -15px;display: none;"></button>
<div id="capture">

<?php

$path='/img/food/';

echo "<h1 id='atheader'>".$usr->{'name'}." ".date("Y").". gada <br>ēdientvītu atskats</h1>";
echo "<img id='atprof' src='".bildite($username, $tmhOAuth)."' />";

echo "<div id='attekst'>";

echo "<p>Pēdējā gada laikā man ";
$tvii = (substr($gada, -2)!=11 && substr($gada, -1)==1)?"tvīts":"tvīti";
echo $gada==0?"nav ēdientvītu":" ir <b>".$gada." ēdien".$tvii."</b>";

echo "<br>Pēdējās desmitgades laikā ";
$reiz = (substr($kopa, -2)!=11 && substr($kopa, -1)==1)?"reizi":"reizes";
echo $kopa==0?"par ēšanu netvītoju":"par ēšanu tvītoju ".$kopa." ".$reiz;
echo "<br>Ēdientvīti sastāda <b>".(round($kopa/$total_tweets*100,2))."% no visiem</b> maniem tvītiem.<br>";

echo "Pēdējā gada laikā ";
$reiz = (substr($lietotaji, -2)!=11 && substr($lietotaji, -1)==1)?"reizi":"reizes";
echo $lietotaji==0?"nepieminēju sarunu biedrus":"sarunu biedrus pieminēju ".$lietotaji." ".$reiz;

if($stunda > -1){
	echo "<br>Visbiežāk es par ēšanu tvītoju <b>starp ".$stunda.":00 un ".($stunda+1).":00</b>";
}

//Sentiments
include "classify/evaluate_bayes.php";
$sent["neg"] = 0;
$sent["nei"] = 0;
$sent["pos"] = 0;
$latest = mysqli_query($connection, "SELECT text, emo, created_at FROM tweets where screen_name = '$username' ORDER BY created_at DESC LIMIT 0, 20");
while($p=mysqli_fetch_array($latest)){
	$emo = $p["emo"];
	$text = $p["text"];
	$ttime = $p["created_at"];
	$laiks = strtotime($ttime);
	$gads = date("Y", $laiks);
	
	if($emo != NULL && $gads > 2019){
		if($emo == -1)
			$sent["neg"] += 1;
		elseif($emo == 1)
			$sent["pos"] += 1;
		else
			$sent["nei"] += 1;
	}else{
		$automatic = classify($text);
		if($automatic == NULL) $automatic = "nei";
		$sent[$automatic] += 1;
	}
}

$maxs = array_keys($sent, max($sent));

echo "<br>Mani tvīti pārsvarā ir <b>".($maxs[0]=="pos"?"pozitīvi":($maxs[0]=="neg"?"negatīvi":"neitrāli"))."</b> noskaņoti";
echo "</p>";
echo "</div>";

echo "<div id='topedieni'>";
$bildes = "";
if (mysqli_num_rows($fq)){
	while($r=mysqli_fetch_array($fq)){
		$nomi = $r["nominativs"];
		$skai = $r["skaits"];
		echo $i++.". ".$nomi." (".$skai."x)<br>";
		$bpath = $path.replace($nomi).".jpg";
		$bildes .= "<div class='fooddiv'><img class='foodimg' src='$bpath' /></div>";
	}
}
echo "</div>";

echo "<div id='topgrupas'>";
if (mysqli_num_rows($gq)){
	while($r=mysqli_fetch_array($gq)){
		$nomi = $grupas[$r["grupa"]];
		$skai = $r["skaits"];
		echo $j++.". ".$nomi." (".$skai."x)<br>";
	}
}
echo "</div>";

echo "<br style='clear:both;'>";

echo "<div style='margin-left: 10px;'>";
echo $bildes;
echo "</div>";

echo "<br style='clear:both;'>";

echo "<div style='margin-left: 10px;'>";
echo "<h2>Sarunu biedri</h2>";
if (mysqli_num_rows($bq)){
	while($r=mysqli_fetch_array($bq)){
		$ment = $r["mention"];
		$bpath = bildite($ment, $tmhOAuth);
		echo "<div class='fooddiv'><img class='foodimg' src='$bpath' /></div>";
	}
}
echo "</div>";


echo "<br style='clear:both;'>";

echo "<div style='font-size:28px; text-align: center; margin-top: 20px;'>";
echo "Apskati savu ēdientvītu gada atskatu - tvitediens.tk/atskats";
echo "</div>";


echo "<br style='clear:both;'>";

echo "<div style='font-size:28px; text-align: center; '>";
echo '<h1>
		<img src="/img/TwitEdiensLogo.png" style="height:120px; margin-bottom:-30px; padding-right:15px;">
		Twitēdiens
		<img src="/img/qr.png" style="height:150px; margin-bottom:-50px; padding-left:15px;">
	</h1>';
echo "</div>";

?>
</div>
<img id="captured" />
<?php
}

function bildite($usrn, $tmhOAuth){
	$path = "/home/baumuin/public_html/twitediens.tk/auth/images/";
	
	$filename = $path.$usrn.".jpg";
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
		file_put_contents($filename, file_get_contents_curl($profpic));
		return "/auth/images/".$usrn.".jpg";
	}else{
		return "/img/twitter_egg_blue.png";
	}
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

function replace($word){
		$word = str_replace('ē','e',$word);
		$word = str_replace('ū','u',$word);
		$word = str_replace('ī','i',$word);
		$word = str_replace('ā','a',$word);
		$word = str_replace('š','s',$word);
		$word = str_replace('ģ','g',$word);
		$word = str_replace('ķ','k',$word);
		$word = str_replace('ļ','l',$word);
		$word = str_replace('ž','z',$word);
		$word = str_replace('č','c',$word);
		$word = str_replace('ņ','n',$word);
		$word = str_replace('ñ','n',$word);
		$word = str_replace('ä','a',$word);
		return $word;
}