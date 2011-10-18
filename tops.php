<h1 style='margin:auto auto; text-align:center;'>Twitter gardēžu TOPS</h1>
<br/>
<div style='margin:auto auto; width:260px;text-align:center;'>
<?php
$krasa=TRUE;
$i=1;
echo "<table style='text-align:center;'>";
echo "<tr>
<th>Vieta</th>
<th>Lietotājs</th>
<th>Tvītu skaits</th>
</tr>";
$q = mysql_query("SELECT screen_name, count( * ) skaits FROM tweets GROUP BY screen_name ORDER BY count( * ) DESC LIMIT 0 , 15");
while($r=mysql_fetch_array($q)){
if ($krasa==TRUE) {$kr=" style='background-color:#E0E0E0'";}else{$kr="";}
$vards=$r["screen_name"];
$skaits=$r["skaits"];
echo "<tr".$kr."><td>".$i.".</td><td><b><a style='text-decoration:none;color:#658304;' href='https://twitter.com/#!/".$vards."'>".$vards."</a></b></td><td>".$skaits." tvīti</td></tr>";
$krasa=!$krasa;
$i++;
}
echo "</table>";
?>
</div>