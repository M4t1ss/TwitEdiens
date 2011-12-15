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
<script type="text/javascript" src="/TwitEdiens/includes/sorttable.js"></script>
<script type="text/javascript" src="/TwitEdiens/includes/paging.js"></script>
<link rel="stylesheet" type="text/css" href="/TwitEdiens/includes/jq/css/custom-theme/jquery-ui-1.8.16.custom.css" />	
<link rel="stylesheet" type="text/css" href="/TwitEdiens/includes/tag/css/wordcloud.css">
<link rel="stylesheet" type="text/css" href="/TwitEdiens/includes/style.css" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<script type="text/javascript" src="/TwitEdiens/includes/jq/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="/TwitEdiens/includes/jq/js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="/TwitEdiens/includes/jq/js/jquery.ui.datepicker-lv.js"></script>
<link rel="stylesheet" type="text/css" href="/TwitEdiens/includes/tooltip/style.css" />
<script type="text/javascript">
$(document).ready(function () {
$("#contents").fadeIn(1000);
});
</script>
</head>
<body onload="initialize()">
<?php include_once("includes/analyticstracking.php") ?>


<h1 style="padding-top:3px;"><img src="/TwitEdiens/img/te.png" />TwitĒdiens</h1>
<div id="top" style="padding:8px;">
<div id="nav">
<a href="/TwitEdiens/draugi">Draugi</a> | 
<a href="/TwitEdiens/vardi">Vārdi</a> | 
<a href="/TwitEdiens/kalendars">Kalendārs</a> | 
<a href="/TwitEdiens/karte">Karte</a> | 
<a href="/TwitEdiens/tops">TOPs</a> | 
<a href="/TwitEdiens/koest">Ko ēst?</a> | 
<a href="/TwitEdiens/statistika">Statistika</a>
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
</body>
</html>