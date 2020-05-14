<?php
//Sentimenta marķēšanas grafiskā saskarne tvītiem
//Pieslēgums DB
include "includes/init_sql_latest.php";

if($_POST['nei']){
	$id = $_POST['id'];
	$result= mysqli_query($connection, "UPDATE tweets set emo = 0 where id = '$id'"); 
}
if($_POST['poz']){
	$id = $_POST['id'];
	$result= mysqli_query($connection, "UPDATE tweets set emo = 1 where id = '$id'"); 
}
if($_POST['neg']){
	$id = $_POST['id'];
	$result= mysqli_query($connection, "UPDATE tweets set emo = -1 where id = '$id'"); 
}

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
<h1 style="padding-top:3px;"><img alt="TwitĒdiens Logo" src="/img/te.png" style="height:40px;" /> Sentimenta marķēšana</h1>
<div id="contents" style="display: none;margin-top:10px;margin-bottom:10px;padding:6px;text-align:center; min-height:200px;">
	<?php
		//Pelēkais saraksts ar ziņu u.c. kontiem, kuriem pārsvarā tvīti ir neitrāli
		$trashy_acc = array('epadomi', 'laiki', 'brevings', 'Twitediens', 'RIGATV24', 'FOLKKLUBS', 'brooklynpubriga', 'ltvzinas'
			, 'beerhouseNo1', 'EgilsDambis1', 'Skrundas_novads', 'dievietelv', 'flowsnet_com', 'cafeleningrad', 'gardedis_lv', 'CafeOsiris'
			, 'portals_santa', 'JaunsLV', 'KJ_Sievietem', 'Kalnciemaiela', '1188', 'budzis', 'LV_portals', 'lsmlv', 'LA_lv', 'nralv'
			, 'SakuraSushiBars', 'visidarbi', 'LifeHackslv', 'irLV', 'LIIA_LV', 'receptes_eu', 'latvijasbizness');
			
		//Paņem jaunāko vēl nemarķēto tvītu, kura autors nav pelēkajā sarakstā
		$latest = mysqli_query($connection, "SELECT * FROM tweets WHERE emo IS NULL AND screen_name NOT IN ( '" . implode( "', '" , $trashy_acc ) . "' ) ORDER BY created_at DESC limit 0, 1");
		$p = mysqli_fetch_array($latest);
		
		$id = $p["id"];
		$username = $p["screen_name"];
		$text = $p["text"];
		$ttime = $p["created_at"];
		
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
		
		$id = $p["id"];
		
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
	<div style="max-width:750px; margin:auto auto; text-align:center;<?php if ((time()-StrToTime($ttime))<5){echo"opacity:".((time()-StrToTime($ttime))/5).";";}?>" class="tweet">
	<div class="lietotajs"><?php echo '<a style="text-decoration:none;color:#658304;" href="/draugs/'.trim($username).'">@'.trim($username).'</a> ';?> ( <?php echo $ttime;?> )</div>
	<div style="padding-top:10px;"><?php echo $text; ?><br/></div>
	<br/>
	<form method="post" action="mark.php">
		<input type="hidden" value="<?php echo $id;?>" name="id"/>
		<input TYPE="submit" name="neg" class="senti neg" type="button" value="Negatīvs" />
		<input TYPE="submit" name="nei" class="senti nei" type="button" value="Neitrāls" />
		<input TYPE="submit" name="poz" class="senti poz" type="button" value="Pozitīvs" />
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