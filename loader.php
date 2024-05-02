<?php
include "includes/init_sql.php";

//dabū 10 jaunākos tvītus
// $latest = mysqli_query($connection, "SELECT distinct media_url, date, text FROM media JOIN tweets ON tweets.id = media.tweet_id GROUP BY media_url ORDER BY date DESC limit 0, 20");
$latest = mysqli_query($connection, "SELECT media_url, date, tweet_id FROM media ORDER BY date DESC limit 0, 20");

while($p=mysqli_fetch_array($latest)){
	$media_url = $p["media_url"];
	$ttime = $p["date"];
	$ttext = $p["tweet_id"];
	
	if (@getimagesize($media_url)) {
		?>
		<div style="<?php if ((time()-StrToTime($ttime))<5){echo"opacity:".((time()-StrToTime($ttime))/5).";";}?> display:inline;" >
			<a target="_blank" href="<?php echo $media_url; ?>">
				<img alt="<?php echo $ttext;?>" src="<?php echo str_replace('http://', 'https://', $media_url); ?>" />
			</a>
		</div>
		<?php
	}else{
		//Delete this one - probably doesn't exist anymore...
	}
}
?>