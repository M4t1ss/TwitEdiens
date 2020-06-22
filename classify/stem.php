<?php

class Affix{
	public $Affix;
	public $vc;
	public $palatalizes;
	
	function __construct($Affix, $vc, $palatalizes) {
		$this->Affix = $Affix;
		$this->vc = $vc;
		$this->palatalizes = $palatalizes;
	}
}

function un_palatalize(&$s, $length){
    # we check the character removed: if its -u then
    # its 2,5, or 6 gen pl., and these two can only apply then.
    if ($s[$length] == 'u'){
        # kš -> kst
        if (endswith($s, $length, "kš")){
            $length ++;
            $s[$length - 2] = 's';
            $s[$length - 1] = 't';
            return $length;
		}else if (endswith($s, $length, "ņņ")){
            $s[$length - 2] = 'n';
            $s[$length - 1] = 'n';
            return $length;
		}
	}

    # otherwise all other rules
    if (endswith($s, $length, "pj") ||  endswith($s, $length, "bj") ||  endswith($s, $length, "mj") ||  endswith($s, $length, "vj")){
        # labial consonant
        return $length - 1;
    }else if (endswith($s, $length, "šņ")){
        $s[$length - 2] = 's';
        $s[$length - 1] = 'n';
        return $length;
    }else if (endswith($s, $length, "žņ")){
        $s[$length - 2] = 'z';
        $s[$length - 1] = 'n';
        return $length;
    }else if (endswith($s, $length, "šļ")){
        $s[$length - 2] = 's';
        $s[$length - 1] = 'l';
        return $length;
    }else if (endswith($s, $length, "žļ")){
        $s[$length - 2] = 'z';
        $s[$length - 1] = 'l';
        return $length;
    }else if (endswith($s, $length, "ļņ")){
        $s[$length - 2] = 'l';
        $s[$length - 1] = 'n';
        return $length;
    }else if (endswith($s, $length, "ļļ")){
        $s[$length - 2] = 'l';
        $s[$length - 1] = 'l';
        return $length;
    }else if ($s[$length - 1] == 'č'){
        $s[$length - 1] = 'c';
        return $length;
    }else if ($s[$length - 1] == 'ļ'){
        $s[$length - 1] = 'l';
        return $length;
    }else if ($s[$length - 1] == 'ņ'){
        $s[$length - 1] = 'n';
        return $length;

	}
    return $length;
}

function endsWith($s, $length, $suffix){
	return endsWithX(substr_unicode(implode($s), 0, $length), $suffix);
}
function endsWithX($haystack, $needle){
    $length = mb_strlen($needle);
    if ($length == 0) {
        return true;
    }
    return (substr_unicode($haystack, -$length) === $needle);
}

function num_vowels($s){
    $vowels = preg_split('##u', 'aāeēiīouūAĀEĒIĪOUŪ', -1, PREG_SPLIT_NO_EMPTY);
    $count = 0;
	foreach($s as $char){
		if(in_array($char, $vowels)){
			$count++;
		}
	}
    return $count;
}

function stem_length($s){
    $s = preg_split('##u', $s, -1, PREG_SPLIT_NO_EMPTY);
    $numvowels = num_vowels($s);
    $length = count($s);

	$Affixes = array(
		new Affix("ajiem", 3, False),
		new Affix("ajai", 3, False),
		new Affix("ajam", 2, False),
		new Affix("ajām", 2, False),
		new Affix("ajos", 2, False),
		new Affix("ajās", 2, False),
		new Affix("iem", 2, True),
		new Affix("ajā", 2, False),
		new Affix("ais", 2, False),
		new Affix("ai", 2, False),
		new Affix("ei", 2, False),
		new Affix("ām", 1, False),
		new Affix("am", 1, False),
		new Affix("ēm", 1, False),
		new Affix("īm", 1, False),
		new Affix("im", 1, False),
		new Affix("um", 1, False),
		new Affix("us", 1, True),
		new Affix("as", 1, False),
		new Affix("ās", 1, False),
		new Affix("es", 1, False),
		new Affix("os", 1, True),
		new Affix("ij", 1, False),
		new Affix("īs", 1, False),
		new Affix("ēs", 1, False),
		new Affix("is", 1, False),
		new Affix("ie", 1, False),
		new Affix("u", 1, True),
		new Affix("a", 1, True),
		new Affix("i", 1, True),
		new Affix("e", 1, False),
		new Affix("ā", 1, False),
		new Affix("ē", 1, False),
		new Affix("ī", 1, False),
		new Affix("ū", 1, False),
		new Affix("o", 1, False),
		new Affix("s", 0, False),
		new Affix("š", 0, False)
	);

	foreach($Affixes as $Affix){
		if($numvowels > $Affix->vc && $length >= mb_strlen($Affix->Affix) + 3 && endsWith($s, $length, $Affix->Affix)){
			$length -= mb_strlen($Affix->Affix);
			return $Affix->palatalizes?un_palatalize($s, $length):$length;
		}
		
	}
}

function substr_unicode($str, $s, $l = null) {
    return join("", array_slice(
        preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY), $s, $l));
}

function stem($s){
	$s = trim($s);
	return substr_unicode($s, 0, stem_length($s));
}
