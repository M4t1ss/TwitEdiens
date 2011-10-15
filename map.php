<?php
//Pieslēgums DB
include "init_sql.php";

//Pieslēdzamies SQL serverim
$connection = @mysql_connect($db_server, $db_user, $db_password);
mysql_set_charset("utf8", $connection);
mysql_select_db($db_database);

//Paņem dažādās vietas
$q = mysql_query("SELECT distinct geo, count( * ) skaits FROM `tweets` WHERE geo!='' GROUP BY geo ORDER BY count( * ) DESC");



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
	<head>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

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
				while($r=mysql_fetch_array($q)){
				   $vieta=$r["geo"];
				   $skaits=$r["skaits"];
				   if ($skaits==1) {$tviti=" tvīts";} else {$tviti=" tvīti";}
				   //Dabū vietas koordinātas
					$string = file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=".str_replace(" ", "%20",$vieta)."&sensor=true");
					$json=json_decode($string, true);
					$lat = $json["results"][0]["geometry"]["location"]["lat"];
					$lng = $json["results"][0]["geometry"]["location"]["lng"];
					?>
					//Atzīmē vietu uz kartes
					var contentString<?php echo $i;?> = '<?php echo $vieta." - ".$skaits.$tviti;?>';
					var infowindow<?php echo $i;?> = new google.maps.InfoWindow({
						content: contentString<?php echo $i;?>
					});
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
?>
			}
		</script>
	</head>
	<body onload="initialize()">
		<div id="map_canvas" style="width:1000px; height:600px"></div>
	</body>
</html>