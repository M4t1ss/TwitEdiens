<?php
include_once("includes/arc2/ARC2.php");
$vards=urldecode($_GET['vards']);
//Iz DB
$vardi = mysqli_query($connection, "SELECT tvits, eng, screen_name, text, created_at FROM words
JOIN tweets on	id = tvits
where nominativs = '$vards'
group by tweets.id
order by created_at desc
");
$ee=mysqli_fetch_array($vardi);
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
	<div style="padding:5px;" id="contentX">Ielādē...</div>
</div>
<?php
}else{
?>
<a style='text-align:center;font-size:30px;font-weight:bold;margin:auto auto; width:50px;'><?php echo $vards; ?></a>
<div>
	<div style="padding:5px;" id="contentX">Ielādē...</div>
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
	var contentDiv = document.getElementById('contentX');
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
<th>Tvītots</th>
</tr>";
while($r=mysqli_fetch_array($vardi)){
	$tvits = $r["tvits"];
	$niks = $r["screen_name"];
	$teksts = $r["text"];
	
	#Iekrāso un izveido saiti uz katru pieminēto lietotāju tekstā
	#Šo vajadzētu visur...
	$matches = array();
	if (preg_match_all('/@[^[:space:]]+/', $teksts, $matches)) {
		foreach ($matches[0] as $match){
			$teksts = str_replace(trim($match), '<a style="text-decoration:none;color:#658304;" href="/draugs/'.str_replace('@','',trim($match)).'">'.trim($match).'</a> ', $teksts);
		}
	}
	
	$datums = $r["created_at"];
	if ($krasa==TRUE) {$kr=" class='even'";}else{$kr="";}
	echo '<tr'.$kr.'><td><b><a style="text-decoration:none;color:#658304;" href="/draugs/'.$niks.'">'.$niks.'</a></b></td><td>'.$teksts.'</td><td class="datu">'.$datums.'</td></tr>';
	$krasa=!$krasa;
}
echo "</table>";
?>
</div>