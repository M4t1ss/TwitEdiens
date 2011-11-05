<?php
  include 'tag/classes/wordcloud.class.php';
?>
<link rel="stylesheet" href="tag/css/wordcloud.css" type="text/css">
<h1 style='margin:auto auto; text-align:center;'>Populārākie ēdieni / dzērieni</h1>
<br/>
<div >
<?php
//Pieslēgums DB
include "init_sql.php";
$vardi = mysql_query("SELECT nominativs FROM words where nominativs != '0'");

$cloud = new wordCloud();
//jāuztaisa vēl, lai, uzklikojot uz kādu ēdienu, atvērtu visus tvītus, kas to pieminējuši...
while($r=mysql_fetch_array($vardi)){
	$nom = $r["nominativs"];
	$cloud->addWord(array('word' => $nom, 'url' => '?id=vards&vards='.urlencode($nom)));
}
$cloud->orderBy('size', 'desc');
$myCloud = $cloud->showCloud('array');
foreach ($myCloud as $cloudArray) {
  echo ' &nbsp; <a href="'.$cloudArray['url'].'" class="word size'.$cloudArray['range'].'">'.$cloudArray['word'].'</a> &nbsp;';
}
?>
</div>