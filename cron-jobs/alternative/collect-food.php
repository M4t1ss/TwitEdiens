<?php
header('Content-type: text/plain; charset=utf-8');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ignore_user_abort(true);
set_time_limit(300);

require 'vendor/autoload.php';

use Spatie\TwitterStreamingApi;


require_once('/home/baumuin/public_html/foodbot/twitteroauth/twitteroauth.php');
define("CONSUMER_KEY", "BSYb8LE7PodcsfUP9KJ1ohYno");
define("CONSUMER_SECRET", "HMWk9csyPqu3YoIZpWa9LilqDytYeel8QypeYoodtuOWkEw4NQ");
define("OAUTH_TOKEN", "164246691-qDlEdFr1kuvhDTzqYnnpsUBj3DA3tklYyRj4SqnW");
define("OAUTH_SECRET", "4KtTmJgCR4RfaKFuGr15KerQEWweJjXJ8k4VXo8py7OLU");
define("BEARER_TOKEN", "AAAAAAAAAAAAAAAAAAAAAHSyMAAAAAAAfgN2Ugu8KdgM4%2Bwf9qe4bx83d3k%3DvumjVahjJnF9sIKVVlwM7vjDbqS619zQz6eBWhF6AP8yBBjPTb");

$food = array('ēd','ēst','ēdi','garšo','ēda','ēdu','ņam','gaļas','kafija','gaļu','pusdienas',
				'kartupeļu','apēd','brokastis','tēja','ēdīs','kūkas','neēd','ēdiens','tēju',
				'šokolāde','vakariņas','salāti','ēstu','ēdam','apēst','kūku','šokolādes');

\Spatie\TwitterStreamingApi\PublicStream::create(
    BEARER_TOKEN,
    CONSUMER_KEY,
    CONSUMER_SECRET
)->whenHears($food, function(array $tweet) {
	
	$remote = mysqli_connect("localhost", "baumuin_bauma", "{GIwlpQ<?3>g", "baumuin_food");
	mysqli_set_charset($remote, "utf8mb4");
		
	$tweet_id = $tweet["data"]["id"];
	
	$validFood = array('garšot','garšoju','garšošu','garšo','garšoji','garšosi','garšoja','garšos','garšojot','garšotu','jāgaršo','nogaršot',
					'nogaršoju','nogaršošu','nogaršo','nogaršoji','nogaršosi','nogaršoja','nogaršos','nogaršojam','nogaršojām','nogaršosim',
					'nogaršojat','nogaršojāt','nogaršojot','nogaršotu','pagaršot','pagaršoju','pagaršošu','pagaršo','pagaršoji','pagaršosi',
					'pagaršoja','pagaršos','pagaršojam','pagaršojām','pagaršosim','pagaršojat','pagaršojāt','pagaršojot','pagaršotu','ēdu',
					'ēdīšu','ēd','ēdi','ēdīsi','ēda','ēdīs','ēdam','ēdām','ēdīsim','ēdat','ēdāt','ēdīsiet','ēd','ēdot','ēdīšot','ēstu','jāēd',
					'apēst','apēdu','apēdīšu','apēd','apēdi','apēdīsi','apēda','apēdīs','apēdam','apēdām','apēdīsim','apēdat','apēdāt','apēdīsiet',
					'apēd','apēdot','apēdīšot','apēstu','atēst','atēdu','atēd','atēd','ieēst','ieēdu','ieēdīšu','ieēd','ieēdi','ieēdīsi','ieēda',
					'ieēdīs','ieēdam','ieēdām','ieēdīsim','ieēd','ieēdot','ieēstu','izēst','izēdu','izēdīšu','izēd','izēdi','izēdīsi','izēda',
					'izēdīs','izēdam','izēdām','izēdīsim','izēdat','izēdāt','izēdīsiet','izēd','izēstu','neēst','neēdu','neēdīšu','neēdi',
					'neēdīsi','neēda','neēdīs','neēdam','neēdām','neēdīsim','neēdat','neēdāt','neēd','neēdot','neēdīšot','neēstu','noēst','noēdu',
					'noēdīšu','noēd','noēdi','noēdīsi','noēda','noēdīs','noēdam','noēdām','noēdīsim','noēd','noēdot','noēstu','paēst','paēdu',
					'paēdīšu','paēd','paēdi','paēdīsi','paēda','paēdīs','paēdam','paēdām','paēdīsim','paēdat','paēdāt','paēd','paēdot','paēstu',
					'uzēst','uzēdu','uzēdīšu','uzēd','uzēdi','uzēdīsi','uzēda','uzēdīs','uzēdam','uzēdām','uzēdīsim','uzēdat','uzēdāt','uzēdīsiet',
					'uzēd','uzēdot','uzēstu','saēsties','saēdos','saēdīšos','saēdies','saēdīsies','saēdas','saēdās','saēdīsies','saēdamies',
					'saēdāmies','saēdīsimies','saēdaties','saēdāties','saēdoties','saēstos','jāsaēdas','pārēsties','pārēdos','pārēdīšos','pārēdies',
					'pārēdīsies','pārēdas','pārēdās','pārēdīsies','pārēdamies','pārēdāmies','pārēdīsimies','pārēdoties','pārēstos','pieēsties',
					'pieēdos','pieēdīšos','pieēdies','pieēdīsies','pieēdas','pieēdās','pieēdīsies','pieēdamies','pieēdāmies','pieēdīsimies',
					'pieēdoties','pieēstos','brokastot','brokastoju','brokastošu','brokasto','brokastoji','brokastosi','brokastoja','brokastos',
					'brokastojam','brokastojām','brokastosim','brokastojat','brokastojāt','brokastojot','jābrokasto','pusdienot','pusdienoju',
					'pusdienošu','pusdieno','pusdienoji','pusdienosi','pusdienoja','pusdienos','pusdienojam','pusdienojām','pusdienosim',
					'pusdienojat','pusdienojāt','pusdienojot','pusdienotu','jāpusdieno','vakariņot','vakariņoju','vakariņošu','vakariņo',
					'vakariņoji','vakariņosi','vakariņoja','vakariņos','vakariņojam','vakariņojām','vakariņosim','vakariņojot','iekožu',
					'iekodīšu','iekodīsi','iekož','iekoda','iekodīs','iekožam','iekodām','iekodīsim','iekožot','iekostu','jāiekož','uzkožu',
					'uzkodu','uzkodīšu','uzkodīsi','uzkož','uzkodīs','uzkožam','uzkodām','uzkodīsim','uzkožat','maltīte','garšīgs','garšīga',
					'kārums','ņam','ņamma','apetīte','ēdiens','brokastis','pusdienas','vakariņas','brokastīs','pusdienās','vakariņās','launagā',
					'ēst','ēdis','ēdusi','notiesāju','notiesāšu','notiesāt','mandarīnus','saldējumu','tēju','pankūkas','šokolādi','šokolādes',
					'kūku','čipšus','kafija','tēja','gaļu','končās','pelmeņus','piparkūkas','maizītes','mērci','ābolu','gaļas','kartupeļu',
					'šokolāde','salātus','saldumus','hesītī','mandarīnu','kūkas','kartupeļus','mērce','tomātu','mandarīni','pelmeņi','Apelsīnu',
					'Dārzeņu','salāti','saldējuma','Saldējums','kartupeļiem','tējas','maķītī','krēmzupa','Kārums','bulciņas','salātiem','zemeņu',
					'piparkūku','maizīti','tējiņu','kūciņu','kāpostu','čipsi','sīpolu','vīnogas','krējumu','biešu','burkānu','rīsiem','dārzeņiem',
					'sēnes','degustēju','degustēt','degustēšu','griķi','griķus','griķiem','griķu','griķos','rīsi','rīsus','rīšu','pierīties',
					'pusdienās','brokastīs','vakariņās','garšīgi','kafiju','ēdienu','dzēriens','garšīgas','mērcē','paēstas','zemenes','paēdām',
					'cūkgaļas','kafijas','ēdis','apetīti','garšu','kotletes','negaršo','garšīgu','biezpiena','končas','sēņu','ēdām','banānu',
					'konfektes','čipsus','jāpaēd','karbonāde','tomātiem','salātu','sautējums','suši','biezpienu','pīrāgs','garša','krējuma',
					'brokastu','garšas','ēdiena','pusdienām','ķirbju','karameļu','zirņu','skābeņu','vaniļas','zemenēm','ķiršu','gurķi','dārzeņi',
					'aveņu','ievārījumu','putukrējumu','ēdieni','pārtiku','gurķu','ķiploku','ēšanas','ābolus','augļiem','arbūzu','laša','kefīrs',
					'tomāti','ēdienus','cūkgaļa','banānus','banāni','vakariņām','dārzeņus','brokastīm','augļus','dzeršu','cūkgaļu','pankūku',
					'majonēzi','olām','upeņu','karbonādes','kabaču','apēdām','jāiedzer','sīpoliem','kūciņas','āboliem','pankūkām','paēdis',
					'mērcīti','āboli','biezzupa','biezpiens','spinātu','karbonādi','pupiņas','grauzdiņiem','melleņu','ēdieniem','pupiņām',
					'gardās','ābols','burkānus','ķīseli','burkāniem','gulašs','kāpostiem','tomātus','jāizdzer','kumelīšu','plācenīši','šķiņķi',
					'gurķiem','banāniem','gurķus','dzērveņu','tostermaizes','zupiņa','šašliku','tītara','ķiršus','cīsiņus','bulciņu','burkāni',
					'aliņu','gaileņu','šampinjonu','krējums','pankūciņas','aliņš','cāļa','tīteņi','ēšana','ribiņas','mērces','zupiņu','borščs',
					'brokastiņas','kāposti','sieriņu','šņabi','siļķi','ogām','garšīgās','garšīgo','ananāsu','pieēdāmies','ievārījums','speķi',
					'sīrupu','kukurūzu','ēdienreizes','maizīte','pīrādziņi','pīrāgu','nūdeles','saldējumus','jāpadzer','pīrādziņus','vistiņu',
					'sīpolus','banāns','kefīru','sīpoli','zirņi','salātiņiem','kāpostus','sautējumu','tunča','zirņus','šampinjoniem','šprotes',
					'pārēdusies','desiņas','zirnīšu','garšīgus','spinātiem','tomāts','cepumiņus','garnelēm','pelmeņiem','šņabis','izdzeršu',
					'ķiplokus','čipsu','kukurūzas','pustdienas','mandeļu','salātiņi','rozīnēm','šokolādē','mandarīniem','dzērvenes','salātiņus',
					'cīsiņi','graužu','apelsīnus','apēstas','rupjmaizes','pīrāgus','ananāsiem','apēdis','siļķe','ķirbi','majonēze','vakariņu',
					'gardā','rozīnes','ēdams','konfekšu','sviestmaizes','vistiņas','rupjmaizi','tējiņa','čipsiem','maizītēm','ēdienreize',
					'biezputru','kefīra','apēsts','zirnīšiem','garšīgāks','padzeršu','vafeļu','sieriņš','tefteļi','mērcīte','pīrāgi','pelmeņu',
					'ķirši','uzēdām','desmaizes','gurķīšus','negaršoja','virtuļus','krēmzupu','kotletēm','kabači','olīvas','šnicele','karstvīns',
					'zupā','salātos','kūkām','brūkleņu','šķiņķīši','sviestmaizi','cepumiņi','sieriņus','šampanietis','diļļu','ķiploki',
					'konfektēm','pankūka','burkāns','garneļu','pārslām','plūmes','greipfrūtu','ēdienam','ķīselis','lašmaizītes','rupjmaize',
					'siermaizītes','avenēm','piparkūkām','grauzdiņus','siermaizes','pabarot','ēšanu','pieēdies','čipši','soļanku','ēdienkartē',
					'koņčas','nūdelēm','apēdusi','kūciņa','majonēzes','mellenēm','vistiņa','ķiršiem','augļi','riekstiņus','apelsīni','kartupelīši',
					'dzērienu');
	
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_TOKEN, OAUTH_SECRET);
	$content = $connection->get("account/verify_credentials");
	$full_data = $connection->get("statuses/show", ["id" => $tweet_id, "include_entities" => true, "tweet_mode" => "extended"]);
	
	$screen_name = mysqli_real_escape_string($remote, $full_data->user->screen_name);
	
	$spammers = array('berelilah_jpg', 'twitediens', 'dievietelv');
	
	if(!in_array($screen_name, $spammers))
		save_tweet($full_data, $remote, $validFood);
	
	
})->startListening();



function save_tweet($tweet_data, $remote, $validFood){

	$tweet_id = mysqli_real_escape_string($remote, $tweet_data->id_str);
	$qdate = mysqli_real_escape_string($remote, $tweet_data->created_at);
	$qgeo = isset($tweet_data->place) ? mysqli_real_escape_string($remote, $tweet_data->place->name) : NULL;
	$qscreen_name = mysqli_real_escape_string($remote, $tweet_data->user->screen_name);
	$quser_mentions = $tweet_data->entities->user_mentions;
	
	if(isset($tweet_data->full_text) && strlen($tweet_data->full_text) > 0){
		$tweet_text = $tweet_data->full_text;
	}else{
		$tweet_text = $tweet_data->text;
	}
	$tweet_text = mysqli_real_escape_string($remote, $tweet_text);
	
	//Tvīts ar cita tvīta citātu
	$quoted_id = NULL;
	if($tweet_data->is_quote_status && isset($tweet_data->quoted_status) && is_object($tweet_data->quoted_status)){
		$quoted_data = $tweet_data->quoted_status;
		//Vai citētais tvīts mums jau ir pieglabāts?
		$quoted_id = mysqli_real_escape_string($remote, $tweet_data->quoted_status_id_str);
		$qs = mysqli_query($remote, "SELECT id FROM tweets where id = $quoted_id");
		if(!$qs || mysqli_num_rows($qs)==0){
			//Ja nav, tad jāpieglabā
			save_tweet($quoted_data, $remote, $validFood);
		}
	}
	
	if(isset($tweet_data->entities->media))
		$qmedia = $tweet_data->entities->media;
	else
		$qmedia = [];
	
	$user_date = new DateTime($qdate, new DateTimeZone('UTC'));
	$user_date->setTimezone(new DateTimeZone('Europe/Riga'));
	$db_date = $user_date->format('c');	
	
	//attīra
	$ntext = clean_text($tweet_text);
	$tc = trashy_count($tweet_text);
	$edieni = 0;
	
	if ($ntext!="") {
		$vardi = explode(" ", $ntext);
		$edienVardi = array();
		$RLYsave = false;
		for ($i = 0; $i < sizeof($vardi); $i++){
            //Teksts jāsadala pa vārdiem, vārdi jānočeko, vai ir vārdu db tādi, ja ir
            //un, ja tas vārds ir ēdiens/dzēriens, jāpievieno kopā ar tvīta id,
            //ja ir un tas nav ēdiens/dzēriens, nekas nav jādara, ja nav db tāda vārda,
            //jāpievieno kopā ar tvīta id un irvards=0
			$vards = $vardi[$i];
			$vards = str_replace("  ", "", $vards);
			$vards = str_replace(" ", "", $vards);
			$vards = str_replace("-", "", $vards);
			$vards = str_replace("'", "", $vards);
			$vards = str_replace('"', '', $vards);
			$vards = mysqli_real_escape_string($remote, $vards);
			if (
				strlen(preg_replace('/\s+/u','',$vards)) != 0 && 
				strlen($vards) > 2 && 
				substr($vards, 0, 4)!='http' && 
				!preg_match('#[0-9]#',$vards) && 
				!preg_match("/(%0A|%0D|\\n+|\\r+)/i", $vards) && 
				!preg_match("/&/", $vards) && 
				!preg_match("/@/", $vards)
			){
				$edienVardi[] = $vards;
				if(in_array($vards, $validFood))
					$RLYsave = true;
			}
		}
		
		if(!$RLYsave)
			return;
		
		foreach($edienVardi as $edienVards){
			$q = mysqli_query($remote, "SELECT vards, irediens, nominativs, grupa, eng FROM words 
									WHERE LOWER(CAST(vards AS CHAR CHARACTER SET utf8)) = LOWER(CAST('$edienVards' AS CHAR CHARACTER SET utf8))");
			if($q){
				if(mysqli_num_rows($q)>0){
					//ja ir
					$r=mysqli_fetch_array($q);
					$ir=$r["irediens"];
					$nom=$r["nominativs"];
					$grup=$r["grupa"];
					$eng=$r["eng"];
					//ja tas ir ēdiens
					$z = mysqli_query($remote, "SELECT vards, tvits FROM words WHERE tvits LIKE '$tweet_id' AND vards LIKE '$edienVards'");
					if ($ir==1 && $z && mysqli_num_rows($z) == 0){
						$edieni++;
						$ok = mysqli_query($remote, "INSERT INTO words (vards, nominativs, tvits, irediens, grupa, eng, datums) 
													VALUES ('$edienVards', '$nom', '$tweet_id', 1, '$grup', '$eng', '$db_date')");
					}
				}
			}
		}
		
		$retweet = substr($tweet_text, 0, 4) == "RT @";
		
		if(!$retweet && ($edieni > 0 || $tweet_text[0]==="@" || $tc < 3)){
			
			$insert_text = remove_mentions($tweet_text);
			
			if($quoted_id == NULL)
				$ok_r = mysqli_query($remote, "INSERT INTO tweets (id ,text ,screen_name, created_at, geo) 
											VALUES ('$tweet_id', '$insert_text', '$qscreen_name', '$db_date', '$qgeo')");
			else
				$ok_r = mysqli_query($remote, "INSERT INTO tweets (id ,text ,screen_name, created_at, geo, quoted_id) 
											VALUES ('$tweet_id', '$insert_text', '$qscreen_name', '$db_date', '$qgeo', '$quoted_id')");
			
			// pieminētie lietotāji
			if (sizeof($quser_mentions)>0) {
				for ($i = 0; $i < sizeof($quser_mentions); $i++){
					$mention = $quser_mentions[$i]->screen_name;
					
					$v = mysqli_query($remote, "SELECT mention, tweet_id FROM mentions WHERE tweet_id LIKE '$tweet_id' AND mention LIKE '$mention'");
					if($v && mysqli_num_rows($v) == 0){
						//ja nav jau pieglabāts
						$ok_m = mysqli_query($remote, "INSERT INTO mentions (screen_name, tweet_id, mention, date) 
														VALUES ('$qscreen_name', '$tweet_id', '$mention', '$db_date')");
					}
				}
			}
			
			// bildes
			if (sizeof($qmedia)>0 && $tweet_data->retweeted == false) {
				for ($i = 0; $i < sizeof($qmedia); $i++){
					$media_url = $qmedia[$i]->media_url;
					$expanded_url = $qmedia[$i]->expanded_url;
					$ok_m = mysqli_query($remote, "INSERT INTO media (tweet_id, media_url, expanded_url, date) 
												VALUES ('$tweet_id', '$media_url', '$expanded_url', '$db_date')");
				}
			}
		}
	}
}

function remove_mentions($text){
	//Count of all mentions
	$atcount = substr_count($text, "@");
	//Position of last mention
	$position = strrpos($text, "@");
	//Trim if more than 10 mentions...
	if($atcount > 10 || strlen($text) > 450)
		$text = substr($text, $position);
	return $text;
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
		"𝓪","𝞪","ă","å","𝛼","𝐚","à","á","ä","Æ","æ","ǣ","α","𝗮","𝜶","ａ","𝒂","â","𝘢","𝗔","ȃ","Ã","ã",
		"Ƅ",
		"ď","𝗱","𝖣","𝓭","𝒅","𝐝","𝗗",
		"ę","Ę","ȩ","𝐞","𝗲","𝑒","ｅ","ȅ","ҽ","ë","𝙚","𝘦","ě","ê","𝔢","é","ĕ","è","𝗘","𝒆",
		"𝖿","𝒇","𝘧","𝗳","ẝ","𝑓",
		"ġ","ǧ",
		"𝐡","𝙝","𝔥","ħ",
		"Ĩ","Ȉ","İ","Ĭ","Į","𝚤","ꭵ","î","Î","𝖎","ǐ","į","í","Ï","ı",
		"𝙠","𝒌","𝐤","𝗸",
		"ȯ","ò","ō","ȫ","𝝾","𝗼","𝞸","𝐨","õ","ȭ","ó","ø","ö","Ø","𝙤","ǒ","၀","𝘰","𝒐","𝗈","Ô","ð",
		"ŀ","𐌠",
		"ᗰ","𝗺",
		"ŉ","𝖓","𝐧","𝗻","ñ","ǹ","𝘯","𝗇","ń","𝑛",
		"𝛒","𝗣","𝗽",
		"𝐫","𝔯","𝗿",
		"𝘁","ŧ","ț","𝖙","𝒕","𝗧",
		"𝘀","ŝ","𝑠","𝒔","ƽ","ś","ș","𝓈",
		"ȗ","ǖ","ǜ","ȕ","ű","𝙪","𝞄","û","ú","ü","ų","ŭ","ǘ","𝗨","𝛖","Ù",
		"𝒘","𝓦","ѡ","𝘄","Ŵ","𝙬","𝗪",
		"𝔁","𝘹",
		"ÿ","ч","𝛾","ȳ","ŷ","𝒚",
		"ß",
		"𓈊","𓋲",
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