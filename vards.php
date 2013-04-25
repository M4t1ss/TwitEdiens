<?php
include_once("includes/arc2/ARC2.php");
$vards=urldecode($_GET['vards']);
//Iz DB
$vardi = mysql_query("SELECT tvits, eng FROM words where nominativs = '$vards'");
$ee=mysql_fetch_array($vardi);
$eng = $ee["eng"];

//Info no DBPedia
$parser = ARC2::getRDFParser();
$parser->parse('http://dbpedia.org/data/'.$eng.'.rdf');
$triples = $parser->getSimpleIndex(0);
foreach($triples as $triple){
	//dabū anglisku aprakstu
	for ($xxx=0;$xxx<sizeof($triple['http://dbpedia.org/ontology/abstract']);$xxx++){
		if ($triple['http://dbpedia.org/ontology/abstract'][$xxx]['lang'] == 'en') {
				$apraksts = $triple['http://dbpedia.org/ontology/abstract'][$xxx]['value'];
			}
	}
	//dabū sīkattēlu
	if (isset($triple['http://dbpedia.org/ontology/thumbnail'][0]['value'])) {
		$attels = $triple['http://dbpedia.org/ontology/thumbnail'][0]['value'];
	}
	//dabū lielo attēlu
	if (isset($triple['http://xmlns.com/foaf/0.1/depiction'][0]['value'])) {
		$lattels = $triple['http://xmlns.com/foaf/0.1/depiction'][0]['value'];
	}
}
//izdrukā
if (isset($apraksts)){
?>
<a style='text-align:center;font-size:30px;font-weight:bold;margin:auto auto; width:50px;'><?php echo $vards; ?></a>
(<a class="tooltip">?<span class="custom info"><img src="/includes/tooltip/Info.png" alt="Information" height="48" width="48" class="png" /><em>Apraksts [eng]</em><?php echo $apraksts; ?></span></a>)<br/>
<div>
	<div style="padding:5px;" id="content">Ielādē...</div>
</div>
<?php
}else{
?>
<a style='text-align:center;font-size:30px;font-weight:bold;margin:auto auto; width:50px;'><?php echo $vards; ?></a>
<div>
	<div style="padding:5px;" id="content">Ielādē...</div>
</div>
<?php
}
?>
<!-- attēls no google image search -->
<script src="https://www.google.com/jsapi?key=ABQIAAAAwNLfFSirmOLKkKGBImYROhR-aFOkHTCPd8GmiU2WFD4CBmb8xhT4K2zPKmh7e3lAi4XgaludyidIAw" type="text/javascript"></script>
<script type="text/javascript">
google.load('search', '1');
function searchComplete(searcher) {
  if (searcher.results && searcher.results.length > 0) {
	var contentDiv = document.getElementById('content');
	contentDiv.innerHTML = '';
	var results = searcher.results;
	  var result = results[0];
	  var imgContainer = document.createElement('div');
	  var newImg = document.createElement('img');
	  newImg.src = result.tbUrl;
	  imgContainer.appendChild(newImg);
	  contentDiv.appendChild(imgContainer);
  }
}
function OnLoad() {
  var imageSearch = new google.search.ImageSearch();
  imageSearch.setRestriction(google.search.ImageSearch.RESTRICT_IMAGESIZE,
							 google.search.ImageSearch.IMAGESIZE_MEDIUM);
  imageSearch.setSearchCompleteCallback(this, searchComplete, [imageSearch]);
  imageSearch.execute("<?php echo $vards;?>");
}
google.setOnLoadCallback(OnLoad);
</script>
<div>
<?php
$krasa=TRUE;
echo "<table id='results' style='margin:auto auto;'>";
echo "<tr>
<th>Lietotājs</th>
<th>Tvīts</th>
</tr>";
while($r=mysql_fetch_array($vardi)){
	$tvits = $r["tvits"];
	$tviti = mysql_query("SELECT screen_name, text FROM tweets where id = '$tvits'");
	if (mysql_num_rows($tviti)>0){
	$p=mysql_fetch_array($tviti);
	$niks = $p["screen_name"];
	$teksts = $p["text"];
	if ($krasa==TRUE) {$kr=" class='even'";}else{$kr="";}
	echo '<tr'.$kr.'><td><b><a style="text-decoration:none;color:#658304;" href="/draugs/'.$niks.'">'.$niks.'</a></b></td><td>'.$teksts.'</td></tr>';
	$krasa=!$krasa;
	}
}
echo "</table>";
?>
</div>