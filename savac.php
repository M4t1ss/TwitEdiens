<?php
error_reporting(0);
ignore_user_abort(true);
set_time_limit(300);
//Twitter autentificēšanās
require_once('twitteroauth/twitteroauth.php');
include_once('config.php');
//Pieslēgums DB
include "includes/init_sql.php";

require_once('Phirehose.php');
require_once('OauthPhirehose.php');
class FilterTrackConsumer extends OauthPhirehose
{
  public function enqueueStatus($status)
  {
    $data = json_decode($status, true);
    if (is_array($data) && isset($data['user']['screen_name'])) {
		$text = $data['text'];
		#Paņem pilno tekstu, ja ir pieejams
		if(isset($data['extended_tweet']['full_text']) && strlen($data['extended_tweet']['full_text']) > 0){
			$text = $data['extended_tweet']['full_text'];
		}
        //retvīti man nepatīk
        $write_to_db = true;
        if(isset($data['retweeted_status']) && is_array($data['retweeted_status'])){
            $write_to_db = false;
        }
		//Ja teksts nav pavisam tukšs
		if ($text!="" && $write_to_db) {		
			save_tweet($data, $connection);
		}
    }
  }
}

function save_tweet($tweet_data, $connection){
	if(isset($tweet_data['extended_tweet']['full_text']) && strlen($tweet_data['extended_tweet']['full_text']) > 0){
		$qtext = $tweet_data['extended_tweet']['full_text'];
	}else{
		$qtext = $tweet_data['text'];
	}
	$qtext = mysqli_real_escape_string($connection, $qtext);
	$qidd = mysqli_real_escape_string($connection, $tweet_data['id_str']);
	$qdate = mysqli_real_escape_string($connection, $tweet_data['created_at']);
	$qgeo = mysqli_real_escape_string($connection, $tweet_data['place']['name']);
	$qscreen_name = mysqli_real_escape_string($connection, $tweet_data['user']['screen_name']);
	$quser_mentions = $tweet_data['entities']['user_mentions'];
	
	//Tvīts ar cita tvīta citātu
	$quoted_id = NULL;
	if($tweet_data['is_quote_status'] && isset($tweet_data['quoted_status']) && is_array($tweet_data['quoted_status'])){
		$quoted_data = $tweet_data['quoted_status'];
		//Vai citētais tvīts mums jau ir pieglabāts?
		$quoted_id = mysqli_real_escape_string($connection, $tweet_data['quoted_status_id_str']);
		$qs = mysqli_query($connection, "SELECT id tweets where id = $qid");
		if(!$qs || mysqli_num_rows($qs)==0){
			//Ja nav, tad jāpieglabā
			save_tweet($quoted_data, $connection);
		}
	}
	
	if(isset($tweet_data['entities']['media']))
		$qmedia = $tweet_data['entities']['media'];
	else
		$qmedia = [];
	
	$user_date = new DateTime($qdate, new DateTimeZone('UTC'));
	$user_date->setTimezone(new DateTimeZone('Europe/Riga'));
	$db_date = $user_date->format('c');	
	
	//attīra
	$ntext = clean_text($qtext);
	$tc = trashy_count($qtext);
	$edieni = 0;
	
	if ($ntext!="") {
		$vardi = explode(" ", $ntext);
		for ($i = 0; $i < sizeof($vardi); $i++){
            //Teksts jāsadala pa vārdiem, vārdi jānočeko, vai ir vārdu db tādi, ja ir
            //un, ja tas vārds ir ēdiens/dzēriens, jāpievieno kopā ar tvīta id,
            //ja ir un tas nav ēdiens/dzēriens, nekas nav jādara, ja nav db tāda vārda,
            //jāpievieno kopā ar tvīta id un irvards=0
			$vards = $vardi[$i];
			$vards = str_replace("  ", "", $vards);
			$vards = str_replace(" ", "", $vards);
			$vards = str_replace("-", "", $vards);
			if (
				strlen(preg_replace('/\s+/u','',$vards)) != 0 && 
				strlen($vards) > 2 && 
				substr($vards, 0, 4)!='http' && 
				!preg_match('#[0-9]#',$vards) && 
				!preg_match("/(%0A|%0D|\\n+|\\r+)/i", $vards) && 
				!preg_match("/&/", $vards) && 
				!preg_match("/@/", $vards)
			){
				$q = mysqli_query($connection, "SELECT vards, irediens, nominativs, grupa, eng FROM  words where LOWER(vards) = LOWER('$vards')");
				if($q){
					if(mysqli_num_rows($q)>0){
						//ja ir
						$r=mysqli_fetch_array($q);
						$ir=$r["irediens"];
						$nom=$r["nominativs"];
						$grup=$r["grupa"];
						$eng=$r["eng"];
						//ja tas ir ēdiens
						if ($ir==1){
						   $ok = mysqli_query($connection, "INSERT INTO words (vards, nominativs, tvits, irediens, grupa, eng, datums) VALUES ('$vards', '$nom', '$qidd', 1, '$grup', '$eng', '$db_date')");
						}
					}
				}
			}
		}
	
		if($edieni > 0 || $qtext[0]==="@" || $tc < 3){
			if($quoted_id == NULL)
				$ok_r = mysqli_query($connection, "INSERT INTO tweets (id ,text ,screen_name, created_at, geo) VALUES ('$qidd', '$qtext', '$qscreen_name', '$db_date', '$qgeo')");
			else
				$ok_r = mysqli_query($connection, "INSERT INTO tweets (id ,text ,screen_name, created_at, geo, quoted_id) VALUES ('$qidd', '$qtext', '$qscreen_name', '$db_date', '$qgeo', '$quoted_id')");
			
			// pieminētie lietotāji
			if (sizeof($quser_mentions)>0) {
				for ($i = 0; $i < sizeof($quser_mentions); $i++){
					$mention = $quser_mentions[$i]['screen_name'];
					$ok_m = mysqli_query($connection, "INSERT INTO mentions (screen_name, tweet_id, mention, date) VALUES ('$qscreen_name', '$qidd', '$mention', '$db_date')");
				}
			}
			
			// bildes
			if (sizeof($qmedia)>0 && $tweet_data['retweeted']==false) {
				for ($i = 0; $i < sizeof($qmedia); $i++){
					$media_url = $qmedia[$i]['media_url'];
					$expanded_url = $qmedia[$i]['expanded_url'];
					$ok_m = mysqli_query($connection, "INSERT INTO media (tweet_id, media_url, expanded_url, date) VALUES ('$qidd', '$media_url', '$expanded_url', '$db_date')");
				}
			}
		}
	}
}

function clean_text($text){
	$ntext = str_replace("\n", " ", $text);
	$ntext = str_replace("\t", " ", $ntext);
	$ntext = str_replace("<br>", " ", $ntext);
	$ntext = str_replace("</br>", " ", $ntext);
	$ntext = str_replace("-", " ", $ntext);
	$ntext = str_replace(",", " ", $ntext);
	$ntext = str_replace(";", " ", $ntext);
	$ntext = str_replace(":", " ", $ntext);
	$ntext = str_replace(".", " ", $ntext);
	$ntext = str_replace("/", " ", $ntext);
	$ntext = str_replace("]", " ", $ntext);
	$ntext = str_replace("[", " ", $ntext);
	$ntext = str_replace(")", " ", $ntext);
	$ntext = str_replace("(", " ", $ntext);
	$ntext = str_replace("!", " ", $ntext);
	$ntext = str_replace("?", " ", $ntext);
	$ntext = str_replace("'", " ", $ntext);
	$ntext = str_replace('"', ' ', $ntext);
	$ntext = str_replace('#', " ", $ntext);
	$ntext = str_replace("  ", " ", $ntext);
	return $ntext;
}

function trashy_count($text){
	$badChars = [
		"𝓪","𝞪","ă","å","𝛼","𝐚","à","á","ä","Æ","α","𝗮","𝜶","ａ","𝒂","â","𝘢",
		"ď","𝗱","𝖣","𝓭","𝒅","𝐝",
		"ę","Ę","ȩ","𝐞","𝗲","𝑒","ｅ","ȅ","ҽ","ë","𝙚","𝘦","ě","ê","𝔢","é","ĕ",
		"𝖿","𝒇","𝘧","𝗳","ẝ","𝑓",
		"ġ","ǧ",
		"𝐡","𝙝","𝔥",
		"Ĩ","Ȉ","İ","Ĭ","Į","𝚤","ꭵ","î","Î","𝖎","ǐ","į","í","Ï",
		"𝙠","𝒌","𝐤","𝗸",
		"ȯ","ò","ō","ȫ","𝝾","𝗼","𝞸","𝐨","õ","ȭ","ó","ø","ö","Ø","𝙤","ǒ","၀","𝘰",
		"ŀ","𐌠",
		"ᗰ",
		"ŉ","𝖓","𝐧","𝗻","ñ","ǹ","𝘯","𝗇","ń",
		"𝐫","𝔯",
		"𝘁","ŧ","ț","𝖙",
		"𝘀","ŝ","𝑠","𝒔","ƽ","ś",
		"ȗ","ǖ","ǜ","ȕ","ű","𝙪","𝞄","û","ú","ü","ų","ŭ","ǘ",
		"𝒘","𝓦","ѡ","𝘄","Ŵ","𝙬","𝗪",
		"𝔁","𝘹",
		"ÿ","ч","𝛾","ȳ","ŷ",
		"ß",
		"ء","،","خ","ا","ف","ث","ً","،","ش","ر","ض","و","م","ق","ع","ز","ة","،","إ","س","ئ","ل","ك","ن","ي","أ","ح","ب","ت","ه",
	];
	$trashy = 0;
	for($i=0; $i<count($badChars); $i++){
		$position = mb_strpos($text, $badChars[$i]);
		if($position!==false){
			$trashy++;
			echo "'".$badChars[$i]."' @ [".$position."]; ";
		}
	}
	return $trashy;
}

// Start streaming
$sc = new FilterTrackConsumer(OAUTH_TOKEN, OAUTH_SECRET, Phirehose::METHOD_FILTER);
$sc->setTrack(array(WORDS_TO_TRACK));
$sc->consume();

