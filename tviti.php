<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
include "includes/init_sql.php";
include "classify/evaluate_bayes.php";

//dabū 10 jaunākos tvītus
$latest = mysqli_query($connection, "SELECT * FROM tweets ORDER BY created_at DESC limit 0, 10");

$validFood = array('pārēdīsimies','pieēdīsimies','tostermaizes','šampinjoniem','sviestmaizes','siermaizītes','saēdīsimies','brokastojam',
	'brokastojām','brokastosim','brokastojat','brokastojāt','brokastojot','pusdienojam','pusdienojām','pusdienosim','pusdienojat','pusdienojāt',
	'pusdienojot','vakariņojam','vakariņojām','vakariņosim','vakariņojot','kartupeļiem','putukrējumu','grauzdiņiem','brokastiņas','ēdienreizes',
	'mandarīniem','sviestmaizi','šampanietis','lašmaizītes','kartupelīši','nogaršojam','nogaršojām','nogaršosim','nogaršojat','nogaršojāt',
	'nogaršojot','pagaršojam','pagaršojām','pagaršosim','pagaršojat','pagaršojāt','pagaršojot','pārēdīsies','pārēdīsies','pārēdamies',
	'pārēdāmies','pārēdoties','pieēdīsies','pieēdīsies','pieēdamies','pieēdāmies','pieēdoties','brokastoju','brokastošu','brokastoji',
	'brokastosi','brokastoja','jābrokasto','pusdienoju','pusdienošu','pusdienoji','pusdienosi','pusdienoja','pusdienotu','jāpusdieno',
	'vakariņoju','vakariņošu','vakariņoji','vakariņosi','vakariņoja','mandarīnus','piparkūkas','kartupeļus','ievārījumu','karbonādes',
	'šampinjonu','pankūciņas','pieēdāmies','ievārījums','saldējumus','pīrādziņus','salātiņiem','pārēdusies','pustdienas','rupjmaizes',
	'ēdienreize','greipfrūtu','piparkūkām','grauzdiņus','siermaizes','ēdienkartē','riekstiņus','nogaršoju','nogaršošu','nogaršoji','nogaršosi',
	'nogaršoja','nogaršotu','pagaršoju','pagaršošu','pagaršoji','pagaršosi','pagaršoja','pagaršotu','apēdīsiet','izēdīsiet','uzēdīsiet',
	'saēdīsies','saēdīsies','saēdamies','saēdāmies','saēdaties','saēdāties','saēdoties','pārēsties','pārēdīšos','pieēsties','pieēdīšos',
	'brokastot','brokastos','pusdienot','pusdienos','vakariņot','vakariņos','iekodīsim','uzkodīsim','brokastis','pusdienas','vakariņas',
	'brokastīs','pusdienās','vakariņās','notiesāju','notiesāšu','saldējumu','šokolādes','kartupeļu','mandarīnu','mandarīni','saldējuma',
	'Saldējums','piparkūku','dārzeņiem','degustēju','degustēšu','pierīties','pusdienās','brokastīs','vakariņās','biezpiena','konfektes',
	'karbonāde','sautējums','biezpienu','pusdienām','vakariņām','brokastīm','biezpiens','karbonādi','burkāniem','kāpostiem','plācenīši',
	'pīrādziņi','sautējumu','spinātiem','cepumiņus','pelmeņiem','kukurūzas','dzērvenes','salātiņus','apelsīnus','ananāsiem','rupjmaizi',
	'biezputru','zirnīšiem','garšīgāks','desmaizes','negaršoja','karstvīns','konfektēm','rupjmaize','majonēzes','garšojot','nogaršot','dzeršana',
	'nogaršos','pagaršot','pagaršos','apēdīsim','apēdīšot','ieēdīsim','izēdīsim','neēdīsim','neēdīšot','noēdīsim','paēdīsim','uzēdīsim',
	'saēsties','saēdīšos','jāsaēdas','pārēdies','pārēstos','pieēdies','pieēstos','brokasto','pusdieno','vakariņo','iekodīšu','iekodīsi',
	'uzkodīšu','uzkodīsi','notiesāt','pankūkas','šokolādi','pelmeņus','maizītes','šokolāde','saldumus','Apelsīnu','krēmzupa','bulciņas',
	'salātiem','degustēt','dzēriens','garšīgas','cūkgaļas','kotletes','tomātiem','brokastu','karameļu','dārzeņus','majonēzi','jāiedzer',
	'sīpoliem','pankūkām','biezzupa','ēdieniem','burkānus','jāizdzer','kumelīšu','banāniem','dzērveņu','garšīgās','kukurūzu','jāpadzer',
	'kāpostus','garšīgus','garnelēm','izdzeršu','ķiplokus','salātiņi','šokolādē','majonēze','vakariņu','konfekšu','vistiņas','maizītēm',
	'padzeršu','gurķīšus','virtuļus','krēmzupu','kotletēm','brūkleņu','šķiņķīši','cepumiņi','sieriņus','pieēdies','mellenēm','apelsīni',
	'garšoju','garšošu','garšoji','garšosi','garšoja','garšotu','jāgaršo','nogaršo','pagaršo','ēdīsiet','apēdīšu','apēdīsi','ieēdīšu',
	'ieēdīsi','izēdīšu','izēdīsi','neēdīšu','neēdīsi','noēdīšu','noēdīsi','paēdīšu','paēdīsi','uzēdīšu','uzēdīsi','saēdies','saēstos',
	'pārēdos','pārēdas','pārēdās','pieēdos','pieēdas','pieēdās','iekodīs','iekožam','iekodām','iekožot','iekostu','jāiekož','uzkodīs',
	'uzkožam','uzkodām','uzkožat','maltīte','garšīgs','garšīga','apetīte','launagā','salātus','pelmeņi','Dārzeņu','maizīti','kāpostu',
	'vīnogas','krējumu','burkānu','griķiem','garšīgi','paēstas','zemenes','kafijas','apetīti','negaršo','garšīgu','krējuma','skābeņu',
	'vaniļas','zemenēm','dārzeņi','pārtiku','ķiploku','augļiem','ēdienus','cūkgaļa','banānus','cūkgaļu','pankūku','kūciņas','āboliem',
	'mērcīti','spinātu','pupiņas','melleņu','pupiņām','tomātus','gurķiem','šašliku','cīsiņus','bulciņu','burkāni','gaileņu','krējums',
	'ribiņas','kāposti','sieriņu','garšīgo','ananāsu','maizīte','nūdeles','vistiņu','sīpolus','šprotes','desiņas','zirnīšu','mandeļu',
	'rozīnēm','apēstas','apēstās','pīrāgus','rozīnes','čipsiem','sieriņš','tefteļi','mērcīte','pelmeņu','šnicele','salātos','ķiploki','pankūka',
	'burkāns','garneļu','pārslām','ēdienam','ķīselis','pabarot','soļanku','nūdelēm','apēdusi','vistiņa','ķiršiem','dzērienu','garšot',
	'garšos','ēdīsim','ēdīšot','apēdīs','apēdam','apēdām','apēdat','apēdāt','apēdot','apēstu','ieēdīs','ieēdam','ieēdām','ieēdot','ieēstu',
	'izēdīs','izēdam','izēdām','izēdat','izēdāt','izēstu','neēdīs','neēdam','neēdām','neēdat','neēdāt','neēdot','neēstu','noēdīs','noēdam',
	'noēdām','noēdot','noēstu','paēdīs','paēdam','paēdām','paēdat','paēdāt','paēdot','paēstu','uzēdīs','uzēdam','uzēdām','uzēdat','uzēdāt',
	'uzēdot','uzēstu','saēdos','saēdas','saēdās','iekožu','iekoda','uzkožu','uzkodu','kārums','ēdiens','čipšus','kafija','končās','hesītī',
	'tomātu','salāti','maķītī','Kārums','zemeņu','tējiņu','kūciņu','sīpolu','rīsiem','griķus','griķos','kafiju','ēdienu','paēdām','končas',
	'banānu','čipsus','jāpaēd','salātu','pīrāgs','garšas','ēdiena','ķirbju','ēdieni','ēšanas','ābolus','arbūzu','kefīrs','tomāti','banāni',
	'augļus','dzeršu','kabaču','apēdām','paēdis','gardās','ķīseli','gulašs','šķiņķi','gurķus','zupiņa','tītara','ķiršus','tīteņi','mērces',
	'zupiņu','borščs','sīrupu','pīrāgu','banāns','kefīru','sīpoli','zirņus','tomāts','šņabis','cīsiņi','graužu','apēdis','tējiņa','kefīra',
	'apēsts','vafeļu','pīrāgi','uzēdām','kabači','olīvas','plūmes','avenēm','koņčas','kūciņa','garšo','ēdīšu','ēdīsi','apēst','apēdu','apēdi',
	'apēda','atēst','atēdu','ieēst','ieēdu','ieēdi','ieēda','izēst','izēdu','izēdi','izēda','neēst','neēdu','neēdi','neēda','noēst','noēdu','dzert',
	'noēdi','noēda','paēst','paēdu','paēdi','paēda','uzēst','uzēdu','uzēdi','uzēda','iekož','uzkož','ņamma','ēdusi','mērci','ābolu','gaļas',
	'kūkas','mērce','tējas','čipsi','biešu','sēnes','griķi','griķu','rīsus','mērcē','garšu','garša','zirņu','ķiršu','gurķi','aveņu','gurķu','ēdājs',
	'upeņu','āboli','ābols','aliņu','aliņš','ēšana','šņabi','siļķi','speķi','zirņi','tunča','čipsu','siļķe','ķirbi','gardā','ēdams','ķirši',
	'kūkām','diļļu','ēšanu','čipši','augļi','ēdīs','ēdam','ēdām','ēdat','ēdāt','ēdot','ēstu','jāēd','apēd','apēd','atēd','atēd','ieēd','dzer',
	'izēd','izēd','neēd','noēd','noēd','paēd','paēd','uzēd','uzēd','ēdis','tēju','kūku','tēja','gaļu','rīsi','rīšu','ēdis','sēņu','ēdām','suši',
	'laša','olām','cāļa','ogām','zupā','ēdu','ēdi','ēda','ņam','ēst','ēd');

//Load model
$model = file_get_contents("/home/baumuin/public_html/twitediens.tk/classify/model-proc2-nohash-smile-latest.json");
$classifier = new \Niiknow\Bayes();
$classifier->fromJson($model);

while($p=mysqli_fetch_array($latest)){
	$username = $p["screen_name"];
	$text = $p["text"];
	$ttime = $p["created_at"];
	$quoted_id = $p["quoted_id"];
	$quoted_text = NULL;
	$laiks = strtotime($ttime);
	$laiks = date("d.m.Y H:i", $laiks);
	
	if($quoted_id != NULL){
		$quoted = mysqli_query($connection, "SELECT text, screen_name FROM tweets WHERE id = $quoted_id");
		$qq=mysqli_fetch_array($quoted);
		if($qq){
			$quoted_text = $qq["text"];
			$quoted_screen_name = $qq["screen_name"];
		}
	}
		
	$automatic = classify($text, $classifier);
	// $automatic = "nei";
	switch ($automatic){
		case "pos":
			$color = "#00FF00";
			break;
		case "neg":
			$color = "#FF3D3D";
			break;
		case "nei":
			$color = "black";
			break;
		default:
			$color = "black";
	}
	
	#Iekrāso un izveido saiti uz katru pieminēto lietotāju tekstā
	#Šo vajadzētu visur...
	
	$txtCol = "#229cec";
	foreach($validFood as $foodItem){
		if(!preg_match("/(?<=\>)$foodItem/", $text) && !preg_match("/$foodItem(?=\<)/", $text)){
			if(preg_match("/(?<=[\W])$foodItem(?=[\W])/", $text))
				$text = preg_replace("/(?<=[\W])($foodItem)(?=[\W])/", '<a style="text-decoration:none;color:'.$txtCol.';" href="/atslegvards/'.$foodItem.'">'.$foodItem.'</a>', $text,1);
			elseif(preg_match("/(?<=[\W])$foodItem$/", $text))
				$text = preg_replace("/(?<=[\W])($foodItem)$/", '<a style="text-decoration:none;color:'.$txtCol.';" href="/atslegvards/'.$foodItem.'">'.$foodItem.'</a>', $text,1);
			elseif(preg_match("/^$foodItem(?=[\W])/", $text))
				$text = preg_replace("/^($foodItem)(?=[\W])/", '<a style="text-decoration:none;color:'.$txtCol.';" href="/atslegvards/'.$foodItem.'">'.$foodItem.'</a>', $text,1);
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
	
?>
<div style="<?php if ((time()-StrToTime($ttime))<5){echo"opacity:".((time()-StrToTime($ttime))/5).";";}?>" class="tweet">
	<div class="lietotajs" style="border-bottom: 0.18em dashed <?php echo $color; ?>;"><?php echo '<a style="text-decoration:none;color:#658304;" href="/draugs/'.trim($username).'">@'.trim($username).'</a> ';?> ( <?php echo $laiks;?> )</div>
<?php echo $text."<br/>";

if(isset($quoted_text) && strlen($quoted_text) > 0){
	echo "<div style='border:1px dotted #000; border-radius:5px; padding:2px;'><small>";
	echo '<a style="text-decoration:none;color:#658304;" href="/draugs/'.str_replace('@','',trim($quoted_screen_name)).'">@'.trim($quoted_screen_name).'</a>: ';
	echo $quoted_text."</small></div><br/>";
}
?><br/>
</div>
<?php
}
?>