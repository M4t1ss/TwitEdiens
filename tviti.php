<?php
include "includes/init_sql.php";
include "classify/evaluate_bayes.php";

//dabū 10 jaunākos tvītus
$latest = mysqli_query($connection, "SELECT * FROM tweets ORDER BY created_at DESC limit 0, 10");


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