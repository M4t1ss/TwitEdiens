<?php
include "includes/init_sql.php";
include "classify/evaluate_bayes.php";
?>
<div style="margin:30px; background-color:#E7FFFE;background-opacity:0.2;border-radius:15px;padding:15px;border:2px solid #FFF;">
	TwitĒdiens ievāc datus no <a style="font-weight:bold;" href="http://twitter.com">Twitter</a>
	- visus tvītus, kur kaut kas minēts par ēšanu, dzeršanu (apēdu, izdzēru, ...)
	ēdienreizēm (pusdienas, brokastis, vakariņas, ...) vai ēdieniem, dzērieniem 
	(tēja, šokolāde, kafija, gaļa, saldējums, pankūka, kartupeļi, kūka, pelmeņi, ...).
	Šos datus sakārto, noformē un analizē dažādos griezumos. 
	Šajā tīmekļa vietnē iespējams apskatīt šo analīžu rezultātus. 
	<a href="/par" style="text-decoration:underline">Vairāk par TwitĒdienu</a><br/><br/>
	<a href="#" id="example-show" class="showLink" 
	onclick="showHide('example');return false;">Sazinies ar autoru</a>
	<div id="example" class="more">
		<form id="forma" action="MAILTO:twitediens@lielakeda.lv" method="post" enctype="text/plain">
		<div><input type="text" name="name" value="Tavs vārds"/><br/></div>
		<div><input type="text" name="mail" value="E-pasts"/><br/></div>
		<div><input type="text" name="comment" value="Ziņojums"/><br/></div>
		<div><input type="submit" value="Sūtīt"/></div>
	</form>
	<a href="#" id="example-hide" class="hideLink" 
	onclick="showHide('example');return false;">Paslēpt</a>
	</div>
</div>

<h2 style='margin:auto auto; text-align:center;'>Jaunākie tvīti un attēli no tvītiem</h2>
<p style='margin:auto auto; text-align:center;font-size:0.8em;'>(reālā laikā)</p>
<script type="text/javascript">
var isOpera = !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
    // Opera 8.0+ (UA detection to detect Blink/v8-powered Opera)
var isFirefox = typeof InstallTrigger !== 'undefined';   // Firefox 1.0+
var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
    // At least Safari 3+: "[object HTMLElementConstructor]"
var isChrome = !!window.chrome && !isOpera;              // Chrome 1+
var isIE = /*@cc_on!@*/false || !!document.documentMode;   // At least IE6

$(function() {
	setInterval(function() {
		$("#content").load(location.href+" #content>*","");
	}, 1500);
	if(!isOpera && !isChrome){
		setInterval(function() {
			$("#content2").load(location.href+" #content2>*","");
		}, 5000);
	}
}
);
</script>
<?php
//dabū 10 jaunākos tvītus
$latest = mysqli_query($connection, "SELECT * FROM tweets ORDER BY created_at DESC limit 0, 10");
?>

<div id="content">
<?php
while($p=mysqli_fetch_array($latest)){
	$username = $p["screen_name"];
	$text = $p["text"];
	$ttime = $p["created_at"];
		
	$automatic = classify($text);
	switch ($automatic){
		case "pos":
			$color = "#00FF00";
			break;
		case "neg":
			$color = "#FF3D3D";
			break;
		case "nei":
			$color = "black";
			break;
		default:
			$color = "black";
	}
	
	#Iekrāso un izveido saiti uz katru pieminēto lietotāju tekstā
	#Šo vajadzētu visur...
	$matches = array();
	if (preg_match_all('/@[^[:space:]]+/', $text, $matches)) {
		foreach ($matches[0] as $match){
			$text = str_replace(trim($match), '<a style="text-decoration:none;color:#658304;" href="/draugs/'.str_replace('@','',trim($match)).'">'.trim($match).'</a> ', $text);
		}
	}
	
	if (preg_match_all('/http[^[:space:]]+/', $text, $matches)) {
		foreach ($matches[0] as $match){
			$text = str_replace(trim($match), '<a style="text-decoration:none;color:#658304;" target="_blank" href="'.trim($match).'">'.trim($match).'</a> ', $text);
		}
	}
	
?>
<div style="<?php if ((time()-StrToTime($ttime))<5){echo"opacity:".((time()-StrToTime($ttime))/5).";";}?>" class="tweet">
<div class="lietotajs" style="border-bottom: 0.18em dashed <?php echo $color; ?>;"><?php echo '<a style="text-decoration:none;color:#658304;" href="/draugs/'.trim($username).'">@'.trim($username).'</a> ';?> ( <?php echo $ttime;?> )</div>
<?php echo $text."<br/>";
?><br/>
</div>
<?php
}
?>
</div>
<?php
//dabū 10 jaunākos tvītus
$latest = mysqli_query($connection, "SELECT distinct media_url, expanded_url, date, text FROM media JOIN tweets ON tweets.id = media.tweet_id GROUP BY media_url ORDER BY date DESC limit 0, 40");
?>

<div id="content2">
<section id="photos">
<?php
	while($p=mysqli_fetch_array($latest)){
		$media_url = $p["media_url"];
		$expanded_url = $p["expanded_url"];
		$ttime = $p["date"];
		$ttext = $p["text"];
		
		if (@getimagesize($media_url)) {
			?>
			<div style="<?php if ((time()-StrToTime($ttime))<5){echo"opacity:".((time()-StrToTime($ttime))/5).";";}?> display:inline;" >
				<a target="_blank" href="<?php echo $expanded_url; ?>">
					<img alt="<?php echo $ttext;?>" src="<?php echo $media_url; ?>" />
				</a>
			</div>
			<?php
		}else{
			//Delete this one - probably doesn't exist anymore...
		}
	}
?>
</section>
</div>