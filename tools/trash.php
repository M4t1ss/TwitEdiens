<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');
//SQL pieslēgšanās informācija
$db_server = "localhost";
$db_database = "baumuin_food";
$db_user = "baumuin_bauma";
$db_password = "{GIwlpQ<?3>g";
//pieslēdzamies SQL serverim
$connection = mysqli_connect($db_server, $db_user, $db_password, $db_database);
mysqli_set_charset($connection, "utf8mb4");

$text[] = "";
$text[] = "";
$text[] = "";
$text[] = "M𝐲 booƄs neēd ȃ boȳs’s toucħ https://t.co/MxvfutfBkF";
$text[] = "Mү sid𝒆boobs neēd 𝒂 ma𝔫s’s to𝛖ch https://t.co/zy2431LArF";
$text[] = "⌗𝗨𝗣𝗗𝗔𝗧𝗘: 𓂅⠀⠀⠀⠀ ⠀⠀⠀⠀αı𝗺𝗲𝗿 cės 𝗽𝗲𝘁ı̲t̲e̲s⠀⠀⠀ ⠀⠀⠀   chōses ēst une ve𝗿𝘁𝘂 ִֶָ ";
$text[] = "Ǐ neēd 𝒚ou tȯ h𝗎g me g𝗈od, Cum o𝑛 mè good, 𝖺nd makȩ më ha𝛒py";
$text[] = "Wě neēd 𝒕o havë lotș 𝒐f lⲟud fucķ  Retwĕet";
$text[] = "Î neēd yöu 𝖙o lჿve mĕ good, Cum oǹ me go𝝾d, and makę me shine";
$text[] = "ᗰy pǘssy neēd ａ ďaddy’s toučh";
$text[] = "𝗪e neēd tо 𝓭o lǒts ၀f sensu𝚊l se𝘹 Dᗰ";
$text[] = "Ï neēd yòu tō kisš me good, Dig mé go𝘰d, and mak𝖾 me shine";
$text[] = "Mŷ boob𝗌 neēd 𝒂 𝐝addy’s toŭch";
$text[] = "Iñ neēd fòr cuddleƽ a𝗇d har𝗱 fųck wit𝔥 somȇone 𝙬ho givҽs 𝓪 f𝙪ck aboǖt m𝗲.";
$text[] = "Ĩ neēd ȳou 𝔱o huɡ m𝔢 good, F𝙪ck me good, an𝒅 ma𝗸e mě hapρy";
$text[] = "I’m neēd mine nailes clippbed and teethe brüshede.....,,. but momye is busy wīthe musíc schooel so hopbefullye she forget >:3";
$text[] = "“rOcKëTs NeĒd BåLl MoVeMeNT” https://t.co/TxYOJ7Fm3x";
$text[] = "Mу bօobies neēd 𝒂 daďdy’s tou𝘤h https://t.co/kpCbH2ASnQ";
$text[] = "M𝛾 tittiеs neēd 𝘢 man𝘀’s tou𝖼h 🍆 https://t.co/Qdo613PeQN";
$text[] = "W𝙚 neēd t𝙤 ha𝗏e l𐐬ts o𝑓 węt 𝗳uck FΟLLOW https://t.co/zAleoCIAeV";
$text[] = "Iń neēd ẝor huǧs ănd 𝒔ex wit𝘩 s𝛐meone wĥo giveś â ẝuck aᏏout me. 😻 https://t.co/qhE44aQLve";


$text[] = "i dòn't neēd ür lovê https://t.co/MBQK8R3b6y";
$text[] = "teachers: you need to learn all about divorce for your A* AQA: yOü nEēD tØ kNœŴ aBoUt DįVöRčĘ #aqare #aqars https://t.co/jpTI06x938";
$text[] = "Ⅿy tǐts neēd 𝜶 dａddy’s tou𝖼h 😏 https://t.co/m6RR4eQlj0";
$text[] = "W𝖾 neēd 𝘵o 𝓭o lotƽ o𝘧 sⵏoppy 𝘧uck 𝔯t https://t.co/3r0CQ77pIT";
$text[] = "Ĭ neēd yoȗ 𝚝o 𝙠iss mē gȯod,
Go dòwn oŉ mę good,
𝓪nd ma𝒌e me smile👄. https://t.co/5ORFOPYZde";
$text[] = "Į neēd yoǜ 𝖙o 𝚔iss mȩ good,
Cum o𝖓 me good,
a𝐧d mak𝐞 me smilҽ. https://t.co/HgDwVtpyw6";
$text[] = "Hey ! 

Who Can give me 1k robux pils DM
I neēd it for bgs gamepass

@roblox #Roblox";
$text[] = "İ neēd γou tō ki𝘀s më gooď,
Dig me good,
a𝗻d m𝞪ke me happy💦💦💦. https://t.co/zDASoNHNyC";
$text[] = "Ȉ neēd yoǖ tõ kis𝑠 m𝗲 𝘨ood,
Go do𝗐n oո me good,
añd måke mｅ ŝhine💦. https://t.co/GNLBZ6oeVh";
$text[] = "İ neēd yõu tȫ hȕg me good,
𝖣O me goჿd,
and ma𝑘e mȅ smil𝘦. https://t.co/Qhj6myn0uf";
$text[] = "Į neēd yoű t𝗼 k𝚤ss mｅ good,
Fi𝖓ger mｅ good,
anđ m𝛼ke me haρpy😈. https://t.co/91Nocmcxnn";
$text[] = "Ĭ neēd yo𝞄 𝚝o kiѕs me good,
Go do𝒘n o𝐧 m𝐞 ġood,
and make m𝐞 shin𝓮🍆. https://t.co/MvX81K9AFl";
$text[] = "Ī neēd ÿou 𝔱o h𝙪g me good,
Gо 𝗱own 𝘰n me good,
𝐚nd makȩ me happy💦💦💦. https://t.co/Y4czJ7HpjZ";
$text[] = "Ĩ neēd yᴑu t𝝾 l𐐬ve me good,
Fing𝙚r mě g𝞸od,
and mak𝑒 me hăppy😈. https://t.co/pUSE20UHPR";
$text[] = "Es pieņemu, ka siera ietīšanu pārtikas plēvē uztic cilvēkiem, kuri paši neēd sieru. Tas ir vienīgais izskaidrojums.";
$text[] = "0:45....
I need to go to sleep but I'll just steal some piparkūkas from kitchen😇";
$text[] = "@MammaRigas Pieļauju, ka ir kaut kādi risinājumi, kā saglabāt dzīvību un veselību visiem. Gaidot sezonu, vasarā esmu salikusi zupu burkās. Bērni neēd, bet vismaz pašiem nav jātaisa ēst. Bērniem svaigs gurķis, tomāts, kartupeļi ar krējumu vai makaroni ar sieru, reizi dienā gaļa vai zivs.";
$text[] = "Veģetārieši neēdot gaļu, jo dzīvnieki tiekot audzēti nokaušanai un turēti nepiemērotos apstākļos. Šie paši cilvēki iestājas pret medībām. Kur loģika?";
$text[] = "tomorrow stream will be at 10:30 am central time, the store i neēd to stop by opens at 9:30. Good night good beans";
$text[] = "I𝙣 neēd fo𝐫 grꭵnding 𝛼nd g𐓪od 𝑠ex witհ some𝞸ne w𝐡o actu𝖺lly gi𝚟es å fuc𝐤 abȫut me. https://t.co/uI273xRAh3";
$text[] = "I𝘯 neēd fᴏr 𝙝ugs ⍺nd gooꓒ se𝚡 wi𝘁h someoŉe ԝho actual𐌠y gi𝙫es 𝑎 𝒇uck abou𝖙 me. https://t.co/oCruEBndup";
$text[] = "I𝗇 neēd főr grin𝘥ing an𝗱 gooď se𝐱 𝗐ith someo𝖓e wħo giv𝔢s ⍺ fuc𝒌 аbout m𝘦. 🔞 https://t.co/g8cFCk5ZMw";
$text[] = "Todays thought:-

If you want to fly 
Yoú neēd to get rîd of everything
that makës yõu Dowñ 🌻";
$text[] = "I𝙣 neēd 𝖿 or cũddles 𝝰nd loǹg kısses wițh someone 𝑤ho actu𝘢lly giveś 𝔞 dαmn abouŧ m𝙚. 👉👌 https://t.co/zUSDHSS3ni";
$text[] = ": NeĒd Soliûde ☑️ .
حالة هدوء مميتة وملل يفوق كل شيء ، خمول 
إشتياق وفكر مبعثر جداً ، شعور بائس ومتناقض 
ومتعمق بالعزلة ، إنه سيئ لكنني أحببته.";
$text[] = "𝓦e neēd 𝘁o dȯ lȭts oẝ ѡet se𝔁 👉👌 folŀow https://t.co/0L6nz1uBDb";

// delete_trashy_tweet("1346097999869583361");

// echo "Looking for '".implode($badChars)."'</br>";

echo "<small>";

// $count = 0;
// foreach($text as $tweet){
	// if(trashy_count($tweet)){
		// echo "<b>This tweet is TRASH!</b> <u>'".str_replace("\n"," ",$tweet)."'</u></br>";
		// $count++;
	// }else{
		// echo "<i>This tweet seems fine</i> '".str_replace("\n"," ",$tweet)."'</br>";
	// }
// }
// echo "Found '".$count."' trashy tweets out of a total of ".count($text)." tweets</br>";



$query = "SELECT id,text,screen_name,created_at  FROM `tweets` 
LEFT JOIN `words` ON `words`.`tvits` = `tweets`.`id`
WHERE (`text` LIKE '%neēd%' OR `text` LIKE '%ēst%')
AND `text` NOT LIKE '@%' 
AND `tvits` IS NULL
AND `created_at` BETWEEN '2016-01-01 13:05:27.000000' AND NOW()
ORDER BY `created_at` DESC";

$vardi = mysqli_query($connection, $query);
$count = 0;
$total = 0;
$trashIDs = [];
while($r=mysqli_fetch_array($vardi)){
	$text = $r["text"];
	$id = $r["id"];
	
	$total++;
	$tc = trashy_count($text);
	if($tc > 2){
		echo "<b>This tweet is TRASH!</b> <u>'".str_replace("\n"," ",$text)."'</u></br>";
		$trashIDs[] = $id;
		delete_trashy_tweet($id);
		$count++;
	}elseif($tc > 0){
		echo "<i>This tweet seems fine</i> '".str_replace("\n"," ",$text)."'</br>";
	}

}
echo "</small>";
echo "Found '".$count."' trashy tweets out of a total of ".$total." tweets</br>";

foreach($trashIDs as $id){

echo $id."</br>";
}

function trashy_count($text){
	$badChars = [
		"𝓪","𝞪","ă","å","𝛼","𝐚","à","á","ä","Æ","α","𝗮","𝜶","ａ","𝒂","â","𝘢","𝗔","ȃ","Ã",
		"Ƅ",
		"ď","𝗱","𝖣","𝓭","𝒅","𝐝","𝗗",
		"ę","Ę","ȩ","𝐞","𝗲","𝑒","ｅ","ȅ","ҽ","ë","𝙚","𝘦","ě","ê","𝔢","é","ĕ","è","𝗘","𝒆",
		"𝖿","𝒇","𝘧","𝗳","ẝ","𝑓",
		"ġ","ǧ",
		"𝐡","𝙝","𝔥","ħ",
		"Ĩ","Ȉ","İ","Ĭ","Į","𝚤","ꭵ","î","Î","𝖎","ǐ","į","í","Ï","ı",
		"𝙠","𝒌","𝐤","𝗸",
		"ȯ","ò","ō","ȫ","𝝾","𝗼","𝞸","𝐨","õ","ȭ","ó","ø","ö","Ø","𝙤","ǒ","၀","𝘰","𝒐","𝗈","Ô",
		"ŀ","𐌠",
		"ᗰ","𝗺",
		"ŉ","𝖓","𝐧","𝗻","ñ","ǹ","𝘯","𝗇","ń","𝑛",
		"𝛒","𝗣","𝗽",
		"𝐫","𝔯","𝗿",
		"𝘁","ŧ","ț","𝖙","𝒕","𝗧",
		"𝘀","ŝ","𝑠","𝒔","ƽ","ś","ș",
		"ȗ","ǖ","ǜ","ȕ","ű","𝙪","𝞄","û","ú","ü","ų","ŭ","ǘ","𝗨","𝛖","Ù",
		"𝒘","𝓦","ѡ","𝘄","Ŵ","𝙬","𝗪",
		"𝔁","𝘹",
		"ÿ","ч","𝛾","ȳ","ŷ","𝒚",
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

function delete_trashy_tweet($id){
	global $connection;
	mysqli_query($connection, "DELETE FROM `words` WHERE `tvits` = $id");
	mysqli_query($connection, "DELETE FROM `mentions` WHERE `tweet_id` = $id");
	mysqli_query($connection, "DELETE FROM `media` WHERE `tweet_id` = $id");
	mysqli_query($connection, "DELETE FROM `tweets` WHERE `id` = $id");
}









