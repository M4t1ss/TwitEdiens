<?php
session_start();
//Pieslēgums DB
include "init_sql.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="lv" lang="lv">
<head>
<title>TwitEdiens</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<style type="text/css">
  img {border-width: 0}
  * {font-family:'Lucida Grande', sans-serif;}
  #nav a {text-decoration:none;font-weight:bold;color:grey;}
  #nav a:hover {border-bottom:1px dotted red;}
  td{padding:2px;}
</style>
<script src="sorttable.js"></script>
</head>
<body>
<div id="nav">
<a href="?id=draugi">Draugi</a> | 
<a href="?id=karte">Karte</a> | 
<a href="?id=tops">TOPs</a> | 
<a href="?id=stat">Statitika</a>
</div>
<?php $id = $_GET['id']; if ( !$id || $id == "" ) { include "draugi.php"; } else { include($id.".php"); } ?>
</body>
</html>