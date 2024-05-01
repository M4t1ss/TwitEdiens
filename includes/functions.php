<?php

function enrich_text($text, $color, $validFood){

	foreach($validFood as $foodItem){
		if(!preg_match("/(?<=\>)$foodItem/", $text) && !preg_match("/$foodItem(?=\<)/", $text)){
			if(preg_match("/(?<=[\W])$foodItem(?=[\W])/", $text))
				$text = preg_replace("/(?<=[\W])($foodItem)(?=[\W])/", '<a style="text-decoration:none;color:'.$color.';" href="/atslegvards/'.$foodItem.'">'.$foodItem.'</a>', $text,1);
			elseif(preg_match("/(?<=[\W])$foodItem$/", $text))
				$text = preg_replace("/(?<=[\W])($foodItem)$/", '<a style="text-decoration:none;color:'.$color.';" href="/atslegvards/'.$foodItem.'">'.$foodItem.'</a>', $text,1);
			elseif(preg_match("/^$foodItem(?=[\W])/", $text))
				$text = preg_replace("/^($foodItem)(?=[\W])/", '<a style="text-decoration:none;color:'.$color.';" href="/atslegvards/'.$foodItem.'">'.$foodItem.'</a>', $text,1);
		}else{
			// $text = str_replace($foodItem, '<span style="text-decoration:none;color:#658304;">'.$foodItem.'</span>', $text);
		}
	}

	$matches = array();
	if (preg_match_all('/@[^[:space:]]+/', $text, $matches)) {
		foreach ($matches[0] as $match){
			$text = str_replace(trim($match), '<a style="text-decoration:none;color:#658304;" href="/draugs/'.str_replace('@','',trim($match)).'">'.trim($match).'</a> ', $text);
		}
	}
	
	if (preg_match_all('/http[^[:space:]]+/', $text, $matches)) {
		foreach ($matches[0] as $match){
			$text = str_replace(trim($match), '<a style="text-decoration:none;color:#658304;" target="_blank" href="'.trim($match).'">'.trim($match).'</a> ', $text);
		}
	}

	return $text;
}

function enrich_food($text, $color, $validFood){

	foreach($validFood as $foodItem){
		if(!preg_match("/(?<=\>)$foodItem/", $text) && !preg_match("/$foodItem(?=\<)/", $text)){
			if(preg_match("/(?<=[\W])$foodItem(?=[\W])/", $text))
				$text = preg_replace("/(?<=[\W])($foodItem)(?=[\W])/", '<a style="text-decoration:none;color:'.$color.';" href="/atslegvards/'.$foodItem.'">'.$foodItem.'</a>', $text,1);
			elseif(preg_match("/(?<=[\W])$foodItem$/", $text))
				$text = preg_replace("/(?<=[\W])($foodItem)$/", '<a style="text-decoration:none;color:'.$color.';" href="/atslegvards/'.$foodItem.'">'.$foodItem.'</a>', $text,1);
			elseif(preg_match("/^$foodItem(?=[\W])/", $text))
				$text = preg_replace("/^($foodItem)(?=[\W])/", '<a style="text-decoration:none;color:'.$color.';" href="/atslegvards/'.$foodItem.'">'.$foodItem.'</a>', $text,1);
		}
	}

	return $text;
}

function translit($word){
	$word = str_replace("ī","i",$word);
	$word = str_replace("ū","u",$word);
	$word = str_replace("ē","e",$word);
	$word = str_replace("ā","a",$word);
	$word = str_replace("š","s",$word);
	$word = str_replace("ģ","g",$word);
	$word = str_replace("ķ","k",$word);
	$word = str_replace("ļ","l",$word);
	$word = str_replace("ž","z",$word);
	$word = str_replace("č","c",$word);
	$word = str_replace("ņ","n",$word);
	return $word;
}

function translit2($word){
	$word = str_replace("ī","ii",$word);
	$word = str_replace("ū","uu",$word);
	$word = str_replace("ē","ee",$word);
	$word = str_replace("ā","aa",$word);
	$word = str_replace("š","sh",$word);
	$word = str_replace("ģ","gj",$word);
	$word = str_replace("ķ","kj",$word);
	$word = str_replace("ļ","lj",$word);
	$word = str_replace("ž","zh",$word);
	$word = str_replace("č","ch",$word);
	$word = str_replace("ņ","nj",$word);
	return $word;
}

function has_emojis($string) {
	$unicodeRegexp = '([*#0-9](?>\\xEF\\xB8\\x8F)?\\xE2\\x83\\xA3|\\xC2[\\xA9\\xAE]|\\xE2..(\\xF0\\x9F\\x8F[\\xBB-\\xBF])?(?>\\xEF\\xB8\\x8F)?|\\xE3(?>\\x80[\\xB0\\xBD]|\\x8A[\\x97\\x99])(?>\\xEF\\xB8\\x8F)?|\\xF0\\x9F(?>[\\x80-\\x86].(?>\\xEF\\xB8\\x8F)?|\\x87.\\xF0\\x9F\\x87.|..(\\xF0\\x9F\\x8F[\\xBB-\\xBF])?|(((?<zwj>\\xE2\\x80\\x8D)\\xE2\\x9D\\xA4\\xEF\\xB8\\x8F\k<zwj>\\xF0\\x9F..(\k<zwj>\\xF0\\x9F\\x91.)?|(\\xE2\\x80\\x8D\\xF0\\x9F\\x91.){2,3}))?))';
    preg_match( $unicodeRegexp, $string, $matches_emo );
    return !empty( $matches_emo[0] ) ? true : false;
}