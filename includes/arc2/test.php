<?php
header("Content-type: text/html; charset=utf-8");
include_once("ARC2.php");
$parser = ARC2::getRDFXMLParser();
$parser->parse('http://localhost/TwitEdiens/includes/erdf/examples/vards');
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
?>
<pre>
<?php
	print_r($triple);
?>
</pre>
<?php
}
//izdrukā
echo "<h2>Apraksts [eng]</h2><p>".$apraksts."</p>";
echo "<h2>Attēls</h2><a href='".$lattels."'><img src='".$attels."'/></a><br/>";
?>