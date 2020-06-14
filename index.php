<?php if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();
session_start();
//Pieslēgums DB
include "includes/init_sql_latest.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="lv" lang="lv">
<head>
<title>TwitĒdiens - no Twitter par ēšanu</title>
<meta name="viewport" content="width=320, initial-scale=1.0" />
<link rel="schema.DC" href="http://purl.org/dc/elements/1.1/" />
<link rel="schema.DCTERMS" href="http://purl.org/dc/terms/" />
<meta name="DC.title" lang="Latvian" content="TwitĒdiens - no Twitter par ēšanu" />
<meta name="DC.creator" content="Matīss Rikters" />
<meta name="DC.subject" lang="Latvian" content="TwitĒdiens; TwitEdiens; Twitter; Ēdiens; Food; tvīti; statistika; ēšana; dzeršana; ko ēst; ko dzert; tēja; šokolāde; mandarīni; konfektes; pica; saldējums; zupa; kafija; gaļa; kūka; pankūka; čipsi; siers; salāti; kartupeļi; ēdienu karte; ēdāju tops; ēšanas kalendārs; populārākie ēdieni; @M4t1ss; Matīss; Rikters; Matīss Rikters" />
<meta name="DC.description" lang="Latvian" content="
TwitĒdiens ievāc datus no Twitter, kur pieminēta ēšana, dzeršana, ēdienreizes, ēdieni vai dzērieni. Apskatāma detalizēta statistika par šiem datiem." />
<meta name="DC.publisher" content="Keda" />
<meta name="DC.contributor" content="Matīss Rikters" />
<meta name="DC.type" scheme="DCTERMS.DCMIType" content="Text" />
<meta name="DC.format" content="text/html" />
<meta name="DC.format" content="7635 bytes" />
<meta name="DC.identifier" scheme="DCTERMS.URI" content="http://twitediens.tk" />
<meta name="DC.language" scheme="DCTERMS.URI" content="Latvian" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta name="robots" content="index,follow" />
<meta name="description" content="TwitĒdiens ievāc datus no Twitter, kur pieminēta ēšana, dzeršana, ēdienreizes, ēdieni vai dzērieni. Apskatāma detalizēta statistika par šiem datiem."/>
<meta name="keywords" content="TwitĒdiens, TwitEdiens, Twitter, Ēdiens, Food, tvīti, statistika, ēšana, dzeršana, ko ēst, ko dzert,
tēja, šokolāde, mandarīni, konfektes, pica, saldējums, zupa, kafija, gaļa, kūka, pankūka, čipsi, siers, salāti, kartupeļi, ēdienu karte,
ēdāju tops, ēšanas kalendārs, populārākie ēdieni, @M4t1ss, Matīss, Rikters, Matīss Rikters"/>
<meta name="author" content="Matīss Rikters"/>
<link href="/includes/apple-touch-icon.png" rel="apple-touch-icon" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<script type="text/javascript" src="/includes/sorttable.js"></script>
<script type="text/javascript" src="/includes/paging.js"></script>
<link rel="stylesheet" type="text/css" href="/includes/jq/css/custom-theme/jquery-ui-1.8.16.custom.css" />	
<link rel="stylesheet" type="text/css" href="/includes/style.css" />
<link rel="stylesheet" type="text/css" href="/includes/print.css" media="print"/>
<script type="text/javascript" src="/includes/jq/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="/includes/jq/js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="/includes/jq/js/jquery.ui.datepicker-lv.js"></script>
<script type="text/javascript">
$(document).ready(function () {
$("#contents").fadeIn(1000);
});
function showHide(shID) {
	if (document.getElementById(shID)) {
		if (document.getElementById(shID+'-show').style.display != 'none') {
			document.getElementById(shID+'-show').style.display = 'none';
			document.getElementById(shID).style.display = 'block';
		}
		else {
			document.getElementById(shID+'-show').style.display = 'inline';
			document.getElementById(shID).style.display = 'none';
		}
	}
}
</script>
</head>
<body onload="initialize()">
<?php include_once("includes/analyticstracking.php") ?>
<h1 style="padding-top:3px;"><img alt="TwitĒdiens Logo" src="/img/te.png" />TwitĒdiens</h1>
<div id="top" style="padding:8px;">
<div id="nav"><a href=""><span style="opacity: 0;">.</span></a>
	<a class="htooltip" href="/"><span>Sākums</span><img alt="Sākums" title="Sākums" src="/img/sakums.png"/></a>
	<a class="htooltip" href="/draugi"><span>Draugi</span><img alt="Draugi" title="Draugi" src="/img/draugi.png"/></a>
	<a class="htooltip" href="/vardi"><span>Ēdieni</span><img alt="Ēdieni" title="Ēdieni" src="/img/edieni.png"/></a>
	<a class="htooltip" href="/kalendars"><span>Kalendārs</span><img alt="Kalendārs" title="Kalendārs" src="/img/kalend.png"/></a>
	<a class="htooltip" href="/karte"><span>Karte</span><img alt="Karte" title="Karte" src="/img/karte.png"/></a>
	<a class="htooltip" href="/tops"><span>Tops</span><img alt="Tops" title="Tops" src="/img/tops.png"/></a>
	<a class="htooltip" href="/koest"><span>Ko ēst?</span><img alt="Ko ēst?" title="Ko ēst?" src="/img/koest.png"/></a>
	<a class="htooltip" href="/statistika"><span>Statistika</span><img alt="Statistika" title="Statistika" src="/img/stat.png"/></a>
</div>
</div>
<div id="contents" style="display: none;margin-top:5px;margin-bottom:5px;padding:6px;">
<?php $id = $_GET['id']; if ( !$id || $id == "" ) { include "stream.php"; } else { include($id.".php"); } ?>
<br class="clear" />
<br/>
</div>
<div id="bottom" style="padding:8px;">
<div style="text-align:center;">
	<div style="padding:5px;font-weight:bold;">
		<a href="index.php?id=pics">Attēli</a> | 
		<a href="index.php?id=sarunas">Savstarpējie pļāpas</a> | 
		<a href="index.php?id=app/app">Mobilā lietotne</a> | 
		<a href="blog">Blogs</a> | 
		<a href="par">Par TwitĒdienu</a>
	</div>
&copy; 2011-<?php echo date('Y');?> Twitēdiens.<br/>
</div>
<div style="text-align:center;">
	<a href="http://lielakeda.lv">LielaKeda.lv</a>; 
	<a href="https://twitter.com/LielaKeda">@LielaKeda</a>; 
	<div class="vcard" style="display:inline;">
		<span class="fn" style="display:inline;">
			<a href="http://mattfoto.info/me">Matīss</a>
		</span>
		<div class="adr">
			<span class="locality">Tukums</span>, <span class="region">LV</span> 
			<span class="postal-code">3101</span>
		</div>
	</div>
</div>
</div>
<?php
$OpenInNewWindow = "1";
$BLKey = "6J6E-27JM-7U51";
if(isset($_SERVER['SCRIPT_URI']) && strlen($_SERVER['SCRIPT_URI'])){
    $_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_URI'].((strlen($_SERVER['QUERY_STRING']))?'?'.$_SERVER['QUERY_STRING']:'');
}
if(!isset($_SERVER['REQUEST_URI']) || !strlen($_SERVER['REQUEST_URI'])){
    $_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'].((isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']))?'?'.$_SERVER['QUERY_STRING']:'');
}
$QueryString  = "LinkUrl=".urlencode(((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on')?'https://':'http://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$QueryString .= "&Key=" .urlencode($BLKey);
$QueryString .= "&OpenInNewWindow=" .urlencode($OpenInNewWindow);


if(intval(get_cfg_var('allow_url_fopen')) && function_exists('readfile')) {
    @readfile("http://www.backlinks.com/engine.php?".$QueryString); 
}
elseif(intval(get_cfg_var('allow_url_fopen')) && function_exists('file')) {
    if($content = @file("http://www.backlinks.com/engine.php?".$QueryString)) 
        print @join('', $content);
}
elseif(function_exists('curl_init')) {
    $ch = curl_init ("http://www.backlinks.com/engine.php?".$QueryString);
    curl_setopt ($ch, CURLOPT_HEADER, 0);
    curl_exec ($ch);

    if(curl_error($ch))
        print "Error processing request";

    curl_close ($ch);
}
else {
    print "It appears that your web host has disabled all functions for handling remote pages and as a result the BackLinks software will not function on your web page. Please contact your web host for more information.";
}
?>
</body>
</html>