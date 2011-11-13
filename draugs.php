<?php
session_start();
require_once('auth/twitteroauth/twitteroauth.php');
require_once('auth/config.php');
include 'includes/tag/classes/wordcloud.class.php';
//ja nav norādīts draugs, ej prom...
if (!isset($_GET['dra']))   echo "<script type=\"text/javascript\">setTimeout(\"window.location = 'index.php'\",5);</script>";
$draugs = $_GET['dra'];

//Ja nav pieslēdzies, pārsūta uz pieslēgšanās lapu
if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
//Ja ir pieslēdzies
}else{
$access_token = $_SESSION['access_token'];
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
$usr = $connection->get('users/show', array('screen_name' => $draugs));
$vaards = $usr->{'name'};
}
?>
<script>
$(function() {
$("#tabs").tabs({            
                        //event: 'mouseover'
                fx: { height: 'toggle', opacity: 'toggle'},
                show: function(event, ui) {
                          if (ui.panel.id == "tabs-4") {
                                  $(ui.panel).css("height","100%")
                                initialize()
                                }}
                });
});

</script>
<h2 style='margin:auto auto; text-align:center;'>@<?php echo $draugs;?></h2>
<h4 style='margin:auto auto; text-align:center;'><?php echo $vaards;?></h4>
<br/>
<div id="tabs">
<ul>
	<li><a href="#tabs-1">Tvīti</a></li>
	<li><a href="#tabs-2">Kalendārs</a></li>
	<li><a href="#tabs-3">Vārdi</a></li>
	<li><a href="#tabs-4">Karte</a></li>
</ul>
<div id="tabs-1">
<?php
$q = mysql_query("SELECT id, text, created_at FROM tweets where screen_name='$draugs' order by created_at desc");
if (mysql_num_rows($q)){

//visi savāktie konkrētā lietotāja tvīti
$krasa=TRUE;
echo "<table id='results' class='sortable' style='margin:auto auto;border-spacing:0px;border:1px solid white;'>";
echo "<tr>
<th>Tvīts</th>
<th style='width:135px;'>Ēdieni / dzērieni</th>
<th style='width:135px;'>Laiks</th>
</tr>";
			while($r=mysql_fetch_array($q)){
				$tvid = $r["id"];
				$q2 = mysql_query("SELECT distinct nominativs FROM words where tvits='$tvid' and nominativs!='0'");
				if ($krasa==TRUE) {$kr=" class='even'";}else{$kr="";}
				$teksts=$r["text"];
				$laiks=$r["created_at"];
				$laiks=strtotime($laiks);
				$laiks=date("m.d.Y H:i", $laiks);
				echo "<tr".$kr."><td>".$teksts."</td><td>";
				while($r2=mysql_fetch_array($q2)){echo $r2["nominativs"].", ";};
				echo "</td><td>".$laiks."</td></tr>";
				$krasa=!$krasa;
			}
echo "</table>";
}else{
echo $draugs." vēl nav tvītojis par ēšanu.";
}
?>
<div style="margin:auto auto; text-align:center;" id="pageNavPosition"></div>
<script type="text/javascript"><!--
	var pager = new Pager('results', 10); 
	pager.init(); 
	pager.showPageNav('pager', 'pageNavPosition'); 
	pager.showPage(1);
//--></script>
</div>

<div id="tabs-2">
<?php
//cikos un kādās dienās tvītots
$q = mysql_query("SELECT created_at FROM `tweets` WHERE screen_name = '$draugs'");
?>
<h2 style='margin:auto auto; text-align:center;'>Ēšanas kalendārs</h2>
<br/>
<div style='margin:auto auto;width:500px;'>
<?php
if (mysql_num_rows($q)){
?>
<h3>Cikos tvīto visbiežāk</h3>
<?php

//jādabū visas dienas Mon-Sun...
//šitā ir pirmdiena...sāksim ar to
$theDate = '2011-10-31';
$timeStamp = StrToTime($theDate);
for($zb=0;$zb<7;$zb++) {
$ddd = date('D', $timeStamp); 
$timeStamp = StrToTime('+1 days', $timeStamp);
$dienas[$ddd][skaits]=0;
}

//dabū šodienas datumu
$menesiss = $menesis = date("m");
$dienasz = $diena = date("d");
$gadss = $gads = date("Y");
//izrēķina datumu pirms mēneša
$menesis--;
if($menesis==0){
	$menesis=12;
	$gads--;
}
$max=0;
$maxd=0;
for($zb=0;$zb<24;$zb++) $stundas[$zb][skaits]=0;

while($r=mysql_fetch_array($q)){
	$laiks=$r["created_at"];
	$laiks=strtotime($laiks);
	$diena=date("D", $laiks);
	$laiks=date("G", $laiks);
	$dienas[$diena][skaits]++;
	$stundas[$laiks][skaits]++;
	if($stundas[$laiks][skaits]>$max) $max=$stundas[$laiks][skaits];
	if($dienas[$diena][skaits]>$maxd) $maxd=$dienas[$diena][skaits];
}

//izdrukā populārākās stundas
for($zb=0;$zb<24;$zb++) {
$percent = round($stundas[$zb][skaits]/$max*100);
if ($percent>0){
?>
<script type="text/javascript">
	$(function(){
		$("#progressbar<?php echo $zb;?>").progressbar({
			value: <?php echo $percent;?>
		});		
	});
</script>
<div style=" font: 50% 'Trebuchet MS', sans-serif;" id="progressbar<?php echo $zb;?>"></div>
<div class="sk" style="margin-left:-110px;"><?php echo $zb.":00 - ".($zb+1).":00";?></div>
</br>
<?php
}
}
?>
</div>
<br/>
<h3>Kurās dienās tvīto visbiežāk</h3>
<div style='margin:auto auto;width:500px;'>
<?php
$theDate = '2011-10-31';
$timeStamp = StrToTime($theDate);
//izdrukā populārākās dienas
for($zb=0;$zb<7;$zb++) {
$ddd = date('D', $timeStamp); 
$timeStamp = StrToTime('+1 days', $timeStamp);
$percent = round($dienas[$ddd][skaits]/$maxd*100);
if ($percent>0){
?>
<script type="text/javascript">
	$(function(){
		$("#progressbar<?php echo $ddd;?>").progressbar({
			value: <?php echo $percent;?>
		});		
	});
</script>
<div style=" font: 50% 'Trebuchet MS', sans-serif;" id="progressbar<?php echo $ddd;?>"></div>
<div class="sk"><?php
switch ($ddd) {
    case 'Mon':
        echo "Pirmdien";
        break;
    case 'Tue':
        echo "Otrdien";
        break;
    case 'Wed':
        echo "Trešdien";
        break;
    case 'Thu':
        echo "Ceturtdien";
        break;
    case 'Fri':
        echo "Piektdien";
        break;
    case 'Sat':
        echo "Sestdien";
        break;
    case 'Sun':
        echo "Svētdien";
        break;
}
?></div>
</br>
<?php
}
}
}else{
echo $draugs." vēl nav tvītojis par ēšanu.";
}
?>
</div>
</div>
<div id="tabs-3">
<h2 style='margin:auto auto; text-align:center;'>pieminētie ēdieni / dzērieni</h2>
<br/>
<?php
$vardi = mysql_query("select id, nominativs from tweets, words where tweets.screen_name = '$draugs' and words.tvits = tweets.id and nominativs != '0'");
if (mysql_num_rows($vardi)){
$cloud = new wordCloud();
//jāuztaisa vēl, lai, uzklikojot uz kādu ēdienu, atvērtu visus tvītus, kas to pieminējuši...
while($r=mysql_fetch_array($vardi)){
	$nom = $r["nominativs"];
	$cloud->addWord(array('word' => $nom, 'url' => '?id=vards&vards='.urlencode($nom)));
}
$cloud->orderBy('size', 'desc');
$myCloud = $cloud->showCloud('array');
foreach ($myCloud as $cloudArray) {
  echo ' &nbsp; <a href="'.$cloudArray['url'].'" class="word size'.$cloudArray['range'].'">'.$cloudArray['word'].'</a> &nbsp;';
}
}else{
echo $draugs." vēl nav pieminējis nevienu ēdienu vai dzērienu.";
}
?>
</div>
<div id="tabs-4">
<h2 style='margin:auto auto; text-align:center;'><?php echo $draugs;?> tvītu karte</h2>
<?php
//Paņem dažādās vietas
?>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
		<script type="text/javascript">
			function initialize() {
				var latlng = new google.maps.LatLng(56.9465363, 24.1048503);
				var settings = {
					zoom: 7,
					center: latlng,
					mapTypeId: google.maps.MapTypeId.ROADMAP};
				var map = new google.maps.Map(document.getElementById("map_canvas"), settings);
<?php
				$i=0;
				$map = mysql_query("SELECT distinct geo, count( * ) skaits FROM `tweets` WHERE geo!='' and screen_name = '$draugs' GROUP BY geo ORDER BY count( * ) DESC");
				while($r=mysql_fetch_array($map)){
				   $vieta=$r["geo"];
				   $skaits=$r["skaits"];
				   if ($skaits==1) {$tviti=" tvīts";} else {$tviti=" tvīti";}
					$irvieta = mysql_query("SELECT * FROM vietas where nosaukums='$vieta'");
					if(mysql_num_rows($irvieta)==0){
						//ja nav tādas vietas datu bāzē,
						//dabū vietas koordinātas
						$string = file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=".str_replace(" ", "%20",$vieta)."&sensor=true");
						$json=json_decode($string, true);
						$lat = $json["results"][0]["geometry"]["location"]["lat"];
						$lng = $json["results"][0]["geometry"]["location"]["lng"];
						if ($lat!=0 && $lng!=0){
							$ok = mysql_query("INSERT INTO vietas (nosaukums, lng, lat) VALUES ('$vieta', '$lng', '$lat')");
						}
						}else{
							$arr=mysql_fetch_array($irvieta);
							//ja ir
							$lat = $arr['lat'];
							$lng = $arr['lng'];
						}
					if ($lat & $lng){
					?>
					//Apraksts
					var contentString<?php echo $i;?> = '<?php echo $vieta." - ".$skaits.$tviti." par ēšanas tēmām";?>';
					var infowindow<?php echo $i;?> = new google.maps.InfoWindow({
						content: contentString<?php echo $i;?>
					});
						
					//Atzīmē vietu kartē
					var parkingPos = new google.maps.LatLng(<?php echo $lat;?>, <?php echo $lng;?>);
					var marker<?php echo $i;?> = new google.maps.Marker({
						position: parkingPos,
						map: map,
						title:"<?php echo $vieta;?>"
					});
					google.maps.event.addListener(marker<?php echo $i;?>, 'click', function() {
					  infowindow<?php echo $i;?>.open(map,marker<?php echo $i;?>);
					});
					<?php
					$i=$i+1;
					}
				}
?>
			}
		</script>
		<div id="map_canvas" style="margin:auto auto; width:900px; height:520px"></div>
</div>
</div>