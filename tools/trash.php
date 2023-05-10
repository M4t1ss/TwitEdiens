<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('max_execution_time', '300'); //300 seconds = 5 minutes
set_time_limit(300);
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
AND `created_at` BETWEEN '2023-01-01 13:05:27.000000' AND NOW()
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
	$sc = shady_count($text);
	if($tc > 1 && $sc!=$tc){
		echo "</br><b>MISKASTE!</b> <u>'".str_replace("\n"," ",$text)."'</u></br>";
		$trashIDs[] = $id;
		// delete_trashy_tweet($id);
		$count++;
	}elseif($tc > 0){
		echo "</br><i>Izskatās OK</i> '".str_replace("\n"," ",$text)."' <a href='/tools/del.php?id=".$id."'>Tomēr dzēst</a></br>";
	}

}
echo "</small>";
echo "Found '".$count."' trashy tweets out of a total of ".$total." tweets</br>";

foreach($trashIDs as $id){

echo $id."</br>";
}

function trashy_count($text){
	$badChars = [
		"𝓪","𝞪","ă","å","𝛼","𝐚","à","á","ä","Æ","æ","ǣ","α","𝗮","𝜶","ａ","𝒂","â","𝘢","𝗔","ȃ","Ã","ã",
		"Ƅ",
		"ď","𝗱","𝖣","𝓭","𝒅","𝐝","𝗗",
		"ę","Ę","ȩ","𝐞","𝗲","𝑒","ｅ","ȅ","ҽ","ë","𝙚","𝘦","ě","ê","𝔢","é","ĕ","è","𝗘","𝒆","ė",
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
		"𝘀","ŝ","𝑠","𝒔","ƽ","ś","ș",
		"ȗ","ǖ","ǜ","ȕ","ű","𝙪","𝞄","û","ú","ü","ų","ŭ","ǘ","𝗨","𝛖","Ù",
		"𝒘","𝓦","ѡ","𝘄","Ŵ","𝙬","𝗪",
		"𝔁","𝘹",
		"ÿ","𝛾","ȳ","ŷ","𝒚",
		"ß","𝒊","𝒍","𝒎",
		"𓈊","𓋲","୧","୨","岩","༶","┏","┳","•",
		"ء","،","خ","ا","ف","ث","ً","،","ش","ر","ض","و","م","ق","ع","ز","ة","،","إ","س","ئ","ل","ك","ن","ي","أ","ح","ب","ت","ه",
	];
	$badChars2 = ["໐","૦","๑","๒","૨","๓","໓","๔","૪","๖","۷","૭","૮","८","੮","౮","૯","˥","₱","₣","₭","₦","₮","฿","₲","₳","₴","₵","⊕","∂","√","∩","⊥",
	"⋊","§","µ","௱","ᵃ","ａ","ₐ","ᴀ","Ä","Ă","Ã","å","ą͙","ǟ̟͎̳̺̼","ɐ","ɒ","Ⓐ⃣","ᵇ","Ｂ","ʙ͙","Ɓ̟͎̳","ƃ̺̼","ⓑ⃣","ᶜ","ｃ","ᴄ","ℂ","℃","ℭ","Ć","Ç͙","ƈ̟͎̳̺̼","ɔ",
	"ⓒ⃣","ᵈ","ｄ","ᴅ","Ď","Đ͙","Ɗ̟͎̳","Ð̺̼","ⓓ⃣","ɖ","ȡ","ᵉ","ｅ","ₑ","ᴇ","È","ê","Ĕ","Ɇ͙̟","Ẹ͎̳̺̼","ǝ","ɘ","ⓔ⃣","ɛ","ȝ","ᶠ","ｆ","ꜰ","Ⅎ","ℱ","ꟻ͙","Ƒ̟͎̳̺̼",
	"ⓕ⃣","ｇ","ɢ","⅁","Ğ","Ǥ͙","ɠ̟͎̳̺̼","Ɣ","Ⓖ⃣","ʰ","ｈ","ʜ","ℍ","ℌ","Ĥ","ħ͙","ɦ̟͎","Ⱨ̳̺̼","ɥ","ⓗ⃣","ɧ","ᴵ","Ｉ","ᵢ","ⁱ","ı","ℑ","ᴉ","Ì","ï","Ĩ","Į",
	"ᶤ͙̟͎̳̺̼","Ɩ","Ⓘ⃣͙̟͎̳̺̼","ʲ","ｊ","Ｊ","ⱼ","ᴊ","Ĵ","Ĵ","ɟ","ɟ͙","ʄ","ʄ̟͎̳̺̼","ʝ","ʝ","Ⓙ","ⓙ⃣","ᵏ","ｋ","Ｋ","ᴋ͙","ƙ̟͎̳̺̼","ʞ","ʞ","ⓚ","ⓚ⃣","ˡ⃣","Ｌ","Ｌ","ʟ","ℓ",
	"ℓ","⅃","Ĺ","Ĺ","Ⱡ","ƚ","ł","Ł","ƛ͙̟","ɭ͎̳̺̼","Ĺ̯","ɬ","ɮ","ⓛ","Ⓛ⃣","ᵐ","ᵐ","ｍ","ｍ","ᴍ͙","ɱ","ɱ̟͎̳̺̼","ɯ","ⓜ","ⓜ⃣","ᴺ","ｎ","ｎ","ⁿ","ᶰ","ℕ",
	"ᴎ","Ń","Ň","Ň","ñ͙͙","Ɲ","ɳ̟̟͎͎̳̳̺̺̼̼⃣⃣","ⓝ","ⓝ","ŋ","ᵒ","Ｏ","Ｏ","ₒ","ᴏ","Ö","õ","Ǫ","Ǫ","Ő","Ø","Ø","Ỗ","ơ","Ọ","Ƣ","ợ","ⓞ","ⓞ","ᵖ","Ｐ",
	"ｐ","ᴘ","ℙ","℘͙","Ƥ̟","ꟼ͎̳̺̼","ⓟ","Ⓟ⃣","Ｑ","ℚ͙","Ɋ̟͎̳̺̼","ⓠ⃣","ʳ","ｒ","ᵣ","ʀ","ℝ","ℜ","ŕ","Ř͙","Ɽ̟͎̳̺̼","ɹ","ᴚ","ɾ","ɿ","ɿ","ⓡ⃣","ˢ","ｓ","ꜱ","Ś","Ŝ",
	"Ş͙","ʂ̟͎̳̺̼","Ƨ","ʆ","ʆ","ʅ","ⓢ⃣","ß","ᵗ","ｔ","ᴛ","Ť","ţ͙","Ƭ̟͎̳̺̼","ʇ","ȶ","ⓣ⃣","þ","Ŧ","ᵘ","ｕ","ᵤ","ᴜ","Ú","ù","ų","Ʉ","Ǘ͙̟͎̳","Ữ̺̼","ʊ","ⓤ⃣","ｖ",
	"ᵥ","ᴠ͙̟͎̳̺̼","ʋ","ʌ","ⓥ⃣","ʷ","Ｗ","ᴡ","Ŵ͙̟͎̳̺̼","ƿ","ʍ","ⓦ⃣","ˣ","ｘ","ₓ͙̟͎̳̺̼","ⓧ","Ⓧ⃣","ʸ","ｙ","ʏ","⅄","Ŷ","Ɏ","Ƴ","ʎ","Ⓨ","ᶻ","ｚ","ᴢ","ℤ","ℨ","Ź",
	"Ż","Ƶ͙","Ȥ̟","ʐ","ɀ͎","Ẕ","Ⱬ̳̺̼","ʑ","Ⓩ⃣","Ƹ","α","ά","β","Γ","Δ","έ","η","ή","ῆ","ι","ί","ἶ","κ","Λ","Μ","ν","Ξ","ό","ϻ","ρ","σ",
	"υ","ὗ","ᵠ","χ","ω","ώ","ῳ","ϝ","Ͷ","ϙ","Ϥ","Ϧ","ғ","Ԁ","ђ","ԃ","ҽ","є","ѕ","Ꙅ","ї","ј","ӄ","Ҝ","ҡ","Ќ","Қ","Һ","Ӈ","ԋ","Ҩ",
	"Ў","ү","Ӽ","Ӿ","ҳ","ѫ","ѳ","ѵ","Ѷ","ա","Բ","Գ","Ե","զ","Թ","Ժ","Լ","Ծ","Հ","Ճ","Մ","յ","Ն","Շ","Ո","չ","ռ","Վ","Տ","Ր","ք",
	"օ","ֆ","გ","ე","ზ","მ","ო","პ","ქ","ყ","ჩ","ც","ძ","ჯ","ჰ","Ⴆ","Ⴑ","א","נ","ע","ץ","ק","ש","ق","ڶ","ﻮ","ઽ","เ","ค","ง","น","ภ","ย","ร","ว",
	"ฬ","ฯ","๏","ན","ཞ","ງ","ຊ","ຖ","ຟ","ᐯ","ᑎ","ᑕ","ᑌ","ᑭ","ᒎ","ᒪ","ᕼ","᙭","ᔕ","ᖇ","ᖴ","ᗝ","ᗡ","ᗩ","ᗪ","ᗯ","ᗰ","ᗴ","ᗷ","ᙠ","Ꭴ","Ꭵ","Ꭶ","Ꭷ",
	"Ꭹ","Ꭾ","Ꮄ","Ꮆ","Ꮇ","Ꮈ","Ꮑ","Ꮒ","Ꮗ","Ꮙ","Ꮛ","Ꮢ","Ꮥ","Ꮦ","Ꮧ","Ꮭ","Ꮰ","Ꮶ","Ꮼ","Ᏸ","ᛕ","ጀ","ፈ","ፚ","ꀎ","ꀗ","ꀘ","ꀤ","ꀭ","ꀸ","ꁅ","ꁍ",
	"ꁒ","ꁕ","ꁝ","ꁴ","ꁸ","ꁹ","ꂑ","ꂦ","ꂵ","ꃃ","ꃅ","ꃳ","ꃴ","ꄘ","ꄲ","ꅏ","ꅐ","ꆂ","ꆰ","ꇓ","ꇙ","ꈤ","ꉓ","ꉔ","ꉣ","ꉧ","ꊰ","ꊼ","ꋊ","ꋪ",
	"ꋫ","ꋬ","ꌃ","ꌗ","ꌚ","ꌦ","ꌩ","ꍌ","ꍏ","ꍟ","ꎇ","ꏂ","ꏝ","ꏸ","ꐇ","ꐟ","ꑛ","꒐","꒒","꒓","꒤","꒦","꒯","꒻","꓄","꓅","ㄈ","ㄒ","ㄖ","ㄚ",
	"ㄥ","ㄩ","𝐀","𝐁","𝐂","𝐃","𝐄","𝐅","𝐆","𝐇","𝐈","𝐉","𝐊","𝐋","𝐌","𝐍","𝐎","𝐏","𝐐","𝐑","𝐒","𝐓","𝐔","𝐕","𝐖","𝐗","𝐘","𝐙","𝐚","𝐛","𝐜","𝐝","𝐞",
	"𝐟","𝐠","𝐡","𝐢","𝐣","𝐤","𝐥","𝐦","𝐧","𝐨","𝐩","𝐪","𝐫","𝐬","𝐭","𝐮","𝐯","𝐰","𝐱","𝐲","𝐳","𝐵","𝐸","𝐹","𝐻","𝐼","𝐿","𝑀","𝑅","𝑒","𝑔","𝑜","𝒆","𝒇",
	"𝒜","𝒞","𝒟","𝒢","𝒥","𝒦","𝒩","𝒪","𝒫","𝒬","𝒮","𝒯","𝒰","𝒱","𝒲","𝒳","𝒴","𝒵","𝒶","𝒷","𝒸","𝒹","𝒻","𝒽","𝒾","𝒿","𝓀","𝓁","𝓂","𝓃","𝓅","𝓆",
	"𝓇","𝓈","𝓉","𝓊","𝓋","𝓌","𝓍","𝓎","𝓏","𝓐","𝓑","𝓒","𝓓","𝓔","𝓕","𝓖","𝓗","𝓘","𝓙","𝓚","𝓛","𝓜","𝓝","𝓞","𝓟","𝓠","𝓡","𝓢","𝓣","𝓤","𝓥","𝓦",
	"𝓧","𝓨","𝓩","𝓪","𝓫","𝓬","𝓭","𝓮","𝓯","𝓰","𝓱","𝓲","𝓳","𝓴","𝓵","𝓶","𝓷","𝓸","𝓹","𝓺","𝓻","𝓼","𝓽","𝓾","𝓿","𝔀","𝔁","𝔂","𝔃","𝔄","𝔅","𝔇",
	"𝔈","𝔉","𝔊","𝔍","𝔎","𝔏","𝔐","𝔑","𝔒","𝔓","𝔔","𝔖","𝔗","𝔘","𝔙","𝔚","𝔛","𝔜","𝔞","𝔟","𝔠","𝔡","𝔢","𝔣","𝔤","𝔥","𝔦","𝔧","𝔨","𝔩","𝔪","𝔫","𝔬",
	"𝔭","𝔮","𝔯","𝔰","𝔱","𝔲","𝔳","𝔴","𝔵","𝔶","𝔷","𝔸","𝔹","𝔻","𝔼","𝔽","𝔾","𝕀","𝕁","𝕂","𝕃","𝕄","𝕆","𝕊","𝕋","𝕌","𝕍","𝕎","𝕏","𝕐","𝕒","𝕓","𝕔",
	"𝕕","𝕖","𝕗","𝕘","𝕙","𝕚","𝕛","𝕜","𝕝","𝕞","𝕟","𝕠","𝕡","𝕢","𝕣","𝕤","𝕥","𝕦","𝕧","𝕨","𝕩","𝕪","𝕫","𝕬","𝕭","𝕮","𝕯","𝕰","𝕱","𝕲","𝕳","𝕴","𝕵",
	"𝕶","𝕷","𝕸","𝕹","𝕺","𝕻","𝕼","𝕽","𝕾","𝕿","𝖀","𝖁","𝖂","𝖃","𝖄","𝖅","𝖆","𝖇","𝖈","𝖉","𝖊","𝖋","𝖌","𝖍","𝖎","𝖏","𝖐","𝖑","𝖒","𝖓","𝖔","𝖕","𝖖",
	"𝖗","𝖘","𝖙","𝖚","𝖛","𝖜","𝖝","𝖞","𝖟","𝘈","𝘉","𝘊","𝘋","𝘌","𝘍","𝘎","𝘏","𝘐","𝘑","𝘒","𝘓","𝘔","𝘕","𝘖","𝘗","𝘘","𝘙","𝘚","𝘛","𝘜","𝘝","𝘞","𝘟","𝘠",
	"𝘡","𝘢","𝘣","𝘤","𝘥","𝘦","𝘧","𝘨","𝘩","𝘪","𝘫","𝘬","𝘭","𝘮","𝘯","𝘰","𝘱","𝘲","𝘳","𝘴","𝘵","𝘶","𝘷","𝘸","𝘹","𝘺","𝘻","𝘼","𝘽","𝘾","𝘿","𝙀","𝙁","𝙂",
	"𝙃","𝙄","𝙅","𝙆","𝙇","𝙈","𝙉","𝙊","𝙋","𝙌","𝙍","𝙎","𝙏","𝙐","𝙑","𝙒","𝙓","𝙔","𝙕","𝙖","𝙗","𝙘","𝙙","𝙚","𝙛","𝙜","𝙝","𝙞","𝙟","𝙠","𝙡","𝙢","𝙣",
	"𝙤","𝙥","𝙦","𝙧","𝙨","𝙩","𝙪","𝙫","𝙬","𝙭","𝙮","𝙯","𝙰","𝙱","𝙲","𝙳","𝙴","𝙵","𝙶","𝙷","𝙸","𝙹","𝙺","𝙻","𝙼","𝙽","𝙾","𝙿","𝚀","𝚁","𝚂","𝚃","𝚄","𝚅",
	"𝚆","𝚇","𝚈","𝚉","𝚊","𝚋","𝚌","𝚍","𝚎","𝚏","𝚐","𝚑","𝚒","𝚓","𝚔","𝚕","𝚖","𝚗","𝚘","𝚙","𝚚","𝚛","𝚜","𝚝","𝚞","𝚟","𝚠","𝚡","𝚢","𝚣","🄰","🄱","🄲",
	"🄳","🄴","🄵","🄶","🄷","🄸","🄹","🄺","🄻","🄼","🄽","🄾","🄿","🅀","🅁","🅂","🅃","🅄","🅅","🅆","🅇","🅈","🅉","🅰","🅱","🅲","🅳","🅴","🅵","🅶","🅷",
	"🅸","🅹","🅺","🅻","🅼","🅽","🅾","🅿","🆀","🆁","🆂","🆃","🆄","🆅","🆆","🆇","🆈","🆉","ᄂ","ᄃ","ﾶ","丂","丅","丨","乂","乃","乇","乙","几",
	"刀","匚","卂","千","卄","卩","尺","山","爪"];
	$trashy = 0;
	$tCharArray = array();
	for($i=0; $i<count($badChars); $i++){
		$position = mb_strpos($text, $badChars[$i]);
		if($position!==false){
			$trashy++;
			$tCharArray[] = $position;
			echo "'".$badChars[$i]."' @ [".$position."]; ";
		}
	}
	for($i=0; $i<count($badChars2); $i++){
		$position2 = mb_strpos($text, $badChars2[$i]);
		if($position2!==false && $position2 >= 0 && !in_array($position2, $tCharArray)){
			$trashy++;
			$tCharArray[] = $position2;
			echo "'".$badChars2[$i]."' @ [".$position2."] (".$text[$position2]."); ";
		}
	}
	return $trashy;
}

function shady_count($text){
	$badChars = [
		"à","á","ã","ä","â",
		"è","é","ë","ė",
		"û","ú",
		"ł",
		"î","í",
		"õ","ō",
		"ñ","ń",
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









