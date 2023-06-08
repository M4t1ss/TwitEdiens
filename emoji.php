<style>
  .esize9 {
  	color: #000;
  	font-size: 80px;
  }
  .esize8 {
  	color: #111;
  	font-size: 70px;
  }
  .esize7 {
  	color: #222;
  	font-size: 60px;
  }
  .esize6 {
  	color: #333;
  	font-size: 50px;
  }
  .esize5 {
  	color: #444;
  	font-size: 40px;
  }
  .esize4 {
  	color: #555;
  	font-size: 35px;
  }
  .esize3 {
  	color: #666;
  	font-size: 30px;
  }
  .esize2 {
  	color: #777;
  	font-size: 25px;
  }
  .esize1 {
  	color: #888;
  	font-size: 20px;
  }
</style>
<h2 style='margin:auto auto; text-align:center;'>Populārākie emotikoni</h2>
<?php

include 'includes/tag/classes/wordcloud.class.php';
$cloud = new wordCloud();

echo "<div style='text-align:center'>";

$query = "SELECT id, text FROM `tweets` WHERE `text` LIKE '%😊%'";
$unicodeRegexp = '([*#0-9](?>\\xEF\\xB8\\x8F)?\\xE2\\x83\\xA3|\\xC2[\\xA9\\xAE]|\\xE2..(\\xF0\\x9F\\x8F[\\xBB-\\xBF])?(?>\\xEF\\xB8\\x8F)?|\\xE3(?>\\x80[\\xB0\\xBD]|\\x8A[\\x97\\x99])(?>\\xEF\\xB8\\x8F)?|\\xF0\\x9F(?>[\\x80-\\x86].(?>\\xEF\\xB8\\x8F)?|\\x87.\\xF0\\x9F\\x87.|..(\\xF0\\x9F\\x8F[\\xBB-\\xBF])?|(((?<zwj>\\xE2\\x80\\x8D)\\xE2\\x9D\\xA4\\xEF\\xB8\\x8F\k<zwj>\\xF0\\x9F..(\k<zwj>\\xF0\\x9F\\x91.)?|(\\xE2\\x80\\x8D\\xF0\\x9F\\x91.){2,3}))?))';

$vardi = mysqli_query($connection, $query);

$emojiCounts = array();

while($r=mysqli_fetch_array($vardi)){
	$text = $r["text"];
	$id = $r["id"];

	$emojis = has_emojis_old($text);
	foreach ($emojis as $emoji){
		if(!isset($emojiCounts[$emoji])){
			$emojiCounts[$emoji] = 1;
		}else{
			$emojiCounts[$emoji] += 1;
		}
	}
}

arsort($emojiCounts);

foreach($emojiCounts as $moji => $count){
	for($i=0;$i<$count;$i++){
		$cloud->addWord(array('word' => $moji, 'url' => 'atslegvards/'.urlencode($moji)));
	}
}

$cloud->setLimit(300);
$myCloud = $cloud->showCloud('array');
foreach ($myCloud as $cloudArray) {
  echo ' &nbsp; <div style="display:inline-block;"><a href="'.$cloudArray['url'].'" class="word esize'.$cloudArray['range'].'">'.$cloudArray['word'].'</a></div> &nbsp;';
}

echo "</div>";

function has_emojis_old($string) {
	global $unicodeRegexp;
    preg_match_all( $unicodeRegexp, $string, $matches_emo );
    return $matches_emo[0];
}
