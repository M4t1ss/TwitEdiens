<h2 style='margin:auto auto; text-align:center;'>Jaunākie tvīti un attēli</h2>
<script type="text/javascript">
var isOpera = !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
    // Opera 8.0+ (UA detection to detect Blink/v8-powered Opera)
var isFirefox = typeof InstallTrigger !== 'undefined';   // Firefox 1.0+
var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
    // At least Safari 3+: "[object HTMLElementConstructor]"
var isChrome = !!window.chrome && !isOpera;              // Chrome 1+
var isIE = /*@cc_on!@*/false || !!document.documentMode;   // At least IE6
$.ajaxSetup ({
    // Disable caching of AJAX responses
    cache: false
});
$(document).ready(function(){
	$("#content").load("tviti.php");
	$("#photos").load("loader.php");
	
	setInterval(function() {
		$("#content").load("tviti.php");
	}, 3000);
	if(!isOpera && !isChrome){
		setInterval(function() {
			$("#photos").load("loader.php");
		}, 60000);
	}
});

</script>

<div style="width: 100%;display: block;">
	<div id="content">
		<img src="/img/burg.gif" style="height:64px; text-align:center;" />
	</div>

	<div id="content2">
		<section id="photos">
			<img src="/img/appl.gif" style="height:64px; text-align:center;" />
			<img src="/img/appl.gif" style="height:64px; text-align:center;" />
			<img src="/img/appl.gif" style="height:64px; text-align:center;" />
			<img src="/img/appl.gif" style="height:64px; text-align:center;" />
			<img src="/img/appl.gif" style="height:64px; text-align:center;" />
			<img src="/img/appl.gif" style="height:64px; text-align:center;" />
			<img src="/img/appl.gif" style="height:64px; text-align:center;" />
			<img src="/img/appl.gif" style="height:64px; text-align:center;" />
			<img src="/img/appl.gif" style="height:64px; text-align:center;" />
			<img src="/img/appl.gif" style="height:64px; text-align:center;" />
			<img src="/img/appl.gif" style="height:64px; text-align:center;" />
			<img src="/img/appl.gif" style="height:64px; text-align:center;" />
			<img src="/img/appl.gif" style="height:64px; text-align:center;" />
			<img src="/img/appl.gif" style="height:64px; text-align:center;" />
			<img src="/img/appl.gif" style="height:64px; text-align:center;" />
			<img src="/img/appl.gif" style="height:64px; text-align:center;" />
		</section>
	</div>
</div>

<br style="clear: both;">

<div style="margin:30px; background-color:#E7FFFE;background-opacity:0.2;border-radius:15px;padding:15px;border:2px solid #FFF;display: block;">
	TwitĒdiens ievāc datus no Twitter
	- visus tvītus, kur kaut kas minēts par ēšanu, dzeršanu (apēdu, izdzēru, ...)
	ēdienreizēm (pusdienas, brokastis, vakariņas, ...) vai ēdieniem, dzērieniem 
	(tēja, šokolāde, kafija, gaļa, saldējums, pankūka, kartupeļi, kūka, pelmeņi, ...).
	Šos datus sakārto, noformē un analizē dažādos griezumos. 
	Šajā tīmekļa vietnē iespējams apskatīt šo analīžu rezultātus. 
	<a href="/par" style="text-decoration:underline">Vairāk par TwitĒdienu</a><br/><br/>
	<a href="#" id="example-show" class="showLink" 
	onclick="showHide('example');return false;">Sazinies ar autoru</a>
	<div id="example" class="more">
		<form id="forma" action="MAILTO:twitediens@lielakeda.lv" method="post" enctype="text/plain">
		<div><input type="text" name="name" value="Tavs vārds"/><br/></div>
		<div><input type="text" name="mail" value="E-pasts"/><br/></div>
		<div><input type="text" name="comment" value="Ziņojums"/><br/></div>
		<div><input type="submit" value="Sūtīt"/></div>
	</form>
	<a href="#" id="example-hide" class="hideLink" 
	onclick="showHide('example');return false;">Paslēpt</a>
	</div>
</div>
