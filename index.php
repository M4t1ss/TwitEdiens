<?php
session_start();
//Pieslēgums DB
include "init_sql.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="lv" lang="lv">
        <script type="text/javascript" src="paging.js"></script>
<head>
<title>TwitEdiens</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<style type="text/css">
	a{text-decoration:none;color:#000;}
	#progressbar{ font: 30% "Trebuchet MS", sans-serif; margin-left:30px;}
	.sk{ margin-top:-20px;margin-left:-100px;}
	img {border-width: 0}
	* {font-family:'Lucida Grande', sans-serif;}
	#nav a {text-decoration:none;font-weight:bold;color:grey;}
	#nav a:hover {border-bottom:1px dotted red;}
	td{padding:2px;}
			.pg-normal {
				color: black;
				font-weight: normal;
				text-decoration: none;    
				cursor: pointer;    
			}
			.pg-selected {
				color: black;
				font-weight: bold;        
				text-decoration: underline;
				cursor: pointer;
			}
</style>
<script src="sorttable.js"></script>
<link type="text/css" href="jq/css/trontastic/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="jq/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="jq/js/jquery-ui-1.8.16.custom.min.js"></script>
</head>
<body>
<div id="nav">
<a href="?id=draugi">Draugi</a> | 
<a href="?id=karte">Karte</a> | 
<a href="?id=koest">Ko ēst?</a> | 
<a href="?id=tops">TOPs</a> | 
<a href="?id=dienas">Kalendārs</a> | 
<a href="?id=vardi">Vārdi</a> | 
<a href="?id=stat">Statistika</a>
</div>
<?php $id = $_GET['id']; if ( !$id || $id == "" ) { include "draugi.php"; } else { include($id.".php"); } ?>
</body>
</html>