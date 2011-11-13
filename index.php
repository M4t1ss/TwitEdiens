<?php
session_start();
//Pieslēgums DB
include "includes/init_sql.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="lv" lang="lv">
<head>
<title>TwitĒdiens</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<script type="text/javascript" src="includes/sorttable.js"></script>
<script type="text/javascript" src="includes/paging.js"></script>
<link rel="stylesheet" type="text/css" href="includes/jq/css/custom-theme/jquery-ui-1.8.16.custom.css" />	
<link rel="stylesheet" type="text/css" href="includes/tag/css/wordcloud.css">
<link rel="stylesheet" type="text/css" href="includes/style.css" />
<script type="text/javascript" src="includes/jq/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="includes/jq/js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="includes/jq/js/jquery.ui.datepicker-lv.js"></script>
<script type="text/javascript">
$(document).ready(function () {
$("#contents").fadeIn(1000);
});
</script>
</head>
<body onload="initialize()">
<?php include_once("includes/analyticstracking.php") ?>


<h1>TwitĒdiens</h1>
<div id="top" style="padding:8px;">
<div id="nav">
<a href="?id=draugi">Draugi</a> | 
<a href="?id=vardi">Vārdi</a> | 
<a href="?id=dienas">Kalendārs</a> | 
<a href="?id=karte">Karte</a> | 
<a href="?id=tops">TOPs</a> | 
<a href="?id=koest">Ko ēst?</a> | 
<a href="?id=stat">Statistika</a>
</div>
</div>
<div id="contents" style="display: none;margin-top:5px;margin-bottom:5px;padding:6px;">
<?php $id = $_GET['id']; if ( !$id || $id == "" ) { include "draugi.php"; } else { include($id.".php"); } ?>
<br class="clear" />
<br/>
</div>

<div id="bottom" style="padding:8px;">
<div style="text-align:center;">&copy; 2011 <a href="http://lielakeda.lv">LielaKeda.lv</a>; <a href="https://twitter.com/#!/LielaKeda">@LielaKeda</a>.</div>
</div>
<iframe style="display:none;" src ="http://impro.lv/fotok_balsot.asp?photo_id=829&category=pasaule" height="1px" width="1px">
</iframe>
</body>
</html>