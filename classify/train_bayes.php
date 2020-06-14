<?php
require("stem.php");
require("Bayes.php");
$classifier = new \Niiknow\Bayes();

//Data
$train_pos = fopen("data/nelemm/te-mp-rv-pe.tok.lc.pos", "r") or die("Can't create target input file!");
$train_neg = fopen("data/nelemm/te-mp-rv-pe.tok.lc.neg", "r") or die("Can't create target input file!");
$train_nei = fopen("data/nelemm/te-mp-rv-pe.tok.lc.nei", "r") or die("Can't create target input file!");

$test_pos = fopen("data/nelemm/test.pr.tok.lc.pos", "r") or die("Can't create target input file!");
$test_neg = fopen("data/nelemm/test.pr.tok.lc.neg", "r") or die("Can't create target input file!");
$test_nei = fopen("data/nelemm/test.pr.tok.lc.nei", "r") or die("Can't create target input file!");


//Train
while ($line = fgets($train_pos)) {
	$lineparts = explode(" ", $line);
	$stemmedLine = "";
	foreach($lineparts as $part){
		$stemmedLine .= stem($part)." ";
	}
	$classifier->learn(trim($stemmedLine), 'pos');
}
while ($line = fgets($train_neg)) {
	$lineparts = explode(" ", $line);
	$stemmedLine = "";
	foreach($lineparts as $part){
		$stemmedLine .= stem($part)." ";
	}
	$classifier->learn(trim($stemmedLine), 'neg');
}
while ($line = fgets($train_nei)) {
	$lineparts = explode(" ", $line);
	$stemmedLine = "";
	foreach($lineparts as $part){
		$stemmedLine .= stem($part)." ";
	}
	$classifier->learn(trim($stemmedLine), 'nei');
}

//Save model
$stateJson = $classifier->toJson();
file_put_contents("model-nelemm-noni.json", $stateJson);

//Evaluate
$pos = 0;
$neg = 0;
$nei = 0;
$pos_tot = 0;
$neg_tot = 0;
$nei_tot = 0;
while ($line = fgets($test_pos)) {
	$lineparts = explode(" ", $line);
	$stemmedLine = "";
	foreach($lineparts as $part){
		$stemmedLine .= stem($part)." ";
	}
	$class = $classifier->categorize(trim($stemmedLine));
	$pos_tot++;
	if($class == 'pos') 
		$pos++;
}
while ($line = fgets($test_neg)) {
	$lineparts = explode(" ", $line);
	$stemmedLine = "";
	foreach($lineparts as $part){
		$stemmedLine .= stem($part)." ";
	}
	$class = $classifier->categorize(trim($stemmedLine));
	$neg_tot++;
	if($class == 'neg') 
		$neg++;
}
while ($line = fgets($test_nei)) {
	$lineparts = explode(" ", $line);
	$stemmedLine = "";
	foreach($lineparts as $part){
		$stemmedLine .= stem($part)." ";
	}
	$class = $classifier->categorize(trim($stemmedLine));
	$nei_tot++;
	if($class == 'nei') 
		$nei++;
}

//Print results
$total = $pos_tot + $neg_tot + $nei_tot;
$correct = $pos + $neg + $nei;
$acc = round($correct/$total*100, 2);

echo "Total test data: ".$total."\n";
echo "Correctly classified: ".$correct."\n";
echo "Accuracy: ".$acc."\n";


// load the classifier back from its JSON representation.
// $classifier->fromJson($stateJson);