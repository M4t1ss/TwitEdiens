<?php
include "includes/init_sql.php";
?>

<h2 style='margin:auto auto; text-align:center;'>Jaunākie attēli</h2>
<p style='margin:auto auto; text-align:center;font-size:0.8em;'>(reālā laikā)</p><br/>
<script type="text/javascript">
var isOpera = !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
    // Opera 8.0+ (UA detection to detect Blink/v8-powered Opera)
var isFirefox = typeof InstallTrigger !== 'undefined';   // Firefox 1.0+
var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
    // At least Safari 3+: "[object HTMLElementConstructor]"
var isChrome = !!window.chrome && !isOpera;              // Chrome 1+
var isIE = /*@cc_on!@*/false || !!document.documentMode;   // At least IE6

$(function() {
	if(!isOpera && !isChrome){
		setInterval(function() {
		$("#content").load(location.href+" #content>*","");
		}, 3000);
	}
});
</script>
<?php
//dabū 10 jaunākos tvītus
$latest = mysqli_query($connection, "SELECT distinct media_url, expanded_url, date, text FROM media JOIN tweets ON tweets.id = media.tweet_id GROUP BY media_url ORDER BY date DESC limit 0, 25");
?>

<div id="contentFull" style='margin:auto auto;'>
<section id="photos">
<?php
error_reporting(0);
	while($p=mysqli_fetch_array($latest)){
		$media_url = $p["media_url"];
		$expanded_url = $p["expanded_url"];
		$ttime = $p["date"];
		$ttext = $p["text"];
		error_reporting(E_ERROR);
		if (@getimagesize($media_url)) {
		?>
		<div class="imgcontainer" style="<?php if ((time()-StrToTime($ttime))<5){echo"opacity:".((time()-StrToTime($ttime))/5).";";}?> display:inline;" >
			<a class="imgimage" target="_blank" href="<?php echo $expanded_url; ?>">
				<img alt="<?php echo $ttext;?>" src="<?php echo $media_url; ?>" />
			</a>
			<p class="imgtext">
				<?php echo $ttext;?>
			</p>
		</div>
		<?php
		}
	}
?>
</section>
</div>