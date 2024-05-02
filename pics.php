<?php

ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ERROR);

//Attēlu marķēšanas grafiskā saskarne tvītiem
//Pieslēgums DB
include "includes/init_sql.php";
include "includes/functions.php";
include "includes/words.php";
include "classify/evaluate_bayes.php";
include "includes/blacklist.php";

/*

Classification similar to the paper "Categorizing and Inferring the Relationship between the Text and Image of Twitter Posts"
https://aclanthology.org/P19-1272/

Relation:

	0 - The image ADDS to tweet meaning and tweet text IS represented in the image
	1 - The image ADDS to tweet meaning but tweet text is NOT represented in the image
	2 - The image does NOT ADD to tweet meaning but tweet text IS represented in the image
	3 - The image does NOT ADD to tweet meaning and tweet text is NOT represented in the image

*/

if(isset($_POST['url'])){
	//Save image
	$id = $_POST['id'];
	$filename = "/home/baumuin/public_html/twitediens.tk/saved_pics/".$id.".jpg";
	file_put_contents($filename, file_get_contents_curl($_POST['url']));
}
if(isset($_POST['0'])){
	$id = $_POST['id'];
	$result= mysqli_query($connection, "UPDATE media set relation = 0 WHERE tweet_id = '$id'"); 
}
if(isset($_POST['1'])){
	$id = $_POST['id'];
	$result= mysqli_query($connection, "UPDATE media set relation = 1 WHERE tweet_id = '$id'"); 
}
if(isset($_POST['2'])){
	$id = $_POST['id'];
	$result= mysqli_query($connection, "UPDATE media set relation = 2 WHERE tweet_id = '$id'"); 
}
if(isset($_POST['3'])){
	$id = $_POST['id'];
	$result= mysqli_query($connection, "UPDATE media set relation = 3 WHERE tweet_id = '$id'"); 
}
if(isset($_POST['del'])){
	$id = $_POST['id'];
	$result= mysqli_query($connection, "DELETE FROM media WHERE tweet_id = '$id'"); 
}
if(isset($_POST['delall'])){
	$id = $_POST['id'];
	$result= mysqli_query($connection, "DELETE FROM media WHERE tweet_id = '$id'"); 
	$result= mysqli_query($connection, "DELETE FROM mentions WHERE tweet_id = '$id'"); 
	$result= mysqli_query($connection, "DELETE FROM words WHERE tvits = '$id'"); 
	$result= mysqli_query($connection, "DELETE FROM tweets WHERE id = '$id'"); 
}
if(isset($_POST["TTS"]) && $_POST["TTS"]=="Izrunāt") 
	$TTS = true;
else
	$TTS = false;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="lv" lang="lv">
<head>
<title>TwitĒdiens - attēlu marķēšana</title>
<meta name="viewport" content="width=320, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link href="/includes/apple-touch-icon.png" rel="apple-touch-icon" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
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
<h1 style="padding-top:3px;font-size: min(max(30px, 8vw), 36px);">
	<a href="/"><img alt="TwitĒdiens Logo" src="/img/te.png" style="max-width:40px;min-width: 15px;" /></a> 
	Attēlu marķēšana
</h1>
<?php			
	//Paņem jaunāko vēl nemarķēto tvītu, kura autors nav pelēkajā sarakstā
	$black_peeps = implode( "', '" , $blacklist );
	$latest = mysqli_query($connection, "SELECT * FROM media
											JOIN tweets on id = tweet_id 
											WHERE relation IS NULL 
											AND media_url IS NOT NULL 
											AND media_url != '' 
											AND screen_name NOT IN ( '$black_peeps' ) 
											ORDER BY created_at DESC 
											LIMIT 0, 1");
											// ORDER BY RAND()   
	$p = mysqli_fetch_array($latest);
	
	$id = $p["id"];
	$username = $p["screen_name"];
	$text = $p["text"];
	$ttime = $p["created_at"];
	$quoted_id = $p["quoted_id"];
	$media_url = $p["media_url"];
	$quoted_text = NULL;

	//Is it still accessible?
	$imagesize = filesizeUrl($media_url);
	// var_dump($imagesize);
	if($imagesize <= 0.0){
		//Delete if is not...
		$result= mysqli_query($connection, "DELETE FROM media WHERE tweet_id = '$id'"); 
		//Refresh page
		header("Location: ?");
	}
	
	if($quoted_id != NULL){
		$quoted = mysqli_query($connection, "SELECT text, screen_name FROM tweets WHERE id = $quoted_id");
		$qq=mysqli_fetch_array($quoted);
		if($qq){
			$quoted_text = $qq["text"];
			$quoted_screen_name = $qq["screen_name"];
		}
	}
	
	$regex = "@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?).*$)@";
	$forTTS = preg_replace($regex, ' ', $text);
	
	//Marķēšanas statistika
	$tot = mysqli_query($connection, "SELECT COUNT(DISTINCT tweet_id) sk FROM media WHERE relation IS NULL");
	$done = mysqli_query($connection, "SELECT COUNT(DISTINCT tweet_id) sk FROM media WHERE relation IS NOT NULL; ");
	$papa = mysqli_query($connection, "SELECT COUNT(DISTINCT tweet_id) sk FROM media WHERE relation = 0");
	$pane = mysqli_query($connection, "SELECT COUNT(DISTINCT tweet_id) sk FROM media WHERE relation = 1");
	$nepa = mysqli_query($connection, "SELECT COUNT(DISTINCT tweet_id) sk FROM media WHERE relation = 2");
	$nene = mysqli_query($connection, "SELECT COUNT(DISTINCT tweet_id) sk FROM media WHERE relation = 3");
	
	$ptot = mysqli_fetch_array($tot);
	$pdone = mysqli_fetch_array($done);
	$qpapa = mysqli_fetch_array($papa);
	$qpane = mysqli_fetch_array($pane);
	$qnepa = mysqli_fetch_array($nepa);
	$qnene = mysqli_fetch_array($nene);
	
	$total 		= $ptot['sk'];
	$skpapa 	= $qpapa['sk'];
	$skpane 	= $qpane['sk'];
	$sknepa 	= $qnepa['sk'];
	$sknene 	= $qnene['sk'];
	// $annotated 	= $skpapa + $skpane + $sknepa + $sknene;
	$annotated 	= $pdone['sk'];
	$useful		= min($skpapa, $skpane, $sknepa, $sknene) * 4;
	
?>
<div id="bottom" style="padding:8px;">
	<div style="text-align:center;">
		🖼️ ✅, 📄 ✅: <?php echo $skpapa; ?> 
		🖼️ ✅, 📄 ❎: <?php echo $skpane; ?><br/>
		🖼️ ❎, 📄 ✅: <?php echo $sknepa; ?> 
		🖼️ ❎, 📄 ❎: <?php echo $sknene; ?><br/>
		Nemarķēti: <?php echo number_format($total, 0, '.', ',' ); ?><br/>
		Marķēti: <?php echo $annotated; ?>; Noderīgi: <?php echo $useful; ?><br/>
	</div>
</div>
<div id="contents" style="display: none;margin-top:10px;margin-bottom:10px;padding:6px;text-align:center; min-height:200px;">
	<form method="post" action="pics.php">
	<input class="TTS" style="top:0px;" type="checkbox" id="TTS" name="TTS" value="Izrunāt" <?php if($TTS) echo "checked"; ?>> 
	<label class="TTS" style="top:0px;" for="TTS">Izrunāt?</label></br>
	<audio class="audioPlayer" controls autoplay style="max-width:60%;">
		<?php if($TTS){ ?>
	  <source src="https://runa.tilde.lv/client/say/?text=<?php echo urlencode($forTTS);?>&voice=sandra4" type="audio/mpeg">
	  Your browser does not support the audio element.
		<?php } ?>
	</audio>
	<div style="max-width:750px; margin:auto auto; text-align:center;<?php if ((time()-StrToTime($ttime))<5){echo"opacity:".((time()-StrToTime($ttime))/5).";";}?>" class="tweet">
	<div class="lietotajs"><?php echo '<a style="text-decoration:none;color:#658304;" href="/draugs/'.trim($username).'">@'.trim($username).'</a> ';?> ( <?php echo $ttime;?> )</div>
	<div style="padding-top:10px;"><?php 
		$text = enrich_text($text, "#229cec", $validFood);
		echo $text; 
		if(isset($quoted_text) && strlen($quoted_text) > 0){
			echo "<div style='border:1px dotted #000; border-radius:5px; padding:2px;'><small>";
			echo '<a style="text-decoration:none;color:#658304;" href="/draugs/'.str_replace('@','',trim($quoted_screen_name)).'">@'.trim($quoted_screen_name).'</a>: ';
			echo $quoted_text."</small></div><br/>";
		}
		?><br/></div>
		<img style="max-width:50%; margin:auto auto; text-align:center;" src="<?php echo $media_url; ?>" />
		<br/>
		<input type="hidden" value="<?php echo $id;?>" name="id"/>
		<input type="hidden" value="<?php echo $media_url;?>" name="url"/>
		<input TYPE="submit" name="delall" class="senti del" style="width: 85px; border:2px solid black" type="button" value="🗑️ 🖼️+📄" />
		<input TYPE="submit" name="del" class="senti del" style="width: 85px; border:2px solid black" type="button" value="🗑️ 🖼️" /> </br>
		<input TYPE="submit" name="0" class="senti poz" style="border:2px solid green" type="button" value="🖼️ ✅, 📄 ✅" />
		<input TYPE="submit" name="1" class="senti nei" style="border:2px solid gray" type="button" value="🖼️ ✅, 📄 ❎" /> </br>
		<input TYPE="submit" name="2" class="senti cit" style="border:2px solid purple" type="button" value="🖼️ ❎, 📄 ✅" />
		<input TYPE="submit" name="3" class="senti neg" style="border:2px solid red" type="button" value="🖼️ ❎, 📄 ❎" />
	</form>
	</div>
	<br class="clear" />
</div>
</body>
</html>

<?php

function filesizeUrl($url) {
	$ch = curl_init($url);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, TRUE);
	curl_setopt($ch, CURLOPT_NOBODY, TRUE);

	$data = curl_exec($ch);
	$size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);

	curl_close($ch);
	return $size;
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