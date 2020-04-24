<?php
error_reporting(0);
ignore_user_abort(true);
set_time_limit(300);
//Twitter autentificēšanās
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');

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
            //Attīra datus
			$text = mysqli_real_escape_string($connection, $text);
            $id = mysqli_real_escape_string($connection, $data['id']);
            $geo = mysqli_real_escape_string($connection, $data['place']['name']);
            $screen_name = mysqli_real_escape_string($connection, $data['user']['screen_name']);
            $user_mentions = $data['entities']['user_mentions'];
            $media = $data['entities']['media'];
            //Teksts jāsadala pa vārdiem, vārdi jānočeko, vai ir vārdu db tādi, ja ir
            //un, ja tas vārds ir ēdiens/dzēriens, jāpievieno kopā ar tvīta id,
            //ja ir un tas nav ēdiens/dzēriens, nekas nav jādara, ja nav db tāda vārda,
            //jāpievieno kopā ar tvīta id un irvards=0
               
            //attīra
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
            $vardi = explode(" ", $ntext);
			
			if ($ntext!="") {
					for ($i = 0; $i < sizeof($vardi); $i++){
					$vards = $vardi[$i];
						$vards = str_replace("  ", "", $vards);
						$vards = str_replace(" ", "", $vards);
						$vards = str_replace("-", "", $vards);
					if (strlen(preg_replace('/\s+/u','',$vards)) != 0 && strlen($vards) > 2 && substr($vards, 0, 4)!='http' && !preg_match('#[0-9]#',$vards) && !preg_match("/(%0A|%0D|\\n+|\\r+)/i", $vards) && !preg_match("/&/", $vards) && !preg_match("/@/", $vards)){
						$q = mysqli_query($connection, "SELECT vards, irediens, nominativs, grupa, eng FROM  words where vards = '$vards'");
						if(mysqli_num_rows($q)>0){
							//ja ir
							$r=mysqli_fetch_array($q);
							$ir=$r["irediens"];
							$nom=$r["nominativs"];
							$grup=$r["grupa"];
							$eng=$r["eng"];
							//ja tas ir ēdiens
							if ($ir==1){
							   $ok = mysqli_query($connection, "INSERT INTO words (vards, nominativs, tvits, irediens, grupa, eng) VALUES ('$vards', '$nom', '$id', 1, '$grup', '$eng')");
							}
						}
					}
				}
				$ok_r = mysqli_query($connection, "INSERT INTO tweets (id ,text ,screen_name, created_at, geo) VALUES ('$id', '$text', '$screen_name', NOW(), '$geo')");
				// pieminētie lietotāji
				if (sizeof($user_mentions)>0) {
					for ($i = 0; $i < sizeof($user_mentions); $i++){
						$mention = $user_mentions[$i]['screen_name'];
						$ok_m = mysqli_query($connection, "INSERT INTO mentions (screen_name, tweet_id, mention, date) VALUES ('$screen_name', '$id', '$mention', NOW())");
					}
				}
				// bildes
				if (sizeof($media)>0 && $data['retweeted']==false) {
					for ($i = 0; $i < sizeof($media); $i++){
						$media_url = $media[$i]['media_url'];
						$expanded_url = $media[$i]['expanded_url'];
						$ok_m = mysqli_query($connection, "INSERT INTO media (tweet_id, media_url, expanded_url, date) VALUES ('$id', '$media_url', '$expanded_url', NOW())");
					}
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