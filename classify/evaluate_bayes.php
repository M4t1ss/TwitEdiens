<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require("classify/stem.php");
require("classify/Bayes.php");

#$text = $_GET["text"];


#echo "<pre>";

#var_dump($_GET["text"]);
#var_dump($text);
#var_dump(replace_usr($text));
#var_dump(replace_usr("@milenialmamma pai. http://lielakeda.lv man kā mazēdāja un visēdāja @m4t1ss un @jack"));
#var_dump(replace_url("@milenialmamma pai. http://lielakeda.lv man kā mazēdāja un visēdāja @m4t1ss un @jack"));
#var_dump(tokenize($text));
#var_dump($stemmedLine);
#var_dump(classify($_GET["text"]));

#echo "</pre>";

function classify($text, $type = false){
	//Load model
	$classifier = new \Niiknow\Bayes();
	$stateJson = file_get_contents("classify/model-proc2-nohash-smile-latest.json");
	$classifier->fromJson($stateJson);
	
	// $text = strtolower($text);
	$text = replace_usr($text);
	$text = replace_url($text);
	$text = replace_usr($text);
	$text = replace_url($text);
	$text = tokenize($text);
	
	$lineparts = explode(" ", $text);
	$stemmedLine = "";
	foreach($lineparts as $part){
		$stemmedLine .= stem($part)." ";
	}
	
	if(strlen(trim($stemmedLine)) > 0)
		if(!$type)
			return $classifier->categorize(trim($stemmedLine));
		elseif($type == "probs")
			return $classifier->getProbs(trim($stemmedLine));
		elseif($type == "freqs")
			return $classifier->getFreqs(trim($stemmedLine));
		elseif($type == "text")
			return trim($stemmedLine);
	else
		return "nei";
}

function tokenize($str){
	$str = str_replace(" ", " ", $str);
	$arr = array();
	// for the character classes
	// see http://php.net/manual/en/regexp.reference.unicode.php
	$pat = '~[@]?[0-9a-zA-ZÀ-ỿ]+|\p{P}|\S~u';
	preg_match_all($pat,$str,$arr);
	
	foreach($arr[0] as $key => $value)
		if(strlen(trim($value))==0 || preg_match('/\\d/', $value) > 0)
			unset($arr[0][$key]); 
	$combo = implode(" ", $arr[0]);
	
	$combo = str_replace("#", "", $combo);
	$combo = str_replace("  ", " ", $combo);
	$combo = str_replace("@ usr", "@usr", $combo);
	return str_replace("@ url", "@url", $combo);
}

function replace_usr($str){
	$pattern = '/(^|\W)(@([0-9a-zA-Z_āčēģīķļņšūžĀČĒĢĪĶĻŅŠŪŽ]+))/';
	$output = preg_replace($pattern, ' @usr', $str);
	$output = str_replace("@usr @usr", "@usr", $output);
	$output = str_replace("@usr @usr", "@usr", $output);
	$output = str_replace("@usr @usr", "@usr", $output);
	$output = preg_replace('/@usr$/', '', trim($output));
	$output = preg_replace('/^@usr/', '', trim($output));
		
	return $output;
}

function replace_url($str) {
	$pattern = '"\b(https?://\S+)"';
	$output = preg_replace($pattern, '@url', $str);
	$output = str_replace("@url @url", "@url", $output);
	$output = str_replace("@url @url", "@url", $output);
	$output = str_replace("@url @url", "@url", $output);
	$output = preg_replace('/@url$/', '', trim($output));
	$output = preg_replace('/^@url/', '', trim($output));
	return $output;
}