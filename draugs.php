<?php
//ja nav norādīts draugs, ej prom...
if (!isset($_GET['dra']))   echo "<script type=\"text/javascript\">setTimeout(\"window.location = 'index.php'\",5);</script>";
$draugs = $_GET['dra'];
?>
<h1 style='margin:auto auto; text-align:center;'>Tavi Twitter draugi, kas tvītos pieminējuši ēšanu</h1>
<h2 style='margin:auto auto; text-align:center;'><?php echo $draugs;?></h2>
<?php

$krasa=TRUE;
echo "<table id='results' class='sortable' style='margin:auto auto;'>";
echo "<tr>
<th>Tvīts</th>
<th style='width:135px;'>Ēdieni / dzērieni</th>
<th style='width:135px;'>Laiks</th>
</tr>";
			$q = mysql_query("SELECT id, text, created_at FROM tweets where screen_name='$draugs' order by created_at desc");
			while($r=mysql_fetch_array($q)){
				$tvid = $r["id"];
				$q2 = mysql_query("SELECT distinct nominativs FROM words where tvits='$tvid' and nominativs!='0'");
				if ($krasa==TRUE) {$kr=" style='background-color:#E0E0E0'";}else{$kr="";}
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
?>
<div style="margin:auto auto; text-align:center;" id="pageNavPosition"></div>
<script type="text/javascript"><!--
	var pager = new Pager('results', 10); 
	pager.init(); 
	pager.showPageNav('pager', 'pageNavPosition'); 
	pager.showPage(1);
//--></script>