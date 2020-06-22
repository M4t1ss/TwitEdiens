<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require("/home/baumuin/public_html/twitediens.tk/classify/stem.php");
require("/home/baumuin/public_html/twitediens.tk/classify/Bayes.php");

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

function classify($text){
	//Load model
	$classifier = new \Niiknow\Bayes();
	$stateJson = file_get_contents("/home/baumuin/public_html/twitediens.tk/classify/model-nelemm-more-full-nohash.json");
	$classifier->fromJson($stateJson);
	
	$text = strtolower($text);
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
		return $classifier->categorize(trim($stemmedLine));
	else
		return "nei";
}

function tokenize($str){
	$arr = array();
	// for the character classes
	// see http://php.net/manual/en/regexp.reference.unicode.php
	$pat = '/
	            ([\pZ\pC]*)			# match any separator or other
	                                # in sequence
	            (
	                [^\pP\pZ\pC]+ |	# match a sequence of characters
	                                # that are not punctuation,
	                                # separator or other
	                .				# match punctuations one by one
	            )
	            ([\pZ\pC]*)			# match a sequence of separators
	                                # that follows
	        /xu';
	preg_match_all($pat,$str,$arr);
	
	$combo = implode(" ", $arr[2]);
	
	$combo = str_replace("#", "", $combo);
	$combo = str_replace("  ", " ", $combo);
	$combo = str_replace("@ usr", "@usr", $combo);
	return str_replace("@ url", "@url", $combo);
}

function replace_usr($str){
	$pattern = '/(^|\W)(@([0-9a-zA-Z_]+))/';
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