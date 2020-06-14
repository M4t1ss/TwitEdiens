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

?>
<!-- attēls -->
 <div class="row">
  <div class="column left"><a style='text-align:center;font-size:30px;font-weight:bold;margin:auto auto; width:50px;'><?php echo $vards; ?></a></div>
  <div class="column middle"><img style="height:100px;" src="<?php echo $attels;?>"></div>
  <div class="column right"><b>Apraksts [eng]:</b> <?php echo $apraksts; ?><br/>
</div>
</div> 
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