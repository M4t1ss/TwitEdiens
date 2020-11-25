<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

//Sentimenta marķēšanas grafiskā saskarne tvītiem
//Pieslēgums DB
include "includes/init_sql_latest.php";
include "classify/evaluate_bayes.php";

if(isset($_POST['nei'])){
	$id = $_POST['id'];
	$result= mysqli_query($connection, "UPDATE tweets set emo = 0 where id = '$id'"); 
}
if(isset($_POST['poz'])){
	$id = $_POST['id'];
	$result= mysqli_query($connection, "UPDATE tweets set emo = 1 where id = '$id'"); 
}
if(isset($_POST['neg'])){
	$id = $_POST['id'];
	$result= mysqli_query($connection, "UPDATE tweets set emo = -1 where id = '$id'"); 
}
if(isset($_POST["TTS"]) && $_POST["TTS"]=="Izrunāt") 
	$TTS = true;
else
	$TTS = false;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="lv" lang="lv">
<head>
<title>TwitĒdiens - sentimenta marķēšana</title>
<meta name="viewport" content="width=320, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link href="/includes/apple-touch-icon.png" rel="apple-touch-icon" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<script type="text/javascript" src="/includes/sorttable.js"></script>
<script type="text/javascript" src="/includes/paging.js"></script>
<link rel="stylesheet" type="text/css" href="/includes/jq/css/custom-theme/jquery-ui-1.8.16.custom.css" />	
<link rel="stylesheet" type="text/css" href="/includes/style.css" />
<link rel="stylesheet" type="text/css" href="/includes/print.css" media="print"/>
<script type="text/javascript" src="/includes/jq/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="/includes/jq/js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript">
	$(document).ready(function () {
		$("#contents").fadeIn(1000);
	});
	function showHide(shID) {
		if (document.getElementById(shID)) {
			if (document.getElementById(shID+'-show').style.display != 'none') {
				document.getElementById(shID+'-show').style.display = 'none';
				document.getElementById(shID).style.display = 'block';
			}
			else {
				document.getElementById(shID+'-show').style.display = 'inline';
				document.getElementById(shID).style.display = 'none';
			}
		}
	}
</script>
</head>
<body onload="initialize()">
<h1 style="padding-top:3px;"><a href="/"><img alt="TwitĒdiens Logo" src="/img/te.png" style="height:40px;" /></a> Sentimenta marķēšana</h1>
<div id="contents" style="display: none;margin-top:10px;margin-bottom:10px;padding:6px;text-align:center; min-height:200px;">
	<?php
		//Pelēkais saraksts ar ziņu u.c. kontiem, kuriem pārsvarā tvīti ir neitrāli
		$trashy_acc = array('epadomi', 'laiki', 'brevings', 'Twitediens', 'RIGATV24', 'FOLKKLUBS', 'brooklynpubriga', 'ltvzinas', 'RestoransChat'
			, 'beerhouseNo1', 'EgilsDambis1', 'Skrundas_novads', 'dievietelv', 'flowsnet_com', 'cafeleningrad', 'gardedis_lv', 'CafeOsiris', 'VidzAugstskola'
			, 'portals_santa', 'JaunsLV', 'KJ_Sievietem', 'Kalnciemaiela', '1188', 'budzis', 'LV_portals', 'lsmlv', 'LA_lv', 'nralv', '8Lounge1'
			, 'SakuraSushiBars', 'visidarbi', 'LifeHackslv', 'irLV', 'LIIA_LV', 'receptes_eu', 'latvijasbizness', 'shmaramagda', 'integreta_bibl');
			
		//Paņem jaunāko vēl nemarķēto tvītu, kura autors nav pelēkajā sarakstā
		$latest = mysqli_query($connection, "SELECT * FROM tweets WHERE emo IS NULL AND screen_name NOT IN ( '" . implode( "', '" , $trashy_acc ) . "' ) ORDER BY created_at DESC limit 0, 1");
		$p = mysqli_fetch_array($latest);
		
		$id = $p["id"];
		$username = $p["screen_name"];
		$text = $p["text"];
		$ttime = $p["created_at"];
		
		$automatic = classify($text);
		
		$regex = "@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?).*$)@";
		$forTTS = preg_replace($regex, ' ', $text);
		
		//Marķēšanas statistika
		$tot = mysqli_query($connection, "SELECT COUNT(*) sk FROM tweets WHERE emo IS NULL");
		$neg = mysqli_query($connection, "SELECT COUNT(*) sk FROM tweets WHERE emo = -1");
		$nei = mysqli_query($connection, "SELECT COUNT(*) sk FROM tweets WHERE emo = 0");
		$poz = mysqli_query($connection, "SELECT COUNT(*) sk FROM tweets WHERE emo = 1");
		
		$ptot = mysqli_fetch_array($tot);
		$pneg = mysqli_fetch_array($neg);
		$pnei = mysqli_fetch_array($nei);
		$ppoz = mysqli_fetch_array($poz);
		
		$total 		= $ptot['sk'];
		$negative 	= $pneg['sk'];
		$neutral 	= $pnei['sk'];
		$positive 	= $ppoz['sk'];
		$annotated 	= $negative + $neutral + $positive;
		$useful		= min($negative, $positive) * 3;
		
		# Iekrāsosim pozitīvos un negatīvos vārdus
		$filename = "classify/lv_positive_words_from_pumpurs";
		$fp = @fopen($filename, 'r');
		if ($fp) {
		   $pwords = explode("\n", fread($fp, filesize($filename)));
		}
		$filename = "classify/lv_positive_words_from_pumpurs";
		$fp = @fopen($filename, 'r');
		if ($fp) {
		   $nwords = explode("\n", fread($fp, filesize($filename)));
		}
		
		$words = explode(" ", preg_replace("/(?![.=$'€%-])\p{P}/u", "", $text));
		$color_text = "";
		foreach($words as $word){
			if(in_array(strtolower($word), $pwords)){
				// $word = "<span style='color:green'>".$word."</span>";
				$text = preg_replace('/'.preg_quote($word, '/').'/', "<span style='color:#00CC00;font-weight:bold;'>".$word."</span>", $text, 1);
			}else if(in_array(strtolower($word), $nwords)){
				// $word = "<span style='color:red'>".$word."</span>";
				$text = preg_replace('/'.preg_quote($word, '/').'/', "<span style='color:#FF0000;font-weight:bold;'>".$word."</span>", $text, 1);
			}
			$color_text .= $word." ";
		}
		
		#Iekrāso un izveido saiti uz katru pieminēto lietotāju tekstā
		#Šo vajadzētu visur...
		$matches = array();
		if (preg_match_all('/@[^[:space:]]+/', $text, $matches)) {
			foreach ($matches[0] as $match){
				$text = str_replace(trim($match), '<a style="text-decoration:none;color:#658304;" href="/draugs/'.str_replace('@','',trim($match)).'">'.trim($match).'</a> ', $text);
				$forTTS = str_replace(trim($match), '', $forTTS);
			}
		}
		
		if (preg_match_all('/http[^[:space:]]+/', $text, $matches)) {
			foreach ($matches[0] as $match){
				$text = str_replace(trim($match), '<a style="text-decoration:none;color:#658304;" target="_blank" href="'.trim($match).'">'.trim($match).'</a> ', $text);
			}
		}
		
	?>
	<form method="post" action="mark.php">
	<input class="TTS" type="checkbox" id="TTS" name="TTS" value="Izrunāt" <?php if($TTS) echo "checked"; ?>> 
	<label class="TTS" for="TTS">Izrunāt?</label>
	<audio class="audioPlayer" controls autoplay>
		<?php if($TTS){ ?>
	  <source src="https://runa.tilde.lv/client/say/?text=<?php echo urlencode($forTTS);?>&voice=e2e" type="audio/mpeg">
	  Your browser does not support the audio element.
		<?php } ?>
	</audio>
	<div style="max-width:750px; margin:auto auto; text-align:center;<?php if ((time()-StrToTime($ttime))<5){echo"opacity:".((time()-StrToTime($ttime))/5).";";}?>" class="tweet">
	<div class="lietotajs"><?php echo '<a style="text-decoration:none;color:#658304;" href="/draugs/'.trim($username).'">@'.trim($username).'</a> ';?> ( <?php echo $ttime;?> )</div>
	<div style="padding-top:10px;"><?php echo $text; ?><br/></div>
	<br/>
		<input type="hidden" value="<?php echo $id;?>" name="id"/>
		<input TYPE="submit" name="neg" class="senti neg" <?php echo $automatic=="neg"?"style='border:3px dashed #AC00E6'":"style='border:3px solid red'"; ?> type="button" value="Negatīvs" />
		<input TYPE="submit" name="nei" class="senti nei" <?php echo $automatic=="nei"?"style='border:3px dashed #AC00E6'":"style='border:3px solid gray'"; ?> type="button" value="Neitrāls" />
		<input TYPE="submit" name="poz" class="senti poz" <?php echo $automatic=="pos"?"style='border:3px dashed #AC00E6'":"style='border:3px solid green'"; ?> type="button" value="Pozitīvs" />
	</form>
	</div>
	<br class="clear" />
</div>
<div id="bottom" style="padding:8px;">
<div style="text-align:center;">
	Nemarķēti: <?php echo $total; ?><br/>
	Negatīvie: <?php echo $negative; ?><br/>
	Neitrālie: <?php echo $neutral; ?><br/>
	Pozitīvie: <?php echo $positive; ?><br/>
	Marķēti: <?php echo $annotated; ?><br/>
	Noderīgi: <?php echo $useful; ?><br/>
</div>
</div>
</body>
</html>