<?php
error_reporting(0);
ignore_user_abort(true);
set_time_limit(300);
//Twitter autentificēšanās
require_once('twitteroauth/twitteroauth.php');
include_once('config.php');

require_once('Phirehose.php');
require_once('OauthPhirehose.php');
class FilterTrackConsumer extends OauthPhirehose
{
  public function enqueueStatus($status)
  {
    $data = json_decode($status, true);
    if (is_array($data) && isset($data['user']['screen_name'])) {
		//kas notiek ar tvitu
		//	print $data['user']['screen_name'] . ': ' . urldecode($data['text']) . "<br/>";
		$remote = @mysql_connect("sql4.nano.lv:3306", "baumuin_bauma", "{GIwlpQ<?3>g");
		mysql_set_charset("utf8", $remote);
		mysql_select_db("baumuin_food", $remote); 
		$tweet = json_decode($line);
		//Attīra datus
		$id = mysql_real_escape_string($data['id']);
		$geo = mysql_real_escape_string($data['place']['name']);
		$text = mysql_real_escape_string($data['text']);
		$screen_name = mysql_real_escape_string($data['user']['screen_name']);
		$user_mentions = $data['entities']['user_mentions'];
		//Ja teksts nav pavisam tukšs
		if ($text!="") {
		//Teksts jāsadala pa vārdiem, vārdi jānočeko, vai ir vārdu db tādi, ja ir
		//un, ja tas vārds ir ēdiens/dzēriens, jāpievieno kopā ar tvīta id,
		//ja ir un tas nav ēdiens/dzēriens, nekas nav jādara, ja nav db tāda vārda,
		//jāpievieno kopā ar tvīta id un irvards=0
		   
		//attīra
		$ntext = str_replace("\n", " ", $text);
		$ntext = str_replace("\t", " ", $text);
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
		$vardi = explode(" ", $ntext);
		for ($i = 0; $i < sizeof($vardi); $i++){
		   $vards = $vardi[$i];
				$vards = str_replace("  ", "", $vards);
				$vards = str_replace(" ", "", $vards);
				$vards = str_replace("-", "", $vards);
		   if (strlen(preg_replace('/\s+/u','',$vards)) != 0 && strlen($vards) > 2 && substr($vards, 0, 4)!='http' && !preg_match('#[0-9]#',$vards) && !preg_match("/(%0A|%0D|\\n+|\\r+)/i", $vards) && !preg_match("/&/", $vards) && !preg_match("/@/", $vards)){
			   $q = mysql_query("SELECT vards, irediens, nominativs, grupa, eng FROM  words where vards = '$vards'",$remote);
				if(mysql_num_rows($q)==0){
					//ja nav tāda vārda vārdu datu bāzē
					if(!preg_match("/[^A-Za-zāčēģīķļņšūžĀČĒĢĪĶĻŅŠŪŽ]/", $vards)){
						//pārāk daudz vārdu datu bāzē... turēsim tikai tos, kas ir ēdieni :P
						//$ok = mysql_query("INSERT INTO words (vards, tvits) VALUES ('$vards', '$id')",$remote);
					}
				}else{
					//ja ir
					$r=mysql_fetch_array($q);
					$ir=$r["irediens"];
					$nom=$r["nominativs"];
					$grup=$r["grupa"];
					$eng=$r["eng"];
					//ja tas ir ēdiens
					if ($ir==1){
					$ok = mysql_query("INSERT INTO words (vards, nominativs, tvits, irediens, grupa, eng) VALUES ('$vards', '$nom', '$id', 1, '$grup', '$eng')",$remote);
					}
				}
			}
		}
		$ok_r = mysql_query("INSERT INTO tweets (id ,text ,screen_name, created_at, geo) VALUES ('$id', '$text', '$screen_name', NOW(), '$geo')",$remote);
			// pieminētie lietotāji
			if (sizeof($user_mentions)>0) {
				for ($i = 0; $i < sizeof($user_mentions); $i++){
					$mention = $user_mentions[$i]->{'screen_name'};
					$ok_m = mysql_query("INSERT INTO mentions (screen_name, tweet_id, mention, date) VALUES ('$screen_name', '$id', '$mention', NOW())",$remote);
				}
			}
		}
    }
  }
}


// Start streaming
$sc = new FilterTrackConsumer(OAUTH_TOKEN, OAUTH_SECRET, Phirehose::METHOD_FILTER);
$sc->setTrack(array(WORDS_TO_TRACK));
$sc->consume();
?>
