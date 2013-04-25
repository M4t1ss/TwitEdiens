<?php
include "includes/init_sql.php";
?>
<div style="margin:30px; background-color:#E7FFFE;background-opacity:0.2;border-radius:15px;padding:15px;border:2px solid #FFF;">
	TwitĒdiens ievāc datus no <a style="font-weight:bold;" href="http://twitter.com">Twitter</a>
	- visus tvītus, kur kaut kas minēts par ēšanu, dzeršanu (apēdu, izdzēru, ...)
	ēdienreizēm (pusdienas, brokastis, vakariņas, ...) vai ēdieniem, dzērieniem 
	(tēja, šokolāde, kafija, gaļa, saldējums, pankūka, kartupeļi, kūka, pelmeņi, ...).
	Šos datus sakārto, noformē un analizē dažādos griezumos. 
	Šajā tīmekļa vietnē iespējams apskatīt šo analīžu rezultātus. 
	<a href="/par" style="text-decoration:underline">Vairāk par TwitĒdienu</a><br/><br/>
	<a href="#" id="example-show" class="showLink" 
	onclick="showHide('example');return false;">Sazinies ar autoru</a>
	<div id="example" class="more">
		<form id="forma" action="MAILTO:matiss@lielakeda.lv" method="post" enctype="text/plain">
		<div><input type="text" name="name" value="Tavs vārds"/><br/></div>
		<div><input type="text" name="mail" value="E-pasts"/><br/></div>
		<div><input type="text" name="comment" value="Ziņojums"/><br/></div>
		<div><input type="submit" value="Sūtīt"/></div>
	</form>
	<a href="#" id="example-hide" class="hideLink" 
	onclick="showHide('example');return false;">Paslēpt</a>
	</div>
</div>

<h2 style='margin:auto auto; text-align:center;'>Jaunākie tvīti</h2>
<p style='margin:auto auto; text-align:center;font-size:0.8em;'>(reālā laikā)</p>
<script type="text/javascript">
$(function() {
	setInterval(function() {
    $("#content").load(location.href+" #content>*","");
}, 1500);
});
</script>
<?php
//dabū 10 jaunākos tvītus
$latest = mysql_query("SELECT * FROM tweets ORDER BY created_at DESC limit 0, 10");
?>

<div id="content" style='margin:auto auto;width:700px;'>
<?php
while($p=mysql_fetch_array($latest)){
	$username = $p["screen_name"];
	$text = $p["text"];
	$ttime = $p["created_at"];
?>
<div style="<?php if ((time()-StrToTime($ttime))<5){echo"opacity:".((time()-StrToTime($ttime))/5).";";}?>" class="tweet">
<div class="lietotajs"><?php echo "@".$username;?> ( <?php echo $ttime;?> )</div>
<?php echo $text."<br/>";
?><br/>
</div>
<?php
}
?>
</div>